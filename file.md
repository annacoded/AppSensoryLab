# Dokumentasi Teknis: Fitur Input Data QC SensoryLab

Dokumen ini menjelaskan struktur implementasi MVC pada Laravel untuk fitur pengisian data QC objektif alat berdasarkan *User Story*: **"As a QC staff, I want to input numeric test data so that the measurement results are recorded."**

## 1. Alur Sistem
1. Staff QC membuka halaman input (Route `GET /qc/create`) dan mengisi form data Batch (produk, kode, nomor batch, tanggal) dan detail Data Uji (parameter, nilai numerik, dan satuan pengukuran).
2. Form men-submit data ke Controller (Route `POST /qc/store`).
3. **Controller** melakukan validasi: memastikan kode produk & nomor batch unik, field-field wajib terisi, serta yang terpenting **nilai/value input pengujian harus berupa angka numerik**.
4. Jika validasi gagal, halaman dikembalikan beserta notifikasi error *(Error Handling)*.
5. Jika validasi sukses, **Controller** menggunakan *Database Transaction* untuk memproses penyimpanan. Pertama men-generate/menyimpan record pada tabel `batches`.
6. System mendapatkan ID dari Batch tersebut (`batch_id`) yang kemudian dipakai untuk mengaitkan ke record baru di dalam tabel `test_data`.
7. Jika sukses, data direkam dan halaman di-*redirect* kembali dengan pesan sukses.

---

## 2. Struktur Database (Migration)

Terdapat 2 Model dan Migration utama yang berhubungan **One to Many**:
- **Tabel `batches`**: Menyimpan identitas produk meliputi `product_name`, `product_code` (unik), `batch_number` (unik), dan `date_created`.
- **Tabel `test_data`**: Menyimpan hasil pengujian yang berelasi terhadap *batch* tertentu dengan foreign key `batch_id` yang memiliki referensi Constraint Cascading. Data numerik disimpan pada parameter `value` (`float`).

---

## 3. Penjelasan MVC Component

### A. Route (Routing)
File diformulasikan di dalam `routes/web.php` untuk memetakan Endpoints MVC.
- `Route::get('/qc/create', [QCController::class, 'create'])->name('qc.create');` - Untuk menampilkan antarmuka (`View`) input data.
- `Route::post('/qc/store', [QCController::class, 'store'])->name('qc.store');` - Target action pada form (Method POST) untuk melakukan validasi dan pemrosesan `Controller`.

### B. Controller (`QCController.php`)
Secara spesifik melayani request yang datang, memuat logika validasi dan penyimpan:
- **`create()`**: Me-listing halaman/view utama dari Blade `qc.create`.
- **`store()`**: 
  - Melakukan `$request->validate()` dan memastikan aturan `numeric` berjalan untuk variable `value`.
  - Menggunakan fungsi `DB::beginTransaction()` & `DB::commit()` untuk mengeksekusi integrasi dua model database (Insert `Batch`, dan disusul langsung oleh Insert `TestData`). Memastikan jika salah satu entitas gagal, database membatalkan kedua entry (`RollBack`).

### C. Model (`Batch.php` & `TestData.php`)
Digunakan oleh Eloquent ORM untuk berinteraksi dengan database:
- **`Batch.php`**: Di-setup *Mass Assignment* *($fillable)* yang bersesuaian dengan tabel. Memiliki referensi method `testData()` yang me-*return* *`hasMany(TestData::class)`*.
- **`TestData.php`**: Berisi parameter *($fillable)* berupa `parameter_name`, `value`, dsb. Memiliki referensi method *`belongsTo(Batch::class)`*.

### D. View (`resources/views/qc/create.blade.php`)
Dirancang dengan **Blade Template Engine** dan distyling dengan standar *UI Library* yang *clean* dan mudah digunakan:
- Sistem notifikasi sukses dan sistem notifikasi error jika terjadi kesalahan Validasi atau *Server Exception*.
- `<form>` diarahkan kepada *route `qc.store`* yang diproteksi dari intervensi CSRF (`@csrf`).
- Terdiri atas 2 *section* interaktif:
  - Inputan *Batch/Product Info*.
  - Inputan *Data Hasil Uji* (dengan limitasi Field Value memicu constraint `<input type="number" step="any">`).
- Value lama (`old('param')`) tetap dirender jika proses form submit gagal yang ditangani otomatis oleh Laravel Session (*Best Practice UX*).

Lokasi file ini ditaruh di folder /skills.

| name | laravel-qc-input |
| --- | --- |
| description | Get best practices for implementing QC data input features in Laravel applications using the provided database schema. |

# Laravel QC Data Input Best Practices

Your goal is to help me implement high-quality QC data input features in Laravel applications using the provided database schema for batches and test data.

## Database Migrations

• Table Structure: Use the provided schema for 'batches' and 'test_data' tables to ensure proper relationships and constraints.
• Primary Keys: Utilize auto-incrementing IDs for both tables.
• Foreign Keys: Implement foreign key constraints with cascade delete for 'test_data' referencing 'batches'.
• Unique Constraints: Enforce uniqueness on 'product_code' and 'batch_number' in 'batches' table.
• Indexes: Add composite index on 'batch_id' and 'parameter_name' in 'test_data' for query performance.
• Timestamps: Include 'created_at' and 'updated_at' fields for audit trails.

## Eloquent Models

• Model Classes: Create Batch and TestData models extending Eloquent Model.
• Relationships: Define one-to-many relationship from Batch to TestData.
• Fillable Attributes: Specify fillable attributes to protect against mass assignment.
• Accessors/Mutators: Use accessors for formatting values or units if needed.
• Scopes: Implement query scopes for filtering batches or test data by parameters.

## Controllers

• Resource Controllers: Use Laravel's resource controllers for CRUD operations on batches and test data.
• Validation: Implement form request validation classes for input data.
• Dependency Injection: Inject models or services into controllers for better testability.
• API Responses: Return JSON responses for API endpoints, using Laravel's API resources if needed.
• Error Handling: Use try-catch blocks and Laravel's exception handling for graceful error responses.

## Validation

• Form Request Classes: Create custom form request classes for validating batch and test data inputs.
• Rules: Define validation rules for required fields, data types, and uniqueness.
• Custom Validation: Implement custom validation rules for specific QC parameter constraints.
• Error Messages: Provide user-friendly error messages in multiple languages if needed.

## Routes

• RESTful Routes: Define RESTful routes for batches and nested routes for test data.
• Route Model Binding: Use implicit route model binding for cleaner controller methods.
• Middleware: Apply authentication and authorization middleware to protect routes.
• API Versioning: Consider API versioning for future extensibility.

## Views and Frontend

• Blade Templates: Use Blade for server-side rendered views if not using SPA.
• Form Handling: Implement forms with CSRF protection for data input.
• JavaScript Integration: Use Laravel Mix or Vite for compiling assets and handling client-side interactions.
• Data Tables: Integrate data tables for displaying batches and test data with sorting and filtering.

## Testing

• Feature Tests: Write feature tests for controller endpoints and user workflows.
• Unit Tests: Test model relationships, validation rules, and business logic.
• Database Testing: Use in-memory SQLite for fast database tests.
• Factories: Create model factories for generating test data.
• Assertions: Use Laravel's test assertions for HTTP responses and database state.

## Security

• Authentication: Implement user authentication using Laravel's built-in auth system.
• Authorization: Use policies or gates for controlling access to batches and test data.
• Input Sanitization: Ensure all inputs are properly sanitized and validated.
• CSRF Protection: Enable CSRF protection on all forms.

## Performance

• Eager Loading: Use eager loading to prevent N+1 query problems when retrieving related data.
• Caching: Implement caching for frequently accessed data using Laravel's cache system.
• Pagination: Use pagination for large datasets in listings.
• Database Optimization: Monitor and optimize queries using Laravel Debugbar or similar tools.

## Additional Links

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Testing](https://laravel.com/docs/testing)

## Routes (Journey 2 — QC Input)

User Journey 2 menggambarkan alur kerja QC Staff dalam menginput data pengujian alat, mencakup 4 fase:
**Persiapan Pengujian → Input Data Alat → Validasi Data → Penyimpanan Data**

• `GET  /qc`        → `QCController@index`  — Dashboard QC: menampilkan daftar batch yang tersedia dan ringkasan status pengujian.
• `GET  /qc/create` → `QCController@create` — Form Input: menampilkan formulir entri data pengujian alat untuk batch yang dipilih.
• `POST /qc/store`  → `QCController@store`  — Proses Simpan: menerima data dari form, menjalankan validasi (via Form Request), dan menyimpan ke tabel `test_data`.

Pendaftaran route di `routes/web.php`:

```php
use App\Http\Controllers\QCController;

Route::middleware(['auth'])->prefix('qc')->name('qc.')->group(function () {
    Route::get('/',        [QCController::class, 'index'])->name('index');
    Route::get('/create',  [QCController::class, 'create'])->name('create');
    Route::post('/store',  [QCController::class, 'store'])->name('store');
});
```

• Semua route dilindungi middleware `auth` agar hanya pengguna yang sudah login (role QC) yang dapat mengakses.
• Prefix `qc` dan penamaan route bertanda `qc.*` memudahkan pembuatan link di Blade (`route('qc.create')`).
• Route Model Binding dapat ditambahkan pada endpoint detail (`/qc/{batch}`) jika diperlukan di fase selanjutnya.

## File Structure (MVC Journey 2)

Berikut lokasi dan tanggung jawab tiap file dalam arsitektur MVC untuk fitur QC Input:

• `app/Http/Controllers/QCController.php`
  — Controller utama fitur QC. Metode `index()` mengambil daftar batch (dengan eager loading `testData`), `create()` menyiapkan data batch aktif untuk dropdown form, dan `store()` mendelegasikan validasi ke Form Request lalu memanggil `TestData::create()`.

• `app/Http/Requests/StoreTestDataRequest.php` *(opsional, direkomendasikan)*
  — Form Request class untuk memisahkan logika validasi dari controller. Mendefinisikan rules seperti `required`, `numeric`, `exists:batches,id`, dan pesan error yang ramah pengguna. Gunakan `php artisan make:request StoreTestDataRequest` untuk membuatnya.

• `app/Models/Batch.php`
  — Model Eloquent untuk tabel `batches`. Mendefinisikan relasi `hasMany(TestData::class)` dan atribut `fillable` (`product_code`, `batch_number`, `production_date`, dll.). Tambahkan query scope `scopeActive()` untuk memfilter batch dengan status aktif.

• `app/Models/TestData.php`
  — Model Eloquent untuk tabel `test_data`. Mendefinisikan relasi `belongsTo(Batch::class)` dan atribut `fillable` (`batch_id`, `parameter_name`, `value`, `unit`, `tested_at`). Cast kolom `value` ke `float` dan `tested_at` ke `datetime` untuk kemudahan pemrosesan.

• `resources/views/qc/create.blade.php`
  — Template Blade untuk form input data pengujian. Menggunakan `@csrf` dan `method="POST"` yang mengarah ke `route('qc.store')`. Menampilkan dropdown pilihan batch (dari `$batches`), field input numerik per parameter, dan blok `@error` untuk menampilkan pesan validasi secara inline.

• `routes/web.php`
  — File pendaftaran semua route web aplikasi. Route Journey 2 dikelompokkan dalam `Route::group` dengan middleware `auth` dan prefix `qc` seperti dijelaskan pada section **Routes** di atas.
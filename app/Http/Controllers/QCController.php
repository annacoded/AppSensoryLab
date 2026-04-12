<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\TestData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QCController extends Controller
{
    /**
     * Menampilkan form input data QC.
     */
    public function create()
    {
        return view('qc.create');
    }

    /**
     * Menyimpan data batch dan test_data ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            // Validasi Batch
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:batches,product_code',
            'batch_number' => 'required|string|max:255|unique:batches,batch_number',
            'date_created' => 'required|date',

            // Validasi Test Data (Bisa array jika input lebih dari 1, di sini disederhanakan 1 input)
            'parameter_name' => 'required|string|max:255',
            'value' => 'required|numeric', // Validasi value harus numerik
            'measurement_unit' => 'nullable|string|max:255',
        ], [
            'value.numeric' => 'Nilai pengukuran (value) harus berupa angka numerik.',
            'product_code.unique' => 'Kode produk sudah terdaftar.',
            'batch_number.unique' => 'Nomor batch sudah terdaftar.'
        ]);

        // 2. Gunakan Database Transaction untuk memastikan data konsisten
        DB::beginTransaction();

        try {
            // 3. Simpan data Batch
            $batch = Batch::create([
                'product_name' => $validated['product_name'],
                'product_code' => $validated['product_code'],
                'batch_number' => $validated['batch_number'],
                'date_created' => $validated['date_created'],
            ]);

            // 4. Simpan data TestData, relasi dengan batch_id
            TestData::create([
                'batch_id' => $batch->id,
                'parameter_name' => $validated['parameter_name'],
                'value' => $validated['value'],
                'measurement_unit' => $validated['measurement_unit'],
            ]);

            DB::commit();

            return redirect()->route('qc.create')->with('success', 'Data hasil pengujian QC berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }
    }
}

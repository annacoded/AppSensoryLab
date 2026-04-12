<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pengujian QC - SensoryLab</title>
    <!-- Simple CSS Styling (Using Tailwind CDN for quick UI best practice approximation) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 antialiased py-10">

<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 border-b pb-3 border-gray-200 text-blue-700">Form Input Data Pengujian Objektif Alat - SensoryLab</h1>

    <!-- Tampilkan Notifikasi Sukses -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tampilkan Notifikasi Error Sistem -->
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tampilkan Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan pada inputan Anda:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('qc.store') }}" method="POST">
        @csrf

        <div class="mb-8 p-6 bg-blue-50 rounded-lg">
            <h2 class="text-lg font-semibold text-blue-800 mb-4">Informasi Identitas Batch (Produk)</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border @error('product_name') border-red-500 @enderror" placeholder="Contoh: Kopi Susu Aren">
                </div>

                <div>
                    <label for="product_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Produk</label>
                    <input type="text" name="product_code" id="product_code" value="{{ old('product_code') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border @error('product_code') border-red-500 @enderror" placeholder="Contoh: KSA-01">
                </div>

                <div>
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Batch</label>
                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border @error('batch_number') border-red-500 @enderror" placeholder="Contoh: BATCH-001">
                </div>

                <div>
                    <label for="date_created" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembuatan</label>
                    <input type="date" name="date_created" id="date_created" value="{{ old('date_created') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border @error('date_created') border-red-500 @enderror">
                </div>
            </div>
        </div>

        <div class="mb-8 p-6 bg-green-50 rounded-lg">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Data Hasil Pengujian Alat</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="parameter_name" class="block text-sm font-medium text-gray-700 mb-1">Parameter</label>
                    <input type="text" name="parameter_name" id="parameter_name" value="{{ old('parameter_name') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border @error('parameter_name') border-red-500 @enderror" placeholder="Contoh: pH, Suhu">
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Nilai Pengukuran</label>
                    <input type="number" step="any" name="value" id="value" value="{{ old('value') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border @error('value') border-red-500 @enderror" placeholder="Misal: 7.2">
                </div>

                <div>
                    <label for="measurement_unit" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <input type="text" name="measurement_unit" id="measurement_unit" value="{{ old('measurement_unit') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border @error('measurement_unit') border-red-500 @enderror" placeholder="Misal: °C, mg/L (Boleh kosong)">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">*Nilai pengukuran wajib berupa angka (numerik).</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition w-full sm:w-auto">
                Simpan Data Pengujian
            </button>
        </div>

    </form>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QC Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard QC</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('qc.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Input Data Baru</a>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama Produk</th>
                <th class="border px-4 py-2">Kode Produk</th>
                <th class="border px-4 py-2">Nomor Batch</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Jumlah Data Uji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($batches as $index => $batch)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $batch->product_name }}</td>
                    <td class="border px-4 py-2">{{ $batch->product_code }}</td>
                    <td class="border px-4 py-2">{{ $batch->batch_number }}</td>
                    <td class="border px-4 py-2">{{ $batch->date_created }}</td>
                    <td class="border px-4 py-2">{{ $batch->test_data_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

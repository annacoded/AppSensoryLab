<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('product_name'); // Nama produk
            $table->string('product_code')->unique(); // Kode produk (unik)
            $table->string('batch_number')->unique(); // Nomor batch (unik)
            $table->date('date_created'); // Tanggal pembuatan batch
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
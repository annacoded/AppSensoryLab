<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_data', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('batch_id') // Foreign key ke batches
                  ->constrained('batches')
                  ->onDelete('cascade'); // Jika batch dihapus, test_data ikut terhapus
            $table->string('parameter_name'); // Nama parameter
            $table->float('value'); // Nilai pengukuran
            $table->string('measurement_unit')->nullable(); // Satuan
            $table->timestamps(); // created_at, updated_at
            
            $table->index(['batch_id', 'parameter_name']); // Index untuk query performa
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_data');
    }
};
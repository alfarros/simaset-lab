<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_aset')->unique();
            $table->string('kategori'); // misal: Elektronik, Furnitur, ATK
            $table->string('lokasi'); // misal: Lab A, Lab B, Gudang
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Perbaikan', 'Rusak'])->default('Tersedia');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};

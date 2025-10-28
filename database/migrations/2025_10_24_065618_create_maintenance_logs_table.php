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
    Schema::create('maintenance_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asset_id')->constrained()->onDelete('cascade');
        $table->string('reported_by'); // Nama pelapor (bisa user()->name)
        $table->text('issue_description');
        $table->enum('status', ['Menunggu', 'Sedang Dikerjakan', 'Selesai'])->default('Menunggu');
        $table->text('resolution_notes')->nullable(); // Catatan perbaikan
        $table->date('resolved_at')->nullable(); // Kapan selesai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};

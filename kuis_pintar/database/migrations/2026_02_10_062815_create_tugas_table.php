<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('tugas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();

      $table->string('kategori');      // Penjumlahan / dst
      $table->string('judul');         // Penjumlahan 1
      $table->string('soal');          // 50 + 25
      $table->string('kunci_jawaban'); // 75

      $table->boolean('is_active')->default(true);
      $table->timestamps();

      $table->index(['kategori', 'is_active']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('tugas');
  }
};


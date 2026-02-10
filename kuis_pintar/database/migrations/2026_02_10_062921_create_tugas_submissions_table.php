<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('tugas_submissions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
      $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();

      $table->string('jawaban_ocr')->nullable();   // hasil OCR dari mobile
      $table->string('photo_path')->nullable();   // path foto jawaban (opsional)
      $table->unsignedTinyInteger('nilai')->default(0); // 0-100
      $table->timestamp('submitted_at')->nullable();

      $table->timestamps();

      $table->unique(['tugas_id','siswa_id']); // 1 siswa 1 submission per tugas
      $table->index(['siswa_id','nilai']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('tugas_submissions');
  }
};

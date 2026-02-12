<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // kategori: penjumlahan/pengurangan/perkalian/pembagian
            $table->string('kategori', 50);

            // nilai 0-100
            $table->unsignedTinyInteger('score');

            // tanggal pengerjaan
            $table->timestamp('taken_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

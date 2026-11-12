<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();

            // Pemilik produk (user dengan role penjual)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori')->restrictOnDelete();

            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('berat')->default(0);   // dalam gram
            $table->string('gambar')->nullable();
            $table->enum('status', ['tersedia', 'habis', 'nonaktif'])->default('tersedia');

            $table->timestamps();

            $table->index(['kategori_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
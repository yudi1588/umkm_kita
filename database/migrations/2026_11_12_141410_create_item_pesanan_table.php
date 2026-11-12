<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->cascadeOnDelete();

            // nullOnDelete: riwayat pesanan tetap ada walau produknya dihapus
            $table->foreignId('produk_id')->nullable()->constrained('produk')->nullOnDelete();

            // Salinan data saat dibeli, supaya riwayat tidak berubah kalau produk diedit
            $table->string('nama_produk');
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('jumlah');
            $table->unsignedBigInteger('subtotal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_pesanan');
    }
};
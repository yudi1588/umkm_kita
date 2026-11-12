<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();        // contoh: INV-20261112-0001

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ekspedisi_id')->nullable()->constrained('ekspedisi')->nullOnDelete();

            // Data pengiriman
            $table->string('nama_penerima');
            $table->string('telepon', 20);
            $table->text('alamat');

            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('ongkir')->default(0);
            $table->unsignedBigInteger('total_harga')->default(0);

            $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])
                  ->default('menunggu');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                       // contoh: JNE, J&T, SiCepat
            $table->string('kode', 20)->unique();         // contoh: jne
            $table->unsignedBigInteger('tarif_dasar')->default(0); // ongkir dasar (Rp)
            $table->string('estimasi')->nullable();       // contoh: 2-3 hari
            $table->string('logo')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekspedisi');
    }
};
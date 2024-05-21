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
        Schema::create('reservasi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->cascadeOnDelete();
            $table->foreignId('mobil_id')->constrained('mobils');
            $table->foreignId('driver_id')->constrained('drivers')->nullable();
            $table->dateTime('tanggal_ambil');
            $table->dateTime('tanggal_kembali');
            $table->integer('durasi_sewa');
            $table->string('tujuan');
            $table->unsignedInteger('biaya_sewa');
            $table->unsignedInteger('biaya_driver')->nullable();
            $table->string('status_pengembalian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_details');
    }
};

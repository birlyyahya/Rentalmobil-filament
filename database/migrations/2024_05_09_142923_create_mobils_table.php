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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mobil');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('kapasitas');
            $table->string('warna');
            $table->string('transmisi');
            $table->string('jenis_bbm');
            $table->string('deskripsi');
            $table->integer('harga_sewa');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropIfExists('mobils');
            $table->dropColumn('deleted_at');
        });
    }
};

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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate();
            $table->string('kode_transaksi');
            $table->unsignedInteger('total_bayar');
            $table->enum('status_reservasi', ['menunggu', 'pending', 'diproses', 'diterima', 'ditolak']);
            $table->enum('status_pembayaran', ['paid', 'unpaid', 'expired', 'refund']);
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};

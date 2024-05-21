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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_identitas');
            $table->string('jenis_identitas');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('alamat');
            $table->string('telp');
            $table->string('password');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('customers');
    }
};

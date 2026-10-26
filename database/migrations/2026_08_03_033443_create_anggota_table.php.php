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
    Schema::create('anggota', function (Blueprint $table) {
        $table->id('id_anggota');
        $table->unsignedBigInteger('id_user')->nullable();
        $table->string('nis')->unique();
        $table->string('nama_lengkap');
        $table->string('alamat')->nullable();
        $table->string('kelas')->nullable();
        $table->timestamps();

        $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
    });
}

};
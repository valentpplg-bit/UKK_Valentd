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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id('id_transaksi');
        $table->unsignedBigInteger('id_anggota');
        $table->unsignedBigInteger('id_buku');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali')->nullable();
        $table->enum('status', ['dipinjam','dikembalikan','terlambat'])->default('dipinjam');
        $table->decimal('denda', 10, 2)->default(0);
        $table->timestamps();

        $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
        $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
    });
}

};
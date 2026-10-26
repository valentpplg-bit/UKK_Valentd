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
        Schema::table('anggota', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable()->change();
            $table->dropForeign(['id_user']);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->unsignedBigInteger('id_user')->nullable(false)->change();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

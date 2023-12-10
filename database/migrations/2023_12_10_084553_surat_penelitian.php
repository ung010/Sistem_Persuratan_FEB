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
        Schema::create('srt_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('tjn_kegiatan');
            $table->string('lampiran');
            $table->string('jbt_dtju');
            $table->string('nama_lembaga');
            $table->string('almt_lembaga');
            $table->string('ktkb_lembaga');
            $table->string('judul');
            $table->tinyInteger('semester');
            $table->string('ipk');
            $table->string('sksk');
            $table->enum('role', ['admin', 'mahasiswa', 'supervisor', 'wakildekan'])->default('mahasiswa');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

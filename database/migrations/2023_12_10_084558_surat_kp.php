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
        Schema::create('srt_kp', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable();
            $table->string('keperluan');
            $table->string('krs');
            $table->string('jbt_dtju');
            $table->string('nama_lembaga');
            $table->string('almt_lembaga');
            $table->string('ktkb_lembaga');
            $table->string('judul_kp');
            $table->tinyInteger('semester');
            $table->string('ipk');
            $table->string('sksk');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('surat_mhn_prd');
            $table->enum('role', ['admin', 'mahasiswa', 'supervisor', 'wakildekan', 'dekan'])->default('mahasiswa');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('prd_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->string('ket_surat')->nullable()->default('-');
            $table->date('tgl_cetak_srt')->nullable();
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

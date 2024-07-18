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
        Schema::create('srt_aktif_asn', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable();
            $table->string('gol_ortu');
            $table->string('nama_ortu');
            $table->integer('nip_ortu');
            $table->string('perusahan_ortu');
            $table->year('thn_awl');
            $table->year('thn_akh');
            $table->tinyInteger('semester');
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

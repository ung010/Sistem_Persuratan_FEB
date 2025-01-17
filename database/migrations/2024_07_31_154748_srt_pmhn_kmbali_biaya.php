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
        Schema::create('srt_pmhn_kmbali_biaya', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_surat')->nullable();
            $table->string('nama_mhw')->nullable();
            $table->string('skl')->nullable();
            $table->string('buku_tabung')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->string('file_pdf')->nullable();
            $table->date('tanggal_surat');
            $table->text('catatan_surat')->nullable()->default('-');
            $table->enum('role_surat', ['tolak' ,'mahasiswa', 'admin', 'supervisor_sd', 'manajer', 'wd2'])->default('admin');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->unsignedBigInteger('prd_id')->nullable();
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
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

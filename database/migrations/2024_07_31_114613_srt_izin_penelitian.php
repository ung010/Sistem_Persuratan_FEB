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
        Schema::create('srt_izin_plt', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('no_surat')->nullable();
            $table->string('nama_mhw')->nullable();
            $table->string('lampiran');
            $table->string('nama_lmbg');
            $table->tinyInteger('semester');
            $table->string('jbt_lmbg');
            $table->string('kota_lmbg');
            $table->string('almt_lmbg');
            $table->string('judul_data');
            $table->string('jenis_surat');
            $table->date('tanggal_surat');
            $table->text('catatan_surat')->nullable()->default('-');
            $table->string('file_pdf')->nullable();
            $table->enum('role_surat', ['tolak' ,'mahasiswa', 'admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])->default('admin');
            $table->bigInteger('users_id')->nullable();
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

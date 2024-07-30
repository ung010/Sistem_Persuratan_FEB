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
        Schema::create('srt_masih_mhw', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable();
            $table->string('nama_mhw')->nullable();
            $table->year('thn_awl');
            $table->year('thn_akh');
            $table->text('almt_smg');
            $table->text('tujuan_buat_srt');
            $table->date('tanggal_surat');
            $table->text('catatan_surat')->nullable()->default('-');
            $table->string('file_pdf')->nullable();
            $table->enum('tujuan_akhir', ['manajer' ,'wd']);
            $table->enum('role_surat', ['tolak' ,'mahasiswa', 'alumni', 'admin', 'supervisor_akd', 'supervisor_sd', 'manajer', 'manajer_sukses'])->default('admin');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->unsignedBigInteger('dpt_id')->nullable();
            $table->unsignedBigInteger('prd_id')->nullable();
            $table->unsignedBigInteger('jnjg_id')->nullable();
            $table->foreign('dpt_id')->references('id')->on('departement')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreign('jnjg_id')->references('id')->on('jenjang_pendidikan')->onDelete('cascade')->onUpdate('cascade')->nullable();
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

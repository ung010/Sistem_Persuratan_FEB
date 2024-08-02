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
        Schema::create('legalisir', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi')->default('-');
            $table->enum('jenis_lgl', ['ijazah' ,'transkrip', 'ijazah_transkrip']);
            $table->enum('ambil', ['ditempat' ,'dikirim']);
            $table->string('nama_mhw')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_transkrip')->nullable();
            $table->string('keperluan');
            $table->date('tgl_lulus');
            $table->string('almt_kirim')->nullable();
            $table->string('kcmt_kirim')->nullable();
            $table->integer('kdps_kirim')->nullable();
            $table->string('klh_kirim')->nullable();
            $table->string('kota_kirim')->nullable();
            $table->date('tanggal_surat');
            $table->text('catatan_surat')->nullable()->default('-');
            $table->enum('role_surat', ['tolak' ,'mahasiswa', 'alumni', 'admin', 'supervisor_sd', 'manajer'])->default('admin');
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

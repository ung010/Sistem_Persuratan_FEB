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
        Schema::create('srt_mhw_asn', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable();
            $table->string('nama_mhw')->nullable();
            $table->bigInteger('nim_mhw')->nullable();
            $table->string('nowa_mhw')->nullable();
            $table->string('jenjang_prodi')->nullable();
            $table->year('thn_awl');
            $table->year('thn_akh');
            $table->tinyInteger('semester');
            $table->string('nama_ortu');
            $table->integer('nip_ortu');
            $table->string('ins_ortu');
            $table->date('tanggal_surat');
            $table->text('catatan_surat')->nullable()->default('-');
            $table->enum('role_surat', ['tolak' ,'mahasiswa', 'admin', 'supervisor_akd', 'manajer'])->default('admin');
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

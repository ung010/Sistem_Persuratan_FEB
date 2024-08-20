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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('nmr_unik')->unique();
            $table->string('nowa')->nullable();
            $table->string('email');
            $table->string('kota')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('almt_asl')->nullable();
            $table->string('foto')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('password');
            $table->enum('status', ['mahasiswa', 'alumni']);
            $table->enum('role', ['non_mahasiswa', 'del_mahasiswa', 'mahasiswa', 'admin', 'supervisor_akd', 'supervisor_sd', 'manajer'])->default('non_mahasiswa');
            $table->text('catatan_user')->nullable()->default('-');
            // $table->unsignedBigInteger('dpt_id')->nullable();
            $table->unsignedBigInteger('prd_id')->nullable();
            // $table->unsignedBigInteger('jnjg_id')->nullable();
            // $table->foreign('dpt_id')->references('id')->on('departement')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
            // $table->foreign('jnjg_id')->references('id')->on('jenjang_pendidikan')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

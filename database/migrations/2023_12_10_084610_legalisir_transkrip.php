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
        Schema::create('legal_trs', function (Blueprint $table) {
            $table->id();
            // Alamat Asal
            // $table->string('alamat');
            $table->string('keperluan');
            $table->string('jnis_legal');
            $table->string('file_trs');
            $table->enum('role', ['admin', 'mahasiswa', 'supervisor', 'wakildekan', 'dekan'])->default('mahasiswa');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('prd_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->string('ket_legalisir')->nullable()->default('-');
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

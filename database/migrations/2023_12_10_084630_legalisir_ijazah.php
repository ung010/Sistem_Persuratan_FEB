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
        Schema::create('legal_ijz', function (Blueprint $table) {
            $table->id();
            $table->string('alamat');
            $table->string('keperluan');
            $table->string('jnis_legal');
            $table->string('file_ijz');
            $table->enum('role', ['admin', 'mahasiswa', 'supervisor', 'wakildekan'])->default('mahasiswa');
            $table->unsignedBigInteger('id_users');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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

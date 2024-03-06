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
            $table->bigInteger('nim')->unique()->nullable();
            $table->string('nowa')->nullable();
            $table->string('email');
            $table->string('ttl')->nullable();
            $table->string('almt_asl')->nullable();
            $table->string('almt_smg')->nullable();
            $table->string('foto')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'mahasiswa', 'supervisor', 'wakildekan', 'dekan'])->default('mahasiswa');
            $table->unsignedBigInteger('dpt_id')->nullable();
            $table->unsignedBigInteger('prd_id')->nullable();
            $table->foreign('dpt_id')->references('id')->on('departement')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreign('prd_id')->references('id')->on('prodi')->onDelete('cascade')->onUpdate('cascade')->nullable();
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

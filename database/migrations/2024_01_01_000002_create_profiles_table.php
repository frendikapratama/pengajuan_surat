<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email')->unique();
            $table->string('nik')->unique();
            $table->string('no_kk')->unique();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_akte')->nullable();
            $table->string('pas_photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
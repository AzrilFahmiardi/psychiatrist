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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('semester')->nullable();
            $table->string('usia')->nullable();
            $table->string('departemen')->nullable();
            $table->string('program_studi')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan', 'unknown'])->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('status_akses_layanan', ['psikolog', 'psikiater', 'belum pernah'])->nullable();
            $table->enum('role', ['psikolog', 'pasien', 'admin'])->nullable();
            $table->integer('trial_left')->default(2);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('google_id')->nullable();
            $table->text('google_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

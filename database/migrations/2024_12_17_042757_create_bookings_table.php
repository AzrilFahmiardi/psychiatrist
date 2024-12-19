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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('psikolog_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->enum('status_akses_layanan', ['submitted', 'scheduled', 'completed','rescheduled','cancel'])->default('scheduled');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('google_calendar_event_id')->nullable();
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('psikolog_id')->references('id')->on('psikologs')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

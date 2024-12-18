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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->datetime('waktu');
            $table->unsignedBigInteger('psikolog_id');
            $table->enum('status', ['available', 'booked'])->default('available');

            $table->timestamps();

            $table->foreign('psikolog_id')->references('id')->on('psikologs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};

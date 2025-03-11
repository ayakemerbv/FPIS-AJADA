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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('room_id');
            $table->integer('floor');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'checked_in', 'checked_out'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        // Пример связей (если хотите настроить внешние ключи)
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

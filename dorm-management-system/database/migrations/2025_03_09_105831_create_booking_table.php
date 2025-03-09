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
            $table->integer('floor');
            $table->unsignedBigInteger('room_id');
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Если есть таблица buildings/rooms, добавьте внешние ключи
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

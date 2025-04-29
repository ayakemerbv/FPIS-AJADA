<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained('buildings'); // связь с buildings
            $table->integer('floor');         // номер этажа
            $table->integer('room_number');   // номер комнаты
            $table->integer('capacity');      // вместимость
            $table->integer('occupied_places')->default(0); // занятые места
            $table->timestamps();
        });


    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};

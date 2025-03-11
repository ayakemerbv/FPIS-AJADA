<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->integer('floor');
            $table->string('room_number');
            $table->integer('capacity'); // Всего мест в комнате
            $table->integer('occupied_places')->default(0); // Занятые места
            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });


    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};

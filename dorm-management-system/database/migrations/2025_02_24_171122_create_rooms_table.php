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
            $table->integer('capacity');       // 2, 3, 4 и т.п.
            $table->integer('occupied_beds');  // изначально 0
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};

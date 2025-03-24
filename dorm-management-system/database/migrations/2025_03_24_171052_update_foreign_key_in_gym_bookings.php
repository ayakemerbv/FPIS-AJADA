<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gym_bookings', function (Blueprint $table) {
            // Удаляем старый foreign key (если он был)
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');

            // Добавляем user_id с внешним ключом
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('gym_bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Восстанавливаем student_id (если нужно откатить миграцию)
            $table->unsignedBigInteger('student_id')->after('id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

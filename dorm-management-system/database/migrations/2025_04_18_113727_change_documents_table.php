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
        //
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateBookingsStatusConstraint extends Migration
{
    public function up()
    {
        // Сначала удалим существующее ограничение
        DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');

        // Создадим новое ограничение с добавленными статусами
        DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::text, 'accepted'::text, 'rejected'::text, 'pending_change'::text, 'accepted_change'::text]))");
    }

    public function down()
    {
        // Вернем исходное ограничение
        DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');
        DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::text, 'accepted'::text, 'rejected'::text]))");
    }
}

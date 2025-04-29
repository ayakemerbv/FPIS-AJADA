<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Удалим старый constraint, если он был (на всякий случай)
        DB::statement("ALTER TABLE repair_requests DROP CONSTRAINT IF EXISTS status_check");

        // Меняем тип, NOT NULL и default — без CHECK
        DB::statement("ALTER TABLE repair_requests ALTER COLUMN status TYPE VARCHAR(255)");
        DB::statement("ALTER TABLE repair_requests ALTER COLUMN status SET NOT NULL");
        DB::statement("ALTER TABLE repair_requests ALTER COLUMN status SET DEFAULT 'pending'");

        // Добавляем CHECK отдельно
        DB::statement("ALTER TABLE repair_requests ADD CONSTRAINT status_check CHECK (status IN ('pending', 'accepted', 'done'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE repair_requests DROP CONSTRAINT IF EXISTS status_check");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE repair_requests ADD CONSTRAINT status_check CHECK (status IN ('pending', 'accepted', 'done'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE repair_requests DROP CONSTRAINT IF EXISTS status_check");
    }
};

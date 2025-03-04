<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceRequest;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        MaintenanceRequest::create(['student_id' => 1, 'description' => 'Broken window', 'status' => 'open']);
        MaintenanceRequest::create(['student_id' => 2, 'description' => 'Leaky sink', 'status' => 'in_progress']);
    }
}

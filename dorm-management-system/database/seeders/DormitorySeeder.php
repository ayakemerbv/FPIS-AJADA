<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Dormitory;

class DormitorySeeder extends Seeder
{
    public function run()
    {
        Dormitory::create(['name' => 'Dorm A', 'location' => 'North Campus']);
        Dormitory::create(['name' => 'Dorm B', 'location' => 'South Campus']);
    }
}

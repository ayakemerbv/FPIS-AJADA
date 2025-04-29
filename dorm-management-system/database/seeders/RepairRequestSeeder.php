<?php
//
//namespace Database\Seeders;
//
//use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Str;
//
//class RepairRequestSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     */
//    public function run(): void
//    {
//        DB::table('repair_requests')->insert([
//            [
//                'type' => 'Окно',
//                'description' => 'Продувает окно в комнате 204.',
//                'file' => null,
//                'status' => 'pending',
//                'employee_id' => 1,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'type' => 'Электрика',
//                'description' => 'Не работает розетка в кабинете 305.',
//                'file' => null,
//                'status' => 'pending',
//                'employee_id' => 2,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'type' => 'Сантехника',
//                'description' => 'Течет кран в ванной на 3 этаже.',
//                'file' => null,
//                'status' => 'pending',
//                'employee_id' => 3,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);
//    }
//}

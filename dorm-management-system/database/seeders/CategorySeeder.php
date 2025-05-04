<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Электроника'],
            ['name' => 'Одежда'],
            ['name' => 'Книги'],
            ['name' => 'Мебель'],
            ['name' => 'Спорт'],
            ['name' => 'Прочее']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

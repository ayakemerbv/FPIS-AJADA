<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::create([
            'title' => 'Добро пожаловать в общежитие!',
            'content' => 'Уважаемые студенты, рады сообщить, что общежитие теперь открыто. Ознакомьтесь с правилами проживания.',
            'image' => 'news_images/welcome.jpg',
        ]);

        News::create([
            'title' => 'Обновление инфраструктуры',
            'content' => 'На следующей неделе начнутся работы по улучшению системы отопления. Возможны временные неудобства.',
            'image' => 'news_images/heating_update.jpg',
        ]);

        News::create([
            'title' => 'Новое кафе на территории кампуса',
            'content' => 'Мы открыли новое кафе, где студенты смогут вкусно и недорого пообедать!',
            'image' => 'news_images/campus_cafe.jpg',
        ]);
    }
}

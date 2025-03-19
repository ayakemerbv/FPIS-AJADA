<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        Schema::disableForeignKeyConstraints(); // Отключаем внешние ключи перед миграциями
        Schema::enableForeignKeyConstraints(); // Включаем после миграций
    }

}

<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\News;
use App\Models\User;
// <-- ваша модель заявок

class ManagerController extends Controller
{
    public function dashboard()
    {
        // Получаем последние новости
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();

        // Получаем список пользователей
        $users = User::all();

        // Получаем заявки
        $requests = Booking::where('status', 'pending')->get();

        // Возвращаем представление, передаём все три переменные
        return view('manager.dashboard', compact('users', 'newsList', 'requests'));
    }
}

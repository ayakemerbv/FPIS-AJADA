<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Building;
use App\Models\News;
use App\Models\User;
// <-- ваша модель заявок

class ManagerController extends Controller
{
    public function dashboard()
    {
        // Получаем последние новости
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $buildings = Building::all();
        // Получаем список пользователей
        $users = User::all();

        // Получаем заявки
        $requests = Booking::where('status', 'pending')->get();

        // Возвращаем представление, передаём все три переменные
        return view('manager.dashboard', compact('users', 'newsList', 'requests','buildings'));
    }


    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('filter_id')) {
            $query->where('user_id', 'like', '%'.$request->filter_id.'%');
        }
        if ($request->filled('filter_name')) {
            $query->where('name', 'like', '%'.$request->filter_name.'%');
        }
        if ($request->filled('filter_email')) {
            $query->where('email', 'like', '%'.$request->filter_email.'%');
        }
        if ($request->filled('filter_role')) {
            $query->where('role', 'like', '%'.$request->filter_role.'%');
        }

        // Получаем результат
        $users = $query->get();

        return view('manager.dashboard', [
            'users' => $users,
            // Если нужно, передаем ещё что-то (newsList, requests, etc.)
        ]);
    }
}

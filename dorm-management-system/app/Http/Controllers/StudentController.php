<?php

namespace App\Http\Controllers;

use App\Models\News; // Если ты хочешь выводить новости
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Метод, показывающий «студенческую панель» (dashboard).
     */
    public function dashboard()
    {
        // Если нужно вывести новости:
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();

        // Возвращаем Blade-шаблон student/dashboard.blade.php
        // и передаём туда список новостей.
        return view('student.dashboard', compact('newsList'));
    }
    public function profile()
    {
        // Если нужно, можешь передавать данные пользователя
        // или другие данные. Пока просто вернём Blade-шаблон.

        return view('student.profile');
    }
    public function personal()
    {
        // Если нужно, можешь передавать данные пользователя
        // или другие данные. Пока просто вернём Blade-шаблон.
        // Если нужно вывести новости:
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();

        // Возвращаем Blade-шаблон student/dashboard.blade.php
        // и передаём туда список новостей.
        return view('student.personal', compact('newsList'));

//        return view('student.personal');
    }

}

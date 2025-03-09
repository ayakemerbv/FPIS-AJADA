<?php

namespace App\Http\Controllers\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\News;

// Если ты хочешь выводить новости

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
    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ]);

        $user = Auth::user();

        // Обновляем телефон
        if ($request->phone) {
            $user->phone = $request->phone;
        }

        // Если загружаем новое фото
        if ($request->hasFile('photo')) {
            // (Опционально) удалить старый файл
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Сохранить новый
            $path = $request->file('photo')->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Профиль обновлён!');
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

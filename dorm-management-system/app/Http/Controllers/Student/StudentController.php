<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Building; // Добавляем модель корпусов

class StudentController extends Controller
{
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $buildings = Building::all(); // Загружаем список корпусов

        return view('student.dashboard', compact('newsList', 'buildings'));
    }

    public function personal()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        return view('student.personal', compact('newsList'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        if ($request->phone) {
            $user->phone = $request->phone;
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Профиль обновлён!');
    }

    public function profile()
    {
        return view('student.profile');
    }
}

<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Building;
use App\Models\News;
use App\Models\Request as RepairRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ManagerController extends Controller
{
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $buildings = Building::all();
        $users = User::whereIn('role', ['student', 'employee'])->get();
        $requests = Booking::where('status', 'pending')->get();
        return view('manager.dashboard', compact('users', 'newsList', 'requests','buildings'));
    }
    public function index(Request $request)
    {
        $query = User::query();

        $users = $query->get();

        return view('manager.dashboard', [
            'users' => $users,
            // Если нужно, передаем ещё что-то (newsList, requests, etc.)
        ]);
    }
    public function updateProfile(Request $request){
        $request->validate([
            'phone'=> 'nullable|string|max:20',
            'photo'=> 'nullable|image|max:2048',
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

        return redirect()->route('manager.dashboard')
            ->with('successType', 'profile_updated');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone'                 => 'nullable|string|max:255',
            'photo'                 => 'nullable|image|max:2048',
            'current_password'      => 'required_with:new_password',
            'new_password'          => 'nullable|confirmed|min:6',
        ]);

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        // Обновляем пароль, если передан new_password
        if ($request->filled('new_password')) {
            // Проверяем текущий пароль
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Текущий пароль введён неверно.']);
            }
            // Записываем новый
            $user->password = Hash::make($request->new_password);
        }

        // Обновляем фото
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return back()->with('success', 'Данные успешно обновлены!');
    }
}

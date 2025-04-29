<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Building;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerUserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:student,manager,admin'
        ]);

        User::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);


        return redirect()->route('manager.dashboard')
            ->with('successType', 'user_created');
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('filter_id'), fn($q) => $q->where('user_id', 'like', '%' . $request->filter_id . '%'))
            ->when($request->filled('filter_name'), fn($q) => $q->where('name', 'like', '%' . $request->filter_name . '%'))
            ->when($request->filled('filter_email'), fn($q) => $q->where('email', 'like', '%' . $request->filter_email . '%'))
            ->when($request->filled('filter_role'), fn($q) => $q->where('role', 'like', '%' . $request->filter_role . '%'))
            ->get();

        $newsList  = News::orderBy('created_at', 'desc')->take(5)->get();
        $buildings = Building::all();
        $requests  = Booking::where('status', 'pending')->get();

        session()->flash('successType', 'user_searched');
        session()->flash('success', 'Пользователь найден!');

        return view('manager.dashboard', compact('users','newsList','requests','buildings'));

    }

    public function getUserJson($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Пользователь не найден'], 404);
        }
        return response()->json($user);
    }
}

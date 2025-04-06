<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\News;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $users = User::all();
        $requests = Booking::where('status', 'pending')->get();
        return view('admin.dashboard', compact('users', 'newsList', 'requests'));
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

        $users = $query->get();

        return view('admin.dashboard', [
            'users' => $users,
            // Если нужно, передаем ещё что-то (newsList, requests, etc.)
        ]);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function showJson($id)
    {
        $user = User::findOrFail($id);
        // Вернём JSON
        return response()->json($user);
    }



}

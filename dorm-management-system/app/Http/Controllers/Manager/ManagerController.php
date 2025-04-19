<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Building;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;


class ManagerController extends Controller
{
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $buildings = Building::all();
        $users = User::all();
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
}

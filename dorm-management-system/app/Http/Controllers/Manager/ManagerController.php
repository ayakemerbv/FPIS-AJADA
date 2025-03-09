<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;

class ManagerController extends Controller
{
    //
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $users = User::all();
        return view('manager.dashboard', compact('users', 'newsList'));
    }
}

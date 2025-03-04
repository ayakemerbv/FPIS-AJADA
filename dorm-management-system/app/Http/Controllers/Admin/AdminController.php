<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();
        $users = User::all();

        return view('admin.dashboard', compact('users', 'newsList'));
    }
}

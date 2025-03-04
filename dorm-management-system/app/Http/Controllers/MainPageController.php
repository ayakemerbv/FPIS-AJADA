<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class MainPageController extends Controller {
    public function index() {
        $latestNews = News::orderBy('published_at', 'desc')->take(3)->get();
        return view('main.index', compact('latestNews'));
    }
}

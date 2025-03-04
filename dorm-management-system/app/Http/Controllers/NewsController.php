<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index() {
        $news = News::latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    public function show($id) {
        $newsItem = News::findOrFail($id);
        return view('news.show', compact('newsItem'));
    }

}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsAdminController extends Controller
{
    // Список новостей
    public function index()
    {
        $newsList = News::orderBy('created_at', 'desc')->get();
        return view('admin.news.index', compact('newsList'));
    }

    // Форма создания новости
    public function create()
    {
        return view('admin.news.create');
    }

    // Сохранение новости
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image', // если нужно загружать картинку
        ]);

        // Если загружаем картинку
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $data['image'] = $path;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Новость создана!');
    }

    // Страница одной новости (необязательно)
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    // Форма редактирования
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    // Обновление новости
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            // Удалим старую картинку (если нужна такая логика)
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $path = $request->file('image')->store('news_images', 'public');
            $data['image'] = $path;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Новость обновлена!');
    }

    // Удаление
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Удалим картинку, если есть
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Новость удалена!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    // Показ всех объявлений
    public function index()
    {
        $ads = Ad::latest()->get();
        return view('student.dashboard', compact('ads'));
    }

    // Сохранение нового объявления
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'contact' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('ads', 'public')
            : null;

        Ad::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'contact' => $request->contact,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Объявление успешно добавлено!');
    }
    public function edit(Ad $ad)
    {
        return response()->json([
            'id'          => $ad->id,
            'title'       => $ad->title,
            'description' => $ad->description,
            'price'       => $ad->price,
            'category_id' => $ad->category,
            'contact'     => $ad->contact,
            'image'       => $ad->image, // если нужно
        ]);
    }


    // Обновление объявления
    public function update(Request $request, Ad $ad)
    {
        // Только владелец может обновлять
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'contact' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // Заменяем изображение, если загружено
        if ($request->hasFile('image')) {
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            $ad->image = $request->file('image')->store('ads', 'public');
        }

        $ad->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'contact' => $request->contact,
        ]);

        return redirect()->back()->with('success', 'Объявление обновлено!');
    }

    // Удаление объявления
    public function destroy(Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();

        return redirect()->back()->with('success', 'Объявление удалено.');
    }

    // Категории (для дропа)
    public static function getCategories(): array
    {
        return [
            'electronics' => 'Электроника',
            'clothes' => 'Одежда',
            'books' => 'Книги',
            'furniture' => 'Мебель',
            'other' => 'Другое',
        ];
    }
}

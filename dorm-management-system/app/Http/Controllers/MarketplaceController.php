<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with('category');

        // Фильтрация по категории
        if ($request->has('category_id') && $request->category_id !== null) {
            $query->where('category_id', $request->category_id);
        }

        // Сортировка по цене
        if ($request->has('sort') && $request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        }
        // Поиск по заголовку и описанию
        if ($request->has('search') && $request->search !== null) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }


        $ads = $query->get();
        $categories = Category::all();

        return view('student.dashboard', compact('ads', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'contact' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
        }

        Ad::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'contact' => $request->contact,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Объявление добавлено!');
    }

    public function update(Request $request, Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'contact' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $ad->image_path = $request->file('image')->store('ads', 'public');
        }

        $ad->update($request->only(['title', 'category_id', 'description', 'price', 'contact']));

        return back()->with('success', 'Объявление обновлено!');
    }

    public function destroy(Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        $ad->delete();
        return back()->with('success', 'Объявление удалено!');
    }
}

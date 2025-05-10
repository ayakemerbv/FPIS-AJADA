<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with(['category', 'user']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            $query->orderBy('price', $request->sort === 'price_asc' ? 'asc' : 'desc');
        } else {
            $query->latest(); // По умолчанию сортируем по дате создания
        }

        $ads = $query->paginate(12);
        $categories = Category::all();
        $buildings = \App\Models\Building::all();
        $newsList = News::orderBy('created_at', 'desc')->take(5)->get();

        session()->flash('successType', 'ads_searched');
        return view('student.dashboard', compact('ads', 'categories','buildings','newsList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'contact' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $validated['user_id'] = Auth::id();

        Ad::create($validated);
        session()->flash('successType', 'ad_created');
        return back()->with('success', 'Объявление успешно создано!')->with('successType', 'ad_created');
    }

    public function edit(Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json($ad);
    }

    public function update(Request $request, Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'contact' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($validated);

        return back()->with('success', 'Объявление обновлено!')->with('successType', 'ad_updated');
    }

    public function destroy(Ad $ad)
    {
        if ($ad->user_id !== Auth::id()) {
            abort(403);
        }

        if ($ad->image_path) {
            Storage::disk('public')->delete($ad->image_path);
        }

        $ad->delete();

        return back()->with('success', 'Объявление удалено!')->with('successType', 'ad_deleted');
    }
}

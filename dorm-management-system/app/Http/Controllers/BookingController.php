<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Room; // Если вы используете модель Room
// use App\Models\Booking; // Если у вас модель Booking

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'building_id' => 'required|exists:buildings,id', // Лучше использовать exists для проверки в БД
            'floor'       => 'required|integer',
            'room_id'     => 'required|exists:rooms,id',
            'comments'    => 'nullable|string|max:255',
        ]);

        // Сохранение заявки
        Booking::create([
            'user_id'     => Auth::id(),
            'building_id' => $request->building_id,
            'floor'       => $request->floor,
            'room_id'     => $request->room_id,
            'comments'    => $request->comments,
            'status'      => 'pending', // Например, заявка в ожидании
        ]);

        return redirect()->back()->with('success', 'Заявка на заселение успешно отправлена!');
    }
    public function create()
    {
        $buildings = Building::all();
        return view('booking.create', compact('buildings'));
    }


}

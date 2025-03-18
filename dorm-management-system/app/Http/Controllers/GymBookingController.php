<?php

namespace App\Http\Controllers;

use App\Models\GymBooking;
use Illuminate\Http\Request;

class GymBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return GymBooking::with('student')->paginate(10);
    }

    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'sport' => 'required|string',
            'time'  => 'required', // time or datetime
        ]);

        // Сохраняем в базу, например:
        // SportsBooking::create([
        //     'user_id' => Auth::id(),
        //     'sport'   => $validated['sport'],
        //     'time'    => $validated['time'],
        //     // ... статус, ...
        // ]);

        // Или просто сохраняем в сессию (упрощённо), чтобы отобразить на экране:
        session()->put('sportBooking', [
            'sport' => $validated['sport'],
            'time'  => $validated['time'],
        ]);

        return redirect()->back()->with('success', 'Вы успешно записались на ' . $validated['sport']);
    }

    public function confirm(GymBooking $gymBooking)
    {
        if (auth()->id() !== $gymBooking->student_id && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $gymBooking->confirm();
        return response()->json(['message' => 'Booking confirmed']);
    }

    public function cancel()
    {
        // Если в сессии:
        session()->forget('sportBooking');

        // Если в БД, тогда найти запись и удалить/обновить:
        // $booking = GymBooking::where('user_id', Auth::id())->first();
        // if ($booking) { $booking->delete(); }

        return redirect()->back()->with('success', 'Вы отменили запись на занятие.');
    }
}

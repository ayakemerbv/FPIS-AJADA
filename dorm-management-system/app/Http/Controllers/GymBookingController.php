<?php

namespace App\Http\Controllers;

use App\Models\GymBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function showSportsPage()
    {
        $booking = GymBooking::where('user_id', auth()->id())->first();

        return view('sports.page', ['booking' => $booking]);
    }


    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'sport' => 'required|string',
            'day' => 'required|array',
            'day.*' => 'in:Понедельник,Вторник,Среда,Четверг,Пятница,Суббота,Воскресенье',
            'time'  => 'required|date_format:H:i',
        ]);

        // Проверяем, есть ли уже запись
        $existingBooking = GymBooking::where('user_id', Auth::id())->first();
        if ($existingBooking) {
            return redirect()->back()->with('error', 'Вы уже записаны на занятие.');
        }

        // Сохраняем дни в виде строки
        $daysString = implode(',', $validated['day']);

        // Создаём запись
        GymBooking::create([
            'user_id' => Auth::id(),
            'sport' => $validated['sport'],
            'day' => $daysString, // сохраняем как строку
            'scheduled_time' => $validated['time'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Вы успешно записаны на занятие.');
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
        $booking = GymBooking::where('user_id', Auth::id())->first();

        if ($booking) {
            $booking->delete();
            return redirect()->back()->with('success', 'Вы отменили запись на занятие.');
        }

        return redirect()->back()->with('error', 'У вас нет активной записи.');
    }

}

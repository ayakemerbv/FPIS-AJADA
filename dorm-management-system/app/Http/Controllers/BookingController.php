<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Сохранение заявки (студент отправляет форму)
    public function store(Request $request)
    {
        $request->validate([
            'building' => 'required|integer',
            'floor'    => 'required|integer',
            'room'     => 'required|integer',
        ]);

        Booking::create([
            'user_id'     => Auth::id(),
            'building_id' => $request->building,
            'floor'       => $request->floor,
            'room_id'     => $request->room,
            'status'      => 'pending', // по умолчанию
        ]);

        return redirect()->back()->with('success', 'Заявка на заселение отправлена!');
    }

    // Менеджер видит все заявки со статусом "pending"
    public function indexForManager()
    {
        $requests = Booking::where('status', 'pending')->get();
        return view('manager.requests', compact('requests'));
    }

    // Принять заявку
    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'accepted';
        $booking->save();

        return redirect()->back()->with('success', 'Заявка принята!');
    }

    // Отклонить заявку
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();

        return redirect()->back()->with('success', 'Заявка отклонена!');
    }
}

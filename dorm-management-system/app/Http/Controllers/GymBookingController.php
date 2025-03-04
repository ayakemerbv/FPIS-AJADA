<?php

namespace App\Http\Controllers;

use App\Models\GymBooking;
use Illuminate\Http\Request;

class GymBookingController extends Controller
{
    public function index()
    {
        return GymBooking::with('student')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'scheduled_time' => 'required|date',
        ]);

        return GymBooking::create([
            'student_id' => $request->student_id,
            'scheduled_time' => $request->scheduled_time,
            'status' => GymBooking::STATUS_PENDING,
        ]);
    }

    public function confirm(GymBooking $gymBooking)
    {
        $gymBooking->confirm();
        return response()->json(['message' => 'Booking confirmed']);
    }

    public function cancel(GymBooking $gymBooking)
    {
        $gymBooking->cancel();
        return response()->json(['message' => 'Booking cancelled']);
    }
}

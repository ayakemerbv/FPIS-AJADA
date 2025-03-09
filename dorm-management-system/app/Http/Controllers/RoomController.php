<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoomController extends Controller
{
    public function getRooms(Request $request)
    {
        $rooms = Room::where('building_id', $request->building_id)
            ->where('floor', $request->floor)
            ->where('available_beds', '>', 0)
            ->get(['id', 'room_number', 'available_beds']);

        return response()->json($rooms);
    }
}

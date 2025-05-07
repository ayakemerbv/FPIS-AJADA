<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Student;
use App\Notifications\BookingApproved;
use App\Notifications\BookingChangeRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function getFloors($building_id)
    {
        $floors = Room::where('building_id', $building_id)
            ->select('floor')
            ->distinct()
            ->orderBy('floor')
            ->pluck('floor');

        if ($floors->isEmpty()) {
            return response()->json(['message' => 'Нет этажей в этом корпусе'], 404);
        }

        return response()->json($floors);
    }

    public function getRooms($building_id, $floor) {
        $rooms = Room::where('building_id', $building_id)
            ->where('floor', $floor)
            ->whereColumn('occupied_places', '<', 'capacity')
            ->get(['id', 'room_number']);

        return response()->json($rooms);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'building_id' => 'required|integer|exists:buildings,id',
                'floor'       => 'required|integer',
                'room_id'     => 'required|integer|exists:rooms,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd('Ошибка валидации', $e->errors());
        }


        $room = Room::findOrFail($request->room_id);

        if ($room->occupied_places >= $room->capacity) {
            return redirect()->back()->with('error', 'Комната уже заполнена!');
        }

        Booking::create([
            'user_id'     => Auth::id(),
            'building_id' => $request->building_id,
            'floor'       => $request->floor,
            'room_id'     => $request->room_id,
            'status'      => 'pending',
        ]);

//        return redirect()->back()->with('success', 'Заявка на заселение отправлена!');
        return redirect()->route('student.dashboard')
            ->with('successType', 'request_sent')
            ->with('success', 'Заявка на заселение отправлена!');
    }

    public function indexForManager()
    {
        $requests = Booking::with(['user','building','room'])->whereIn('status', ['pending','pending_change'])
            ->get();

        return view('manager.requests', compact('requests'));
    }
    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $room = $booking->room;

        if ($room->occupied_places >= $room->capacity) {
            return redirect()->back()->with('error', 'Мест в комнате больше нет!');
        }

        DB::transaction(function () use ($booking, $room) {
            // Проверяем статус и выполняем соответствующие действия
            if ($booking->status === 'pending_change') {
                $booking->update(['status' => 'accepted_change']);

                // Обновляем запись студента
                Student::updateOrCreate(
                    ['user_id' => $booking->user_id],
                    [
                        'room_id' => $room->id,
                        'student_id' => $booking->user_id
                    ]
                );

                // Увеличиваем количество занятых мест в новой комнате
                $room->increment('occupied_places');

                // Уменьшаем количество занятых мест в старой комнате
                if ($oldRoom = Room::whereHas('students', function($query) use ($booking) {
                    $query->where('user_id', $booking->user_id);
                })->first()) {
                    $oldRoom->decrement('occupied_places');
                }

                $booking->user->notify(new BookingApproved($room));
            } else if ($booking->status === 'pending') {
                $booking->update(['status' => 'accepted']);
                $room->increment('occupied_places');

                Student::updateOrCreate(
                    ['user_id' => $booking->user_id],
                    [
                        'room_id' => $room->id,
                        'student_id' => $booking->user_id
                    ]
                );
                $booking->user->notify(new BookingApproved($room));
            }

            // Отклоняем все остальные заявки пользователя
            Booking::where('user_id', $booking->user_id)
                ->whereIn('status', ['pending', 'pending_change'])
                ->where('id', '!=', $booking->id)
                ->update(['status' => 'rejected']);
        });

        return redirect()->back()->with('successType', 'request_accepted');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'rejected']);

        return redirect()->back()->with('successType', 'request_rejected');
    }
    public function changeRoom(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'floor'       => 'required|integer',
            'room_id'     => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->room_id);

        $booking = Booking::create([
            'user_id'     => Auth::id(),
            'building_id' => $request->building_id,
            'floor'       => $request->floor,
            'room_id'     => $request->room_id,
            'status'      => 'pending',
        ]);

        $user = Auth::user();
        $user->notify(new BookingChangeRequested($room));

        return redirect()->route('student.personal')
            ->with('successType', 'change_room_created');
    }
}



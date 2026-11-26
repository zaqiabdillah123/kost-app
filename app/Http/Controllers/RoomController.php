<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        // Filter by availability
        if ($request->filled('status')) {
            $query->where('availability_status', $request->status);
        }

        // Filter by floor
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }

        $rooms = $query->orderBy('floor')->orderBy('room_number')->get();
        $floors = Room::query()->distinct()->orderBy('floor')->pluck('floor');

        return view('rooms.index', compact('rooms', 'floors'));
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);

        return view('rooms.show', compact('room'));
    }
}

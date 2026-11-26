<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RoomResource::collection(Room::all()));
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(RoomResource::make(Room::findOrFail($id)));
    }
}

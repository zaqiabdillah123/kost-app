<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(BookingResource::collection(
            Booking::with(['tenant', 'room'])->latest()->get()
        ));
    }

    public function show(int $id): JsonResponse
    {
        $booking = Booking::with(['tenant', 'room'])->findOrFail($id);

        return response()->json(BookingResource::make($booking));
    }
}

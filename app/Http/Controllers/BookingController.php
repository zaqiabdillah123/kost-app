<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function create($roomId)
    {
        $room = Room::findOrFail($roomId);

        if (!$room->isAvailable()) {
            return redirect()->route('rooms.index')
                ->with('error', 'Kamar ini tidak tersedia untuk disewa.');
        }

        return view('bookings.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        $room = Room::findOrFail($request->room_id);

        if (!$room->isAvailable()) {
            return back()->withErrors(['room_id' => 'Kamar ini sudah tidak tersedia.'])->withInput();
        }

        try {
            DB::beginTransaction();

            // Create tenant
            $tenant = Tenant::create([
                'full_name' => $request->full_name,
                'whatsapp_number' => $request->whatsapp_number,
            ]);

            // Create booking
            $booking = Booking::create([
                'tenant_id' => $tenant->id,
                'room_id' => $room->id,
                'move_in_date' => $request->move_in_date,
                'notes' => $request->notes,
                'booking_status' => 'Menunggu Konfirmasi',
            ]);

            DB::commit();

            return redirect()->route('bookings.confirmation', $booking->id)
                ->with('success', 'Pengajuan sewa berhasil dikirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function confirmation($id)
    {
        $booking = Booking::with(['tenant', 'room'])->findOrFail($id);
        return view('bookings.confirmation', compact('booking'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RoomsAndBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['tenant', 'room'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(Booking $booking): View
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $status = $request->validate([
            'booking_status' => ['required', 'in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak,Batal'],
        ])['booking_status'];

        return DB::transaction(function () use ($booking, $status) {
            // Lock the room row to prevent concurrent status changes
            $room = Room::lockForUpdate()->findOrFail($booking->room_id);

            $otherConfirmed = $room->bookings()
                ->where('booking_status', 'Dikonfirmasi')
                ->where('id', '!=', $booking->id)
                ->exists();

            if ($status === 'Dikonfirmasi' && $otherConfirmed) {
                return back()->with('error', 'Kamar ini sudah memiliki pengajuan yang dikonfirmasi.');
            }

            $booking->update(['booking_status' => $status]);

            if ($status === 'Dikonfirmasi') {
                $room->update(['availability_status' => 'Terisi']);
            } elseif (! $room->bookings()->where('booking_status', 'Dikonfirmasi')->exists()) {
                $room->update(['availability_status' => 'Tersedia']);
            }

            return redirect()->route('admin.bookings.index')->with('success', 'Status pengajuan berhasil diperbarui.');
        });
    }

    public function export(): BinaryFileResponse
    {
        $filename = 'laporan-kamar-pengajuan-'.now()->format('Ymd-His').'.xlsx';

        return Excel::download(new RoomsAndBookingsExport, $filename);
    }
}

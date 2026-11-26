<?php

namespace App\Exports\Sheets;

use App\Models\Booking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BookingsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function collection(): Collection
    {
        return Booking::with(['tenant', 'room'])->latest()->get()->map(fn (Booking $booking, int $index): array => [
            $index + 1,
            'BJ'.str_pad((string) $booking->id, 6, '0', STR_PAD_LEFT),
            $booking->room->room_number ?? '-',
            $booking->room->room_type ?? '-',
            $booking->room->floor ?? '-',
            $booking->tenant->full_name ?? '-',
            $booking->tenant->whatsapp_number ?? '-',
            $booking->move_in_date?->format('d F Y') ?? '-',
            $booking->booking_status,
            $booking->room->monthly_price ?? 0,
            $booking->notes ?? '-',
        ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Pengajuan',
            'Nomor Kamar',
            'Tipe Kamar',
            'Lantai',
            'Nama Penyewa',
            'WhatsApp',
            'Tanggal Masuk',
            'Status Pengajuan',
            'Harga/Bulan (Rp)',
            'Catatan',
        ];
    }

    public function title(): string
    {
        return 'Status Pengajuan';
    }
}

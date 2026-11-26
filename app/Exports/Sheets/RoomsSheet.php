<?php

namespace App\Exports\Sheets;

use App\Models\Room;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class RoomsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function collection(): Collection
    {
        return Room::orderBy('floor')->orderBy('room_number')->get()->map(fn (Room $room, int $index): array => [
            $index + 1,
            $room->room_number,
            $room->room_type,
            $room->floor,
            $room->room_size,
            $room->monthly_price,
            $room->facilities,
            $room->availability_status,
            $room->description,
        ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Kamar',
            'Tipe Kamar',
            'Lantai',
            'Ukuran Kamar',
            'Harga/Bulan (Rp)',
            'Fasilitas',
            'Status Kamar',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Kamar';
    }
}

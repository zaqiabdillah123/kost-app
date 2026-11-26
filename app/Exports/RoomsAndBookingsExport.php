<?php

namespace App\Exports;

use App\Exports\Sheets\BookingsSheet;
use App\Exports\Sheets\RoomsSheet;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RoomsAndBookingsExport implements Export, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new RoomsSheet,
            new BookingsSheet,
        ];
    }
}

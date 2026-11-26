@extends('admin._layout')

@section('title', 'Daftar Pengajuan')

@section('content')
    <div class="glass-panel rounded-4 p-3 p-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h1 class="h3 mb-0">Daftar Pengajuan</h1>
            <a href="{{ route('admin.bookings.export') }}" class="btn btn-book">Ekspor Excel Gabungan</a>
        </div>

        @if($bookings->isEmpty())
            <div class="alert alert-light border mb-0">Belum ada pengajuan sewa.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Penyewa</th>
                            <th scope="col">Kamar</th>
                            <th scope="col">Masuk</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            @php
                                $statusClass = match ($booking->booking_status) {
                                    'Dikonfirmasi' => 'text-bg-success',
                                    'Ditolak', 'Batal' => 'text-bg-danger',
                                    default => 'text-bg-warning',
                                };
                            @endphp
                            <tr>
                                <td class="fw-semibold">#BJ{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $booking->tenant->full_name }}</td>
                                <td><span class="info-pill">{{ $booking->room->room_number }}</span></td>
                                <td>{{ $booking->move_in_date->format('d F Y') }}</td>
                                <td><span class="badge {{ $statusClass }}">{{ $booking->booking_status }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-pill">Ubah Status</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

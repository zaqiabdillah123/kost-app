@extends('admin._layout')

@section('title', 'Kelola Kamar')

@section('content')
    <div class="glass-panel rounded-4 p-3 p-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h1 class="h3 mb-0">Kelola Kamar</h1>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.bookings.export') }}" class="btn btn-outline-pill">Ekspor Excel Gabungan</a>
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-book">Tambah Kamar</a>
            </div>
        </div>

        @if($rooms->isEmpty())
            <div class="alert alert-light border mb-0">Belum ada kamar.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Lantai</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td class="fw-semibold">{{ $room->room_number }}</td>
                                <td><span class="info-pill">{{ $room->room_type }}</span></td>
                                <td>{{ $room->floor }}</td>
                                <td>Rp{{ number_format($room->monthly_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $room->availability_status === 'Tersedia' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $room->availability_status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-end gap-2">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-pill">Ubah</a>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus kamar ' + @json($room->room_number) + '?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@extends('admin._layout')

@section('title', 'Ubah Status Pengajuan')

@section('content')
    <div class="glass-panel rounded-4 p-3 p-md-4">
        <h1 class="h3 mb-2">Ubah Status Pengajuan</h1>
        <p class="text-muted mb-4">
            #BJ{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }} {{ $booking->tenant->full_name }},
            kamar {{ $booking->room->room_number }}.
        </p>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="booking_status" class="form-label">Status Pengajuan</label>
                <select id="booking_status" name="booking_status" class="form-select" required>
                    @foreach(['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak', 'Batal'] as $status)
                        <option value="{{ $status }}" {{ old('booking_status', $booking->booking_status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-book">Simpan Status</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-pill">Batal</a>
            </div>
        </form>
    </div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - Detail Kamar {{ $room->room_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            <section class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h1 class="hero-title fw-bold mb-2">Detail Kamar {{ $room->room_number }}</h1>
                    <p class="hero-subtitle mb-0">{{ $room->room_type }} &middot; Lantai {{ $room->floor }}</p>
                </div>
                <span class="badge rounded-pill px-3 py-2 {{ $room->isAvailable() ? 'status-available' : 'status-full' }}">
                    {{ $room->availability_status }}
                </span>
            </section>

            <div class="row g-4">
                <div class="col-lg-7">
                    @if($room->image)
                        <div class="hero-image glass-panel glass-card mb-4 overflow-hidden">
                            <img src="{{ asset($room->image) }}" alt="Foto kamar {{ $room->room_number }}">
                        </div>
                    @endif

                    <section class="glass-panel glass-card p-4 mb-4">
                        <h2 class="h5 fw-bold mb-3">Informasi Kamar</h2>
                        <table class="table table-borderless mb-0 align-middle">
                            <tbody>
                                <tr><th scope="row" class="text-muted fw-normal w-50">Nomor Kamar</th><td>{{ $room->room_number }}</td></tr>
                                <tr><th scope="row" class="text-muted fw-normal">Tipe Kamar</th><td>{{ $room->room_type }}</td></tr>
                                <tr><th scope="row" class="text-muted fw-normal">Lantai</th><td>{{ $room->floor }}</td></tr>
                                <tr><th scope="row" class="text-muted fw-normal">Kamar Mandi</th><td>{{ $room->floor >= 2 ? 'Dalam' : 'Luar' }}</td></tr>
                                <tr><th scope="row" class="text-muted fw-normal">Luas Kamar</th><td>{{ $room->room_size }}</td></tr>
                                <tr><th scope="row" class="text-muted fw-normal">Harga per Bulan</th><td class="fw-semibold">Rp{{ number_format($room->monthly_price, 0, ',', '.') }}</td></tr>
                            </tbody>
                        </table>
                    </section>

                    <section class="glass-panel glass-card p-4">
                        <h2 class="h5 fw-bold mb-3">Fasilitas</h2>
                        @include('rooms._facility-icons', ['room' => $room])
                    </section>
                </div>

                <div class="col-lg-5">
                    <section class="glass-panel glass-card p-4 mb-4">
                        <h2 class="h5 fw-bold mb-3">Deskripsi</h2>
                        <p class="mb-0">{{ $room->description }}</p>
                    </section>

                    <section class="glass-panel glass-card p-4">
                        <p class="room-price mb-4">Rp{{ number_format($room->monthly_price, 0, ',', '.') }}<small> /bulan</small></p>
                        <div class="d-grid gap-2">
                            @if($room->isAvailable())
                                <a href="{{ route('bookings.create', $room->id) }}" class="btn btn-book">Sewa Kamar</a>
                            @else
                                <button type="button" class="btn btn-room-full" disabled>Penuh</button>
                            @endif
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-pill">Kembali ke Daftar</a>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <footer class="footer border-top">
            <div class="container py-3 small text-center">&copy; {{ date('Y') }} Kost Boongan - Kelompok 5. All rights reserved.</div>
        </footer>
    </div>
</body>
</html>

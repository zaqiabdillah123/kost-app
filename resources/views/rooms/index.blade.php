<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - Daftar Kamar</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <section class="row align-items-center g-4 g-lg-5 mb-5">
                <div class="col-lg-6">
                    <h1 class="hero-title fw-bold mb-3">Temukan Kost Terbaik Anda</h1>
                    <p class="hero-subtitle mb-0">Daftar kamar yang tersedia untuk disewa</p>
                </div>
                <div class="col-lg-6">
                    <div class="glass-panel glass-filter p-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="status" class="form-label mb-1 small fw-semibold">Status</label>
                                <select id="status" class="form-select" onchange="applyRoomFilter(this, 'status')">
                                    <option value="">Semua Status</option>
                                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Terisi" {{ request('status') == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="floor" class="form-label mb-1 small fw-semibold">Lantai</label>
                                <select id="floor" class="form-select" onchange="applyRoomFilter(this, 'floor')">
                                    <option value="">Semua Lantai</option>
                                    @foreach($floors as $floor)
                                        <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }}>Lantai {{ $floor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($rooms as $room)
                    <div class="col">
                        <article class="card room-card h-100">
                            <div class="position-relative">
                                @if($room->image)
                                    <img src="{{ asset($room->image) }}" alt="Foto kamar {{ $room->room_number }}" class="card-img-top room-image">
                                @else
                                    <div class="room-image room-image-placeholder d-flex align-items-center justify-content-center">
                                        <span class="text-muted small">Foto kamar belum tersedia</span>
                                    </div>
                                @endif
                                <span class="badge rounded-pill room-status {{ $room->isAvailable() ? 'status-available' : 'status-full' }}">
                                    {{ $room->availability_status }}
                                </span>
                            </div>
                            <div class="card-body room-info glass-panel p-4 d-flex flex-column">
                                <h2 class="h5 fw-bold mb-2">{{ $room->room_number }} - {{ $room->room_type }}</h2>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="info-pill">Lantai {{ $room->floor }}</span>
                                    <span class="info-pill">{{ $room->room_size }}</span>
                                </div>
                                @include('rooms._facility-icons', ['room' => $room])
                                <p class="room-price mt-auto mb-3">Rp{{ number_format($room->monthly_price, 0, ',', '.') }}<small> /bulan</small></p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-pill flex-fill">Detail</a>
                                    @if($room->isAvailable())
                                        <a href="{{ route('bookings.create', $room->id) }}" class="btn btn-book flex-fill">Sewa Kamar</a>
                                    @else
                                        <button type="button" class="btn btn-room-full flex-fill" disabled>Penuh</button>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            @if($rooms->isEmpty())
                <div class="alert alert-info mt-4 mb-0">Tidak ada kamar yang sesuai dengan filter.</div>
            @endif
        </main>
        <footer class="footer border-top">
            <div class="container py-3 small text-center">&copy; {{ date('Y') }} Kost Boongan - Kelompok 5. All rights reserved.</div>
        </footer>
    </div>
    <script>
        function applyRoomFilter(select, key) {
            const url = new URL(window.location.href);
            if (select.value === '') {
                url.searchParams.delete(key);
            } else {
                url.searchParams.set(key, select.value);
            }
            window.location.assign(url.toString());
        }
    </script>
</body>
</html>

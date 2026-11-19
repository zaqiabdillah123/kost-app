<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - Form Pengajuan Sewa</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-pill btn-sm mb-4">&laquo; Kembali ke Detail Kamar</a>

            <section class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h1 class="hero-title fw-bold mb-2">Form Pengajuan Sewa Kamar</h1>
                    <p class="hero-subtitle mb-0">Lengkapi data berikut untuk mengajukan sewa kamar {{ $room->room_number }}</p>
                </div>
                <span class="badge rounded-pill px-3 py-2 {{ $room->isAvailable() ? 'status-available' : 'status-full' }}">
                    {{ $room->availability_status }}
                </span>
            </section>

            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="glass-panel glass-card p-4">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('bookings.store') }}" novalidate>
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label fw-semibold">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" required autocomplete="name">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="whatsapp_number" class="form-label fw-semibold">Nomor WhatsApp Aktif <span class="required">*</span></label>
                                    <input type="tel" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" class="form-control @error('whatsapp_number') is-invalid @enderror" placeholder="Contoh: 081234567890" required autocomplete="tel">
                                    @error('whatsapp_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="move_in_date" class="form-label fw-semibold">Tanggal Rencana Masuk <span class="required">*</span></label>
                                    <input type="date" id="move_in_date" name="move_in_date" value="{{ old('move_in_date', date('Y-m-d')) }}" class="form-control @error('move_in_date') is-invalid @enderror" required min="{{ date('Y-m-d') }}" autocomplete="off">
                                    @error('move_in_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="room" class="form-label fw-semibold">Kamar yang Disewa</label>
                                    <input type="text" id="room" class="form-control" value="{{ $room->room_number }} - {{ $room->room_type }} (Lantai {{ $room->floor }})" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="price" class="form-label fw-semibold">Harga Sewa per Bulan</label>
                                    <input type="text" id="price" class="form-control" value="Rp{{ number_format($room->monthly_price, 0, ',', '.') }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="notes" class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="4" class="form-control">{{ old('notes') }}</textarea>
                                </div>

                                <div class="col-12 d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-book flex-fill">Kirim Pengajuan</button>
                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-pill flex-fill">Batal</a>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div class="col-lg-4">
                    <section class="glass-panel glass-card p-4">
                        @if($room->image)
                            <div class="glass-panel glass-card overflow-hidden mb-3">
                                <img src="{{ asset($room->image) }}" alt="Foto kamar {{ $room->room_number }}" class="room-image">
                            </div>
                        @endif
                        <h2 class="h5 fw-bold mb-3">Kamar yang Dipilih</h2>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="info-pill">Lantai {{ $room->floor }}</span>
                            <span class="info-pill">{{ $room->room_size }}</span>
                        </div>
                        @include('rooms._facility-icons', ['room' => $room])
                        <p class="room-price mb-0">Rp{{ number_format($room->monthly_price, 0, ',', '.') }}<small> /bulan</small></p>
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

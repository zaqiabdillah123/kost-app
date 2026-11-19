<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - Konfirmasi Pengajuan</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            @php $bookingCode = '#BJ' . str_pad($booking->id, 6, '0', STR_PAD_LEFT); @endphp
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <section class="mb-4">
                <h1 class="hero-title fw-bold mb-2">Pengajuan Sewa Berhasil Dikirim</h1>
                <p class="hero-subtitle mb-0">Nomor pengajuan {{ $bookingCode }}</p>
            </section>

            <div class="row g-4">
                <div class="col-lg-7">
                    <section class="glass-panel glass-card p-4 mb-4">
                        <h2 class="h5 fw-bold mb-3">Detail Pengajuan</h2>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr><th scope="row" class="text-muted fw-normal w-50">Nomor Pengajuan</th><td class="fw-semibold">{{ $bookingCode }}</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Nama Penyewa</th><td>{{ $booking->tenant->full_name }}</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Nomor WhatsApp</th><td>{{ $booking->tenant->whatsapp_number }}</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Kamar</th><td>{{ $booking->room->room_number }} - {{ $booking->room->room_type }} (Lantai {{ $booking->room->floor }})</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Harga Sewa per Bulan</th><td>Rp{{ number_format($booking->room->monthly_price, 0, ',', '.') }}</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Tanggal Rencana Masuk</th><td>{{ $booking->move_in_date->format('d F Y') }}</td></tr>
                                    <tr><th scope="row" class="text-muted fw-normal">Status Pengajuan</th><td><span class="info-pill">{{ $booking->booking_status }}</span></td></tr>
                                    @if($booking->notes)
                                        <tr><th scope="row" class="text-muted fw-normal">Catatan</th><td>{{ $booking->notes }}</td></tr>
                                    @endif
                                    <tr><th scope="row" class="text-muted fw-normal">Tanggal Pengajuan</th><td>{{ $booking->created_at->format('d F Y H:i') }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="glass-panel glass-card p-4">
                        <h2 class="h5 fw-bold mb-3">Langkah Selanjutnya</h2>
                        <p class="mb-0">Pengajuan Anda telah diterima dengan status <strong>Menunggu Konfirmasi</strong>. Pengelola kos akan menghubungi Anda melalui WhatsApp untuk proses verifikasi dan pembayaran.</p>
                    </section>
                </div>

                <div class="col-lg-5">
                    <section class="glass-panel glass-card p-4">
                        @if($booking->room->image)
                            <div class="glass-panel glass-card overflow-hidden mb-3">
                                <img src="{{ asset($booking->room->image) }}" alt="Foto kamar {{ $booking->room->room_number }}" class="room-image">
                            </div>
                        @endif
                        <h2 class="h5 fw-bold mb-3">Kamar yang Diajukan</h2>
                        <p class="fw-semibold mb-2">{{ $booking->room->room_number }} - {{ $booking->room->room_type }}</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="info-pill">Lantai {{ $booking->room->floor }}</span>
                            <span class="info-pill">{{ $booking->room->room_size }}</span>
                        </div>
                        @include('rooms._facility-icons', ['room' => $booking->room])
                        <p class="room-price mb-4">Rp{{ number_format($booking->room->monthly_price, 0, ',', '.') }}<small> /bulan</small></p>

                        @php
                            $message = "Halo, saya *{$booking->tenant->full_name}* ingin mengajukan sewa kamar *{$booking->room->room_number}* ({$booking->room->room_type}) di Kost Boongan.\n\n";
                            $message .= "Detail pengajuan:\n";
                            $message .= "- Nomor Pengajuan: {$bookingCode}\n";
                            $message .= "- Kamar: {$booking->room->room_number} (Lantai {$booking->room->floor})\n";
                            $message .= "- Tipe: {$booking->room->room_type}\n";
                            $message .= "- Harga: Rp" . number_format($booking->room->monthly_price, 0, ',', '.') . "/bulan\n";
                            $message .= "- Tanggal Masuk: {$booking->move_in_date->format('d F Y')}\n";
                            $message .= "- Status: {$booking->booking_status}\n\n";
                            $message .= "Mohon konfirmasi dan informasi lebih lanjut. Terima kasih.";
                            $whatsappUrl = "https://wa.me/6281234567890?text=" . urlencode($message);
                        @endphp

                        <div class="d-grid gap-2">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-book">Hubungi Pengelola via WhatsApp</a>
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-pill">Kembali ke Daftar Kamar</a>
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

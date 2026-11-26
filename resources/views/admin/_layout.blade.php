<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            <nav class="glass-panel rounded-4 p-2 p-md-3 mb-4 d-flex flex-wrap align-items-center gap-2" aria-label="Navigasi admin">
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm {{ request()->routeIs('admin.rooms.*') ? 'btn-book' : 'btn-outline-pill' }}">Kamar</a>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm {{ request()->routeIs('admin.bookings.*') ? 'btn-book' : 'btn-outline-pill' }}">Pengajuan</a>
                <form method="POST" action="{{ route('logout') }}" class="ms-auto mb-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">Keluar</button>
                </form>
            </nav>

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Boongan - Masuk Admin</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#main" class="skip-link">Lewati ke konten utama</a>
    <div class="page-wrapper">
        @include('_navbar')

        <main id="main" class="container py-4 py-lg-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="glass-panel rounded-4 p-4 p-md-5">
                        <h1 class="h3 mb-4">Masuk Admin</h1>

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <button type="submit" class="btn btn-book">Masuk</button>
                                <a href="{{ route('rooms.index') }}" class="btn btn-outline-pill">Kembali ke Daftar Kamar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

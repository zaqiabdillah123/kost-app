        <header class="glass-panel glass-nav">
            <nav class="container d-flex align-items-center py-3">
                <a href="{{ route('rooms.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark">
                    <svg class="brand-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 11.5 12 4l9 7.5"/>
                        <path d="M5.5 10.5V20h13v-9.5"/>
                        <path d="M10 20v-5.5h4V20"/>
                    </svg>
                    <span class="brand-name">Kost Boongan</span>
                </a>
                <div class="ms-auto d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-pill">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-pill">Login Admin</a>
                    @endauth
                </div>
            </nav>
        </header>

<div class="row g-1 facility-grid text-center mb-3">
    @if(stripos($room->facilities, 'wifi') !== false)
        <div class="col-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                <path d="M2 8.5a16 16 0 0 1 20 0"/>
                <path d="M5 12a11 11 0 0 1 14 0"/>
                <path d="M8.5 15.5a6 6 0 0 1 7 0"/>
                <circle cx="12" cy="19" r="1" fill="currentColor" stroke="none"/>
            </svg>
            <span class="facility-label">WiFi</span>
        </div>
    @endif
    @if(preg_match('/\bac\b/i', $room->facilities))
        <div class="col-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="5" width="18" height="7" rx="2"/>
                <path d="M6 16h5M14 16h4M8 19h4"/>
            </svg>
            <span class="facility-label">AC</span>
        </div>
    @endif
    @if(stripos($room->facilities, 'tempat tidur') !== false || stripos($room->facilities, 'kasur') !== false)
        <div class="col-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 18v-6h18v6"/>
                <path d="M6 12V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                <path d="M12 12V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
            </svg>
            <span class="facility-label">Kasur</span>
        </div>
    @endif
    @if(stripos($room->facilities, 'meja') !== false)
        <div class="col-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 10h18v2H3z"/>
                <path d="M5 12v8M19 12v8"/>
                <path d="M8 10V7h8v3"/>
            </svg>
            <span class="facility-label">Meja</span>
        </div>
    @endif
</div>

<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_rooms_api_returns_json(): void
    {
        $room = Room::create([
            'room_number' => 'K901',
            'room_type' => 'Standard',
            'floor' => 1,
            'room_size' => '10 m2',
            'monthly_price' => 700000,
            'facilities' => 'WiFi',
            'description' => 'Kamar uji.',
            'availability_status' => 'Tersedia',
        ]);

        $this->getJson('/api/rooms')
            ->assertOk()
            ->assertJsonFragment(['room_number' => 'K901']);

        $this->getJson('/api/rooms/'.$room->id)
            ->assertOk()
            ->assertJsonFragment(['room_number' => 'K901']);
    }

    public function test_bookings_api_returns_json(): void
    {
        $room = Room::create([
            'room_number' => 'K902',
            'room_type' => 'Standard',
            'floor' => 1,
            'room_size' => '10 m2',
            'monthly_price' => 700000,
            'facilities' => 'WiFi',
            'description' => 'Kamar uji.',
            'availability_status' => 'Tersedia',
        ]);

        $tenant = Tenant::create([
            'full_name' => 'Penyewa Uji',
            'whatsapp_number' => '081234567890',
        ]);

        $booking = Booking::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'move_in_date' => now()->toDateString(),
            'booking_status' => 'Dikonfirmasi',
        ]);

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->getJson('/api/bookings')
            ->assertOk();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->getJson('/api/bookings/'.$booking->id)
            ->assertOk()
            ->assertJsonFragment(['booking_status' => 'Dikonfirmasi']);
    }

    public function test_guest_cannot_access_bookings_api(): void
    {
        $this->getJson('/api/bookings')->assertUnauthorized();
        $this->getJson('/api/bookings/1')->assertUnauthorized();
    }

    public function test_non_admin_cannot_access_bookings_api(): void
    {
        $this->actingAs(User::factory()->create())
            ->getJson('/api/bookings')
            ->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Models\Room;
use Database\Seeders\RoomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_status_filter_shows_all_rooms(): void
    {
        $this->seed(RoomSeeder::class);

        $this->get('/kamar?status=')
            ->assertOk()
            ->assertSee('K101')
            ->assertSee('K102');
    }

    public function test_status_filter_shows_only_matching_rooms(): void
    {
        $this->seed(RoomSeeder::class);

        $this->get('/kamar?status=Tersedia')
            ->assertOk()
            ->assertSee('K101')
            ->assertDontSee('K102');
    }

    public function test_facility_icons_follow_room_data(): void
    {
        $this->seed(RoomSeeder::class);

        Room::query()->update(['facilities' => 'WiFi only']);
        $this->get('/kamar')
            ->assertOk()
            ->assertSee('WiFi')
            ->assertDontSee('Kasur')
            ->assertDontSee('Meja');

        Room::query()->update(['facilities' => 'wifi, ac, kasur, meja']);
        $this->get('/kamar')
            ->assertOk()
            ->assertSee('WiFi')
            ->assertSee('AC')
            ->assertSee('Kasur')
            ->assertSee('Meja');

        Room::query()->update(['facilities' => 'WiFi, kaca']);
        $this->get('/kamar')
            ->assertOk()
            ->assertDontSee('AC');
    }

    public function test_detail_shows_bathroom_by_floor(): void
    {
        $this->seed(RoomSeeder::class);

        $this->get('/kamar/5')->assertOk()->assertSee('Kamar Mandi')->assertSee('Dalam');
        $this->get('/kamar/1')->assertOk()->assertSee('Kamar Mandi')->assertSee('Luar');
    }

    public function test_booking_confirmation_renders(): void
    {
        $this->seed(RoomSeeder::class);

        $this->post('/sewa', [
            'full_name' => 'Uji Pengguna',
            'whatsapp_number' => '081234567890',
            'room_id' => 1,
            'move_in_date' => now()->addDay()->toDateString(),
        ])->assertRedirect();

        $this->get('/pengajuan/1')
            ->assertOk()
            ->assertSee('#BJ000001')
            ->assertSee('wa.me/62895337264630', false);
    }
}

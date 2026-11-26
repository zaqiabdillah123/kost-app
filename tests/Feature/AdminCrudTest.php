<?php

namespace Tests\Feature;

use App\Exports\RoomsAndBookingsExport;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_shows_admin_link(): void
    {
        $this->get(route('rooms.index'))
            ->assertOk()
            ->assertSee('Login Admin')
            ->assertDontSee('Dashboard Admin');

        $this->actingAs(User::factory()->create())
            ->get(route('rooms.index'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertDontSee('Login Admin');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.rooms.index'))->assertRedirect(route('login'));
        $this->get(route('admin.bookings.export'))->assertRedirect(route('login'));
    }

    public function test_non_admin_is_forbidden_from_admin_area(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.rooms.index'))
            ->assertForbidden();
    }

    public function test_failed_login_shows_error(): void
    {
        User::factory()->create([
            'email' => 'admin@kostboongan.test',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $this->post(route('login.store'), [
            'email' => 'admin@kostboongan.test',
            'password' => 'wrong',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
    }

    public function test_confirmation_page_requires_matching_session(): void
    {
        $room = $this->room();
        $booking = $this->booking($room);

        $this->get(route('bookings.confirmation', $booking->id))->assertNotFound();

        $this->withSession(['booking_confirmation_id' => $booking->id])
            ->get(route('bookings.confirmation', $booking->id))
            ->assertOk();
    }

    public function test_floor_filter_keeps_all_floors(): void
    {
        $this->room();

        Room::create([
            'room_number' => 'K202',
            'room_type' => 'Standard',
            'floor' => 2,
            'room_size' => '10 m2',
            'monthly_price' => 700000,
            'facilities' => 'WiFi',
            'description' => 'Kamar uji.',
            'availability_status' => 'Terisi',
        ]);

        $this->get(route('rooms.index', ['status' => 'Tersedia']))
            ->assertOk()
            ->assertSee('Lantai 5')
            ->assertSee('Lantai 2');
    }

    public function test_admin_can_download_combined_excel(): void
    {
        $room = $this->room();
        $this->booking($room);

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.bookings.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $sheets = (new RoomsAndBookingsExport)->sheets();

        $this->assertCount(2, $sheets);
        $this->assertSame('Kamar', $sheets[0]->title());
        $this->assertSame('Status Pengajuan', $sheets[1]->title());
        $this->assertSame('K501', $sheets[0]->collection()->first()[1]);
        $this->assertSame('Penyewa Uji', $sheets[1]->collection()->first()[5]);
        $this->assertSame('Menunggu Konfirmasi', $sheets[1]->collection()->first()[8]);
    }

    public function test_admin_can_open_room_forms(): void
    {
        $room = $this->room();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.rooms.index'))
            ->assertOk()
            ->assertSee('Ekspor Excel Gabungan');

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.rooms.create'))
            ->assertOk()
            ->assertSee('Tambah Kamar')
            ->assertSee('images/rooms/700.jpg')
            ->assertSee('images/rooms/900.jpg')
            ->assertSee('images/rooms/1500.jpg');

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.rooms.edit', $room))
            ->assertOk()
            ->assertSee('Ubah Kamar');
    }

    public function test_admin_can_create_room(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->post(route('admin.rooms.store'), [
                'room_number' => 'K401',
                'room_type' => 'Ekonomis',
                'floor' => 4,
                'room_size' => '10 m2',
                'monthly_price' => 800000,
                'facilities' => 'WiFi, AC',
                'description' => 'Kamar uji.',
                'availability_status' => 'Tersedia',
            ])
            ->assertRedirect(route('admin.rooms.index'));

        $this->assertDatabaseHas('rooms', ['room_number' => 'K401']);

        $room = Room::where('room_number', 'K401')->firstOrFail();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get(route('admin.rooms.edit', $room))
            ->assertOk()
            ->assertSee('value="4" min="1" required', false);
    }

    public function test_admin_can_choose_default_room_image(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->post(route('admin.rooms.store'), [
                'room_number' => 'K403',
                'room_type' => 'Ekonomis',
                'floor' => 4,
                'room_size' => '10 m2',
                'monthly_price' => 800000,
                'facilities' => 'WiFi, AC',
                'description' => 'Kamar uji.',
                'availability_status' => 'Tersedia',
                'default_image' => 'images/rooms/900.jpg',
            ])
            ->assertRedirect(route('admin.rooms.index'));

        $this->assertDatabaseHas('rooms', [
            'room_number' => 'K403',
            'image' => 'images/rooms/900.jpg',
        ]);
    }

    public function test_admin_can_upload_room_image(): void
    {
        $source = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('kost-', true).'.jpg';
        copy(public_path('images/rooms/700.jpg'), $source);
        $absolutePath = null;

        try {
            $image = new UploadedFile($source, 'foto.jpg', 'image/jpeg', null, true);

            $this->actingAs(User::factory()->create(['is_admin' => true]))
                ->post(route('admin.rooms.store'), [
                    'room_number' => 'K777',
                    'room_type' => 'Ekonomis',
                    'floor' => 1,
                    'room_size' => '9 m2',
                    'monthly_price' => 700000,
                    'facilities' => 'WiFi',
                    'description' => 'Kamar uji.',
                    'availability_status' => 'Tersedia',
                    'image' => $image,
                ])
                ->assertRedirect(route('admin.rooms.index'));

            $imagePath = Room::where('room_number', 'K777')->firstOrFail()->image;
            $absolutePath = public_path($imagePath);

            $this->assertStringStartsWith('images/rooms/', $imagePath);
            $this->assertFileExists($absolutePath);
        } finally {
            foreach (array_filter([$source, $absolutePath]) as $path) {
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }
    }

    public function test_room_with_booking_cannot_be_deleted(): void
    {
        $room = $this->room();
        $this->booking($room);

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->delete(route('admin.rooms.destroy', $room))
            ->assertRedirect();

        $this->assertDatabaseHas('rooms', ['id' => $room->id]);
    }

    public function test_confirming_booking_marks_room_occupied(): void
    {
        $room = $this->room();
        $booking = $this->booking($room);

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->put(route('admin.bookings.update', $booking), ['booking_status' => 'Dikonfirmasi'])
            ->assertRedirect(route('admin.bookings.index'));

        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'booking_status' => 'Dikonfirmasi']);
        $this->assertDatabaseHas('rooms', ['id' => $room->id, 'availability_status' => 'Terisi']);
    }

    private function room(): Room
    {
        return Room::create([
            'room_number' => 'K501',
            'room_type' => 'Standard',
            'floor' => 5,
            'room_size' => '12 m2',
            'monthly_price' => 900000,
            'facilities' => 'WiFi',
            'description' => 'Kamar uji.',
            'availability_status' => 'Tersedia',
        ]);
    }

    private function booking(Room $room): Booking
    {
        $tenant = Tenant::create([
            'full_name' => 'Penyewa Uji',
            'whatsapp_number' => '081234567890',
        ]);

        return Booking::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'move_in_date' => now()->toDateString(),
            'booking_status' => 'Menunggu Konfirmasi',
        ]);
    }
}

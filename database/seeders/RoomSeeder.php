<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => 'K101',
                'room_type' => 'Ekonomis',
                'floor' => 1,
                'room_size' => '9 m²',
                'monthly_price' => 700000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari',
                'description' => 'Kamar ekonomis yang cocok untuk mahasiswa atau penghuni dengan kebutuhan tempat tinggal sederhana.',
                'availability_status' => 'Tersedia',
                'image' => null,
            ],
            [
                'room_number' => 'K102',
                'room_type' => 'Ekonomis',
                'floor' => 1,
                'room_size' => '9 m²',
                'monthly_price' => 700000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari',
                'description' => 'Kamar ekonomis yang cocok untuk mahasiswa atau penghuni dengan kebutuhan tempat tinggal sederhana.',
                'availability_status' => 'Terisi',
                'image' => null,
            ],
            [
                'room_number' => 'K103',
                'room_type' => 'Ekonomis',
                'floor' => 1,
                'room_size' => '9 m²',
                'monthly_price' => 700000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari',
                'description' => 'Kamar ekonomis yang cocok untuk mahasiswa atau penghuni dengan kebutuhan tempat tinggal sederhana.',
                'availability_status' => 'Tersedia',
                'image' => null,
            ],
            [
                'room_number' => 'K201',
                'room_type' => 'Standard',
                'floor' => 2,
                'room_size' => '12 m²',
                'monthly_price' => 900000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari, ruang kamar lebih luas',
                'description' => 'Kamar dengan ruang lebih lega untuk menunjang aktivitas belajar, bekerja, dan beristirahat.',
                'availability_status' => 'Tersedia',
                'image' => null,
            ],
            [
                'room_number' => 'K202',
                'room_type' => 'Standard',
                'floor' => 2,
                'room_size' => '12 m²',
                'monthly_price' => 900000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari, ruang kamar lebih luas',
                'description' => 'Kamar dengan ruang lebih lega untuk menunjang aktivitas belajar, bekerja, dan beristirahat.',
                'availability_status' => 'Tersedia',
                'image' => null,
            ],
            [
                'room_number' => 'K203',
                'room_type' => 'Standard',
                'floor' => 2,
                'room_size' => '12 m²',
                'monthly_price' => 900000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari, ruang kamar lebih luas',
                'description' => 'Kamar dengan ruang lebih lega untuk menunjang aktivitas belajar, bekerja, dan beristirahat.',
                'availability_status' => 'Terisi',
                'image' => null,
            ],
            [
                'room_number' => 'K301',
                'room_type' => 'Premium',
                'floor' => 3,
                'room_size' => '20 m²',
                'monthly_price' => 1500000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari, area ruangan yang lebih luas',
                'description' => 'Kamar dengan ukuran lebih besar dan kenyamanan ekstra untuk penghuni yang menginginkan ruang lebih luas.',
                'availability_status' => 'Tersedia',
                'image' => null,
            ],
            [
                'room_number' => 'K302',
                'room_type' => 'Premium',
                'floor' => 3,
                'room_size' => '20 m²',
                'monthly_price' => 1500000,
                'facilities' => 'WiFi, AC, tempat tidur, meja belajar, lemari, area ruangan yang lebih luas',
                'description' => 'Kamar dengan ukuran lebih besar dan kenyamanan ekstra untuk penghuni yang menginginkan ruang lebih luas.',
                'availability_status' => 'Terisi',
                'image' => null,
            ],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(
                ['room_number' => $room['room_number']],
                $room
            );
        }
    }
}
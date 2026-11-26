<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public const DEFAULT_IMAGES = [
        'images/rooms/700.jpg',
        'images/rooms/900.jpg',
        'images/rooms/1500.jpg',
    ];

    public function index(): View
    {
        $rooms = Room::orderBy('floor')->orderBy('room_number')->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('admin.rooms.create', ['defaultImages' => self::DEFAULT_IMAGES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $this->storeImage($request, $data);

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', ['room' => $room, 'defaultImages' => self::DEFAULT_IMAGES]);
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $data = $request->validate($this->rules($room->id));

        $this->storeImage($request, $data);

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        if ($room->bookings()->exists()) {
            return back()->with('error', 'Kamar tidak dapat dihapus karena masih memiliki pengajuan sewa.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?int $roomId = null): array
    {
        return [
            'room_number' => ['required', 'string', 'max:255', Rule::unique('rooms', 'room_number')->ignore($roomId)],
            'room_type' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'integer', 'min:1'],
            'room_size' => ['required', 'string', 'max:255'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'facilities' => ['required', 'string'],
            'description' => ['required', 'string'],
            'availability_status' => ['required', 'in:Tersedia,Terisi'],
            'default_image' => ['nullable', Rule::in(self::DEFAULT_IMAGES)],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function storeImage(Request $request, array &$data): void
    {
        $defaultImage = $data['default_image'] ?? null;
        unset($data['default_image']);

        if ($request->hasFile('image')) {
            // shortcut: seed photos are shared by several rooms, so replaced files stay on disk; use a media table when photos must be per-room.
            $file = $request->file('image');
            $filename = Str::random(10).'.'.$file->extension();
            $file->move(public_path('images/rooms'), $filename);
            $data['image'] = 'images/rooms/'.$filename;

            return;
        }

        if ($defaultImage !== null) {
            $data['image'] = $defaultImage;
        }
    }
}

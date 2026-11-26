@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($room) ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" enctype="multipart/form-data" class="row g-3">
    @csrf
    @if(isset($room))
        @method('PUT')
    @endif

    <div class="col-md-6">
        <label for="room_number" class="form-label">Nomor Kamar</label>
        <input type="text" id="room_number" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number', $room?->room_number) }}" required>
    </div>
    <div class="col-md-6">
        <label for="room_type" class="form-label">Tipe Kamar</label>
        <input type="text" id="room_type" name="room_type" class="form-control @error('room_type') is-invalid @enderror" value="{{ old('room_type', $room?->room_type) }}" required>
    </div>
    <div class="col-md-6">
        <label for="floor" class="form-label">Lantai</label>
        <input type="number" id="floor" name="floor" class="form-control @error('floor') is-invalid @enderror" value="{{ old('floor', $room?->floor) }}" min="1" required>
    </div>
    <div class="col-md-6">
        <label for="room_size" class="form-label">Luas Kamar</label>
        <input type="text" id="room_size" name="room_size" class="form-control @error('room_size') is-invalid @enderror" value="{{ old('room_size', $room?->room_size) }}" placeholder="9 m2" required>
    </div>
    <div class="col-md-6">
        <label for="monthly_price" class="form-label">Harga per Bulan</label>
        <input type="number" id="monthly_price" name="monthly_price" class="form-control @error('monthly_price') is-invalid @enderror" value="{{ old('monthly_price', $room?->monthly_price) }}" min="0" required>
    </div>
    <div class="col-md-6">
        <label for="availability_status" class="form-label">Status</label>
        <select id="availability_status" name="availability_status" class="form-select @error('availability_status') is-invalid @enderror" required>
            @foreach(['Tersedia', 'Terisi'] as $status)
                <option value="{{ $status }}" {{ old('availability_status', $room?->availability_status) === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label for="facilities" class="form-label">Fasilitas</label>
        <textarea id="facilities" name="facilities" class="form-control @error('facilities') is-invalid @enderror" rows="3" required>{{ old('facilities', $room?->facilities) }}</textarea>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', $room?->description) }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Foto Default</label>
        <div class="row g-2">
            @foreach($defaultImages as $path)
                <div class="col-6 col-md-4">
                    <label class="d-block position-relative border rounded-3 overflow-hidden" style="cursor: pointer;">
                        <input type="radio" name="default_image" value="{{ $path }}" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('default_image', $room?->image) === $path ? 'checked' : '' }}>
                        <img src="{{ asset($path) }}" alt="Foto default {{ basename($path) }}" class="img-fluid w-100" style="height: 100px; object-fit: cover;">
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-text">Pilih salah satu foto default, atau unggah foto sendiri di bawah.</div>
    </div>
    <div class="col-12">
        <label for="image" class="form-label">Unggah Foto Sendiri (opsional)</label>
        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png">
        @error('default_image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 d-flex flex-wrap gap-2 mt-2">
        <button type="submit" class="btn btn-book">Simpan</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-pill">Batal</a>
    </div>
</form>

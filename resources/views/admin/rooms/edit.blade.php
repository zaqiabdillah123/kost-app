@extends('admin._layout')

@section('title', 'Ubah Kamar '.$room->room_number)

@section('content')
    <div class="glass-panel rounded-4 p-3 p-md-4">
        <h1 class="h3 mb-4">Ubah Kamar {{ $room->room_number }}</h1>
        @include('admin.rooms.form', ['room' => $room])
    </div>
@endsection

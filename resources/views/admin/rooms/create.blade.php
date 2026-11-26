@extends('admin._layout')

@section('title', 'Tambah Kamar')

@section('content')
    <div class="glass-panel rounded-4 p-3 p-md-4">
        <h1 class="h3 mb-4">Tambah Kamar</h1>
        @include('admin.rooms.form', ['room' => null])
    </div>
@endsection

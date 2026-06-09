@extends('admin.layout')
@section('title','Tambah Kategori')
@section('content')
<form action="{{ route('admin.kategori.store') }}" method="POST">
    @csrf
    <div>
        <label for="nama_kategori">Nama Kategori</label>
        <input type="text" name="nama_kategori" id="nama_kategori" required>
    </div>

    <button type="submit">Simpan</button>
</form>
@endsection
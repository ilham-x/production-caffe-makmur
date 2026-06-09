@extends("admin.layout")
@section("title","Data Kategori")
@section("content")
<form action="{{ route('admin.kategori.update', $kategori->id) }}" method="post">
    @csrf
    @method("PUT")
    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" placeholder="Nama Kategori">
    <button type="submit">Update</button>
</form>
@endsection

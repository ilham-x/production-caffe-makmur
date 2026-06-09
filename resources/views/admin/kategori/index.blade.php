@extends("admin.layout")
@section("title","Data Kategori")
@section("content")
<a href="{{ route('admin.kategori.create') }}">
    <button>+ Tambah Kategori</button>
</a>
<table>
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @forelse($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>
                    <a href="{{ route('admin.kategori.edit',$kategori->id) }}">
                        <button>Edit</button>
                    </a>

                    <form action="{{ route('admin.kategori.destroy',$kategori->id) }}" 
                          method="POST" 
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus kategori?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">Belum ada kategori</td>
            </tr>
            @endforelse
        </tr>
    </tbody>
</table>


@endsection
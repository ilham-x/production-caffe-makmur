@extends('admin.layout')

@section('title','Meja')

@section('content')

<a href="{{ route('admin.meja.create') }}" class="btn-theme">
    + Tambah
</a>

<div class="card">

    <table>

        <thead>
            <tr>
                <th>No Meja</th>
                <th>Status</th>
                <th>QR</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($mejas as $meja)

            <tr>

                <td>
                    {{ $meja->nomor_meja }}
                </td>

                <td>

                    @if($meja->status == 'aktif')

                        <span class="status-aktif">
                            Aktif
                        </span>

                    @else

                        <span class="status-nonaktif">
                            Non Aktif
                        </span>

                    @endif

                </td>

                <td>

                    <a 
                        href="{{ route('admin.meja.show',$meja->id) }}" 
                        class="btn-qr"
                    >
                        Lihat QR
                    </a>

                </td>

                <td>

                    <div class="aksi-group">

                        {{-- tombol edit --}}
                        <a 
                            href="{{ route('admin.meja.edit',$meja->id) }}" 
                            class="btn-edit"
                        >
                            Edit
                        </a>

                        {{-- tombol hapus --}}
                        <form 
                            action="{{ route('admin.meja.destroy',$meja->id) }}" 
                            method="POST"
                            onsubmit="return confirm('Yakin ingin hapus meja ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button 
                                type="submit" 
                                class="btn-delete"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="4" class="table-empty">
                    Data meja kosong
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
@extends('admin.layout')

@section('title','Edit Meja')

@section('content')

<div class="card">

    <h2>Edit Meja</h2>

    <form action="{{ route('admin.meja.update',$meja->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">

            <label>Nomor Meja</label>

            <input 
                type="text"
                name="nomor_meja"
                value="{{ old('nomor_meja',$meja->nomor_meja) }}"
                required
            >

        </div>

        <div class="form-group">
    <label for="status">Status</label>

    <div class="custom-select">
        <select name="status" id="status" required>
            <option 
                value="aktif"
                {{ $meja->status == 'aktif' ? 'selected' : '' }}
            >
                Aktif
            </option>

            <option 
                value="non aktif"
                {{ $meja->status == 'non aktif' ? 'selected' : '' }}
            >
                Non Aktif
            </option>
        </select>
    </div>
</div>

        <button type="submit" class="btn-theme">
            Update Meja
        </button>

    </form>

</div>

@endsection

@extends('admin.layout')

@section('title','Edit Kasir')

@section('content')

<div class="card">

    @if ($errors->any())
        <div style="color:red; font-weight:900; margin-bottom:15px;">
            @foreach ($errors->all() as $error)
                <div>- {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.kasir.update',$kasir->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name', $kasir->name) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email', $kasir->email) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>Password</label><br>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
        </div>
        <div style="margin-bottom:15px;">
            <label>Shift</label><br>
            <input type="input" name="shift" id="shift" value="{{ old('shift', $kasir->shift) }}" required readonly>
</div>
        <div style="margin-bottom:15px;">
            <label>Waktu Mulai Shift</label><br>
            <input type="time" name="waktu_shift" id="waktu_shift" value="{{ old('waktu_shift', $kasir->waktu_shift) }}"  lang="en-GB" required>
        </div>
        <div style="margin-bottom:15px;">
            <label>Waktu Selesai Shift</label><br>
            <input type="time" name="waktu_selesai_shift" id="waktu_selesai_shift" value="{{ old('waktu_selesai_shift', $kasir->waktu_selesai_shift) }}"  lang="en-GB"required>
        </div>

        <button type="submit">Simpan</button>
    </form>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("#waktu_shift", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
flatpickr("#waktu_selesai_shift", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

document.getElementById('waktu_shift')
.addEventListener('change', function(){

    const value = this.value;

    if(!value) return;

    /*
        format sekarang:
        13:00
    */

    const jam = parseInt(value.split(':')[0]);

    const shift = document.getElementById('shift');

    if(jam >= 12){

        shift.value = 'malam';

    }else{

        shift.value = 'pagi';

    }

});

</script>

@endsection
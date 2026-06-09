@extends('admin.layout')

@section('title','Data Transaksi')

@section('content')

{{-- FILTER --}}
<div class="card filter-card">

    <form method="GET" action="{{ route('admin.transaksi.index') }}">

        <div class="filter-wrapper">

            {{-- SEARCH --}}
            <div class="filter-item">
                <label>Cari Transaksi</label>

                <input 
                    type="text"
                    name="search"
                    placeholder="Cari kode transaksi..."
                    value="{{ request('search') }}"
                >
            </div>

            {{-- BULAN --}}
            <div class="filter-item">
                <label>Filter Bulan</label>

                <div class="custom-select">
                    <select name="bulan">

                        <option value="">Semua Bulan</option>

                        @for ($i = 1; $i <= 12; $i++)

                            <option 
                                value="{{ $i }}"
                                {{ request('bulan') == $i ? 'selected' : '' }}
                            >
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>

                        @endfor

                    </select>
                </div>
            </div>

            {{-- TAHUN --}}
            <div class="filter-item">
                <label>Filter Tahun</label>

                <div class="custom-select">
                    <select name="tahun">

                        <option value="">Semua Tahun</option>

                        @for ($tahun = now()->year; $tahun >= 2023; $tahun--)

                            <option 
                                value="{{ $tahun }}"
                                {{ request('tahun') == $tahun ? 'selected' : '' }}
                            >
                                {{ $tahun }}
                            </option>

                        @endfor

                    </select>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="filter-action">

                <button type="submit" class="btn-filter">
                    🔍 Filter
                </button>

                <a 
                    href="{{ route('admin.transaksi.index') }}"
                    class="btn-reset"
                >
                    ↺ Reset
                </a>

            </div>

        </div>

    </form>

</div>


{{-- TABLE --}}
<div class="card">

    <table>

        <thead>
            <tr>
                <th>Kode</th>
                <th>Meja</th>
                <th>Total Bayar</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($transaksis as $transaksi)

            <tr>

                <td>
                    #{{ $transaksi->id }}
                </td>

                <td>
                    {{ $transaksi->pesanan->nomor_meja ?? '-' }}
                </td>

                <td>
                    Rp {{ number_format($transaksi->total_bayar,0,',','.') }}
                </td>

                <td>
                    {{ $transaksi->pesanan->metode_pembayaran ?? '-' }}
                </td>

                <td>

                    @php
                        $status = $transaksi->pesanan->status ?? 'selesai';
                    @endphp

                    <span class="
                        status-badge
                        {{ $status == 'dibayar' ? 'status-success' : '' }}
                        {{ $status == 'pending_payment' ? 'status-warning' : '' }}
                        {{ $status == 'menunggu' ? 'status-pending' : '' }}
                    ">
                        {{ ucfirst($status) }}
                    </span>

                </td>

                <td>
                    {{ $transaksi->created_at->format('d-m-Y H:i') }}
                </td>

                <td>

                    <div class="aksi-group">

                        {{-- DETAIL --}}
                        <a 
                            href="{{ route('admin.transaksi.show',$transaksi->id) }}"
                            class="btn-edit"
                        >
                            📄 Detail
                        </a>

                        {{-- DELETE --}}
                        <form 
                            action="{{ route('admin.transaksi.destroy',$transaksi->id) }}" 
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-delete">
                                🗑 Hapus
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="table-empty">
                    Belum ada transaksi
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>


{{-- PAGINATION --}}
@if ($transaksis->hasPages())

<div class="pagination-wrap">

    {{-- PREV --}}
    @if ($transaksis->onFirstPage())

        <span class="pg-btn disabled">←</span>

    @else

        <a 
            href="{{ $transaksis->appends(request()->query())->previousPageUrl() }}"
            class="pg-btn"
        >
            ←
        </a>

    @endif


    {{-- NUMBER --}}
    <div class="pg-numbers">

        @foreach ($transaksis->getUrlRange(1, $transaksis->lastPage()) as $page => $url)

            @if ($page == $transaksis->currentPage())

                <span class="pg-btn active">
                    {{ $page }}
                </span>

            @else

                <a 
                    href="{{ $url }}&{{ http_build_query(request()->except('page')) }}"
                    class="pg-btn"
                >
                    {{ $page }}
                </a>

            @endif

        @endforeach

    </div>


    {{-- NEXT --}}
    @if ($transaksis->hasMorePages())

        <a 
            href="{{ $transaksis->appends(request()->query())->nextPageUrl() }}"
            class="pg-btn"
        >
            →
        </a>

    @else

        <span class="pg-btn disabled">→</span>

    @endif

</div>

@endif

@endsection
@extends('admin.layout')

@section('title', 'Laporan Penjualan & Statistik')

<!-- Push CSS Styles ke Head -->
@push('styles')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* =========================================
           1. NEO-BRUTALISM VARIABLES (KONSISTEN)
           ========================================= */
           a{
            text-decoration : none;
            color:--var(--neo-black);
           }
        :root {
            --neo-black: #000000;
            --neo-white: #ffffff;
            --neo-border: 3px solid var(--neo-black);
            --neo-shadow: 6px 6px 0px var(--neo-black); /* Shadow lebih tegas */
            --neo-shadow-hover: 4px 4px 0px var(--neo-black);
            --neo-radius: 0px; /* Brutalism Murni: Tajam Siku-siku */
            
            /* Palette */
            --neo-bg-body: #f4f4f0; /* Sedikit cream agar tidak putih bersih */
            --neo-yellow: #fff000;
            --neo-pink: #ff90e8;
            --neo-blue: #23a6d5;
            --neo-green: #00e676;
        }

        /* 2. GLOBAL RESET */
        body { 
            font-family: 'Space Mono', monospace; 
            background-color: var(--neo-bg-body);
            color: var(--neo-black);
            font-weight: 400;
        }

        h1, h2, h3, h4, h5, h6 { text-transform: uppercase; font-weight: 700; }

        /* 3. BUTTONS (Seragam) */
        .btn-neo {
            background: var(--neo-white);
            border: var(--neo-border);
            color: var(--neo-black);
            padding: 10px 20px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: var(--neo-radius); /* Tajam */
            box-shadow: var(--neo-shadow);
            transition: all 0.1s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-neo:hover {
            transform: translate(-3px, -3px);
            box-shadow: 9px 9px 0px var(--neo-black);
            background-color: var(--neo-yellow);
            color: var(--neo-black);
        }

        .btn-neo:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px var(--neo-black);
        }

        /* 4. CARDS */
        .card {
            border: var(--neo-border);
            border-radius: var(--neo-radius); /* Konsisten tajam */
            background: var(--neo-white);
            box-shadow: var(--neo-shadow);
        }

        .card-header {
            background: var(--neo-white);
            border-bottom: var(--neo-border);
            padding: 1.25rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .card-body { padding: 1.5rem; }

        /* 5. STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .card-stat {
            transition: all 0.2s ease;
            position: relative;
            z-index: 1;
        }

        .card-stat:hover {
            transform: translate(-5px, -5px);
            box-shadow: 11px 11px 0px var(--neo-black);
            z-index: 2;
        }

        .stat-icon-box {
            width: 50px;
            height: 50px;
            border: var(--neo-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: var(--neo-white);
            box-shadow: 3px 3px 0px var(--neo-black);
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-top: 5px;
        }

        /* Backgrounds */
        .bg-neo-yellow { background-color: var(--neo-yellow); }
        .bg-neo-pink { background-color: var(--neo-pink); }
        .bg-neo-blue { background-color: var(--neo-blue); }
        .bg-neo-green { background-color: var(--neo-green); }

        /* 6. TABLE (PERBAIKAN UTAMA) */
        /* Gunakan collapse agar border tidak dobel */
        .table {
            width: 100%;
            border-collapse: collapse; /* Penting! */
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--neo-black);
            color: var(--neo-white);
            text-transform: uppercase;
            font-weight: 700;
            border: 2px solid var(--neo-black); /* Border tipis di dalam header */
            padding: 15px;
        }

        .table tbody tr {
            border-bottom: 3px solid var(--neo-black); /* Garis pemisah baris yang tegas */
            transition: background 0.2s;
        }
        
        /* Hilangkan border bawah pada baris terakhir */
        .table tbody tr:last-child { border-bottom: none; }

        .table tbody tr:hover {
            background-color: var(--neo-yellow);
        }

        .table td {
            padding: 15px;
            border: none; /* Hilangkan border vertikal yang mengganggu */
            vertical-align: middle;
        }
        
        /* Khusus kolom pertama & terakhir bisa ditambahkan style jika perlu */
        .table td:first-child { font-weight: 700; }

        /* Badge */
        .badge-neo {
            display: inline-block;
            padding: 5px 12px;
            border: 2px solid var(--neo-black);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            box-shadow: 2px 2px 0px var(--neo-black);
        }

        /* 7. CHART CONTAINER */
        .chart-container {
            width: 100%;
            min-height: 350px;
            border: var(--neo-border); /* Border solid, bukan dashed */
            background: #fff;
            padding: 15px;
        }

        /* 8. DATATABLES OVERRIDE (Agar matching brutal) */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            font-family: 'Space Mono', monospace;
            margin-top: 20px;
        }
        
        .dataTables_wrapper select, 
        .dataTables_wrapper input[type="search"] {
            border: 3px solid var(--neo-black) !important;
            border-radius: 0 !important;
            font-family: 'Space Mono', monospace !important;
            box-shadow: 3px 3px 0px var(--neo-black) !important;
            padding: 8px 15px !important;
            font-weight: 700 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 3px solid var(--neo-black) !important;
            background: var(--neo-white) !important;
            color: var(--neo-black) !important;
            border-radius: 0 !important; /* Tajam */
            font-weight: 700 !important;
            margin: 0 5px !important;
            box-shadow: 3px 3px 0px var(--neo-black) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--neo-yellow) !important;
            color: var(--neo-black) !important;
            border-color: var(--neo-black) !important;
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0px var(--neo-black) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--neo-black) !important;
            color: var(--neo-white) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            box-shadow: none !important;
        }
        
        /* Avatar Brutal */
        .avatar-brutal {
            width: 35px;
            height: 35px;
            background: var(--neo-black);
            color: var(--neo-white);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid var(--neo-black);
            margin-right: 10px;
        }

        /* Responsive Grid */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .stat-value { font-size: 1.5rem; }
        }
    </style>
@endpush

@section('content')

@section('content')

<div class="container-fluid py-5">
    
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 fw-bold mb-0" style="font-size: 2rem;">DASHBOARD</h2>
            <p class="mb-0 fw-bold text-muted" style="letter-spacing: 1px;">:: LAPORAN PENJUALAN ::</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button class="btn btn-neo btn-sm">
                <i class="fas fa-file-pdf me-2" style="margin-right:6px;"></i> PDF
            </button>
            <button class="btn btn-neo btn-sm" >
                <i class="fas fa-file-excel me-2" style="margin-right:6px;"></i> EXCEL
            </button>
        </div>
    </div>

    <!-- 1. KARTU STATISTIK -->
    <div class="stats-grid">
        <!-- Pendapatan -->
        <div class="card card-stat bg-neo-yellow">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="stat-label">Total Pendapatan</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-wallet" style="margin-right:6px;"></i>
                    </div>
                </div>
                <h3 class="stat-value mt-auto">Rp {{ number_format((float) $totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="card card-stat bg-neo-blue">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="stat-label">Total Transaksi</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
                    </div>
                </div>
                <h3 class="stat-value mt-auto">{{ $totalTransaksi }}</h3>
            </div>
        </div>

        <!-- Pesanan -->
        <div class="card card-stat bg-neo-pink">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="stat-label">Total Pesanan</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-clipboard-list" style="margin-right:6px;"></i>
                    </div>
                </div>
                <h3 class="stat-value mt-auto">{{ $totalPesanan }}</h3>
            </div>
        </div>

        <!-- Produk -->
        <div class="card card-stat bg-neo-green">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="stat-label">Total Produk</span>
                    <div class="stat-icon-box">
                        <i class="fas fa-box" style="margin-right:6px;"></i>
                    </div>
                </div>
                <h3 class="stat-value mt-auto">{{ $totalProduk }}</h3>
            </div>
        </div>
    </div>

    <!-- Sisa kode (Grafik & Tabel) tetap sama seperti aslinya... -->
    <!-- ... -->

    <!-- 2. GRAFIK INTERAKTIF (BRUTAL CHARTS) -->
    <div class="row g-4 mb-5">
        <!-- Grafik Penjualan Harian (Area) -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-area me-2" style="margin-right:6px;"></i>TREN PENJUALAN (7 HARI)
                </div>
                <div class="card-body">
                    <div id="chartHarian" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Grafik Top Produk (Donut) -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2" style="margin-right:6px;"></i>TOP 5 PRODUK
                </div>
                <div class="card-body">
                    <div id="chartTopProduk" class="chart-container"></div>
                </div>
            </div>
        </div>
        
        <!-- Grafik Penjualan Bulanan (Bar) -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-2" style="margin-right:6px;"></i>ANALISIS BULANAN ({{ date('Y') }})
                </div>
                <div class="card-body">
                    <div id="chartBulanan" class="chart-container" style="min-height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABEL TRANSAKSI TERBARU (BRUTAL TABLE) -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history me-2" style="margin-right:6px;"></i>RIWAYAT TRANSAKSI</span>
            <button class="btn-neo btn-sm">LIHAT SEMUA</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="dataTableTransaksi" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID TRANSAKSI</th>
                            <th>TANGGAL</th>
                            <th>KASIR</th> 
                            <th>STATUS</th>
                            <th class="text-end">TOTAL (Rp)</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $item)
                        <tr>
                            <td><span class="fw-bold">#{{ $item->id }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-brutal">
                                        {{ substr(optional($item->cashier)->name ?? 'G', 0, 1) }}
                                    </div>
                                    <span class="fw-bold">{{ $item->cashier->role ?? 'Guest' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($item->status == 'lunas' || $item->status == 'success')
                                    <span class="badge-neo bg-neo-green">LUNAS</span>
                                @else
                                    <span class="badge-neo bg-neo-yellow">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold">
                                {{ number_format((float) $item->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <button class="btn-neo btn-sm" style="padding: 5px 10px;" title="Lihat Detail">
                                    <i class="fas fa-eye" style="margin-right:6px;"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                                <div class="fw-bold">DATA KOSONG</div>
                                <small>Belum ada transaksi tercatat.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection 

@section('script')
<!-- 1. Load Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>   
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // --- SISTEM PENCEGAHAN ERROR ---
        const dataHarian = @json($penjualanHarian ?? []); 
        const dataBulananRaw = @json($penjualanBulanan ?? []);
        const dataTopProduk = @json($topProduk ?? []);

        // --- 1. INISIALISASI DATATABLES ---
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('#dataTableTransaksi').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
                    emptyTable: "DATA TIDAK DITEMUKAN"
                },
                order: [[1, 'desc']],
                pageLength: 5,
                lengthMenu: [5, 10, 25],
                // DOM custom untuk memindahkan kontrol agar lebih rapi
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                columnDefs: [
                    { className: "dt-center", targets: [5] }, 
                    { className: "dt-right", targets: [4] }   
                ]
            });
        }

        const formatRupiah = (value) => {
            return "Rp " + value.toLocaleString('id-ID');
        };

        // --- 2. GRAFIK PENJUALAN HARIAN (AREA CHART BRUTAL) ---
        if (document.querySelector("#chartHarian")) {
            const tanggalHarian = dataHarian.map(item => item.tanggal);
           const totalHarian = dataHarian.map(item => parseInt(item.total) || 0);

            if (dataHarian.length > 0) {
                var optionsHarian = {
                    series: [{
                        name: 'Pendapatan',
                        data: totalHarian
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: { show: false },
                        fontFamily: 'Space Mono, monospace',
                        background: 'transparent'
                    },
                    colors: ['#000000'], // Garis Hitam Pekat
                    dataLabels: { enabled: false },
                    stroke: { 
                        curve: 'straight', // Garis lurus tegas, bukan smooth
                        width: 3 
                    },
                    fill: {
                        type: 'solid',
                        opacity: 0.1,
                        colors: ['#000000'] // Area hitam transparan
                    },
                    xaxis: {
                        categories: tanggalHarian,
                        axisBorder: { show: true, color: '#000', height: 2 },
                        axisTicks: { show: true, color: '#000' },
                        labels: {
                            style: { colors: '#000', fontWeight: 'bold' }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: { colors: '#000', fontWeight: 'bold' },
                            formatter: function (value) { return (value / 1000) + 'k'; }
                        }
                    },
                    tooltip: {
                        y: { formatter: function (value) { return formatRupiah(value); } }
                    }, 
                    grid: { 
                        borderColor: '#000',
                        strokeDashArray: 0 // Garis grid solid
                    },
                    markers: {
                        size: 6,
                        colors: ['#fff'],
                        strokeColors: '#000',
                        strokeWidth: 2
                    }
                };
                new ApexCharts(document.querySelector("#chartHarian"), optionsHarian).render();
            } else {
                document.querySelector("#chartHarian").innerHTML = '<div class="text-center py-5 fw-bold">DATA KOSONG</div>';
            }
        }

        // --- 3. GRAFIK PENJUALAN BULANAN (BAR CHART BRUTAL) ---
        if (document.querySelector("#chartBulanan")) {
            const namaBulan = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES"];
            let seriesBulanan = Array(12).fill(0);

            if (dataBulananRaw && Array.isArray(dataBulananRaw)) {
                dataBulananRaw.forEach(item => {
                    if(item && item.bulan >= 1 && item.bulan <= 12) {
                        seriesBulanan[item.bulan - 1] = parseInt(item.total) || 0;
                    }
                });
            }

            var optionsBulanan = {
                series: [{
                    name: 'Omset',
                    data: seriesBulanan
                }],
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: { show: false },
                    fontFamily: 'Space Mono, monospace',
                    background: 'transparent'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 0, // Sudut siku-siku
                        columnWidth: '60%',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: { enabled: false },
                colors: ['#23a6d5'], // Warna Biru Neo
                xaxis: {
                    categories: namaBulan,
                    labels: { 
                        style: { colors: '#000', fontWeight: 'bold' } 
                    },
                    axisBorder: { show: true, color: '#000', height: 2 },
                    axisTicks: { show: true, color: '#000' }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#000', fontWeight: 'bold' },
                        formatter: function (value) {
                            return value >= 1000000 ? (value / 1000000).toFixed(1) + 'jt' : (value/1000).toFixed(0) + 'k';
                        }
                    }
                },
                tooltip: {
                    y: { formatter: function (value) { return formatRupiah(value); } }
                },
                grid: { 
                    borderColor: '#000',
                    strokeDashArray: 4
                }
            };
            new ApexCharts(document.querySelector("#chartBulanan"), optionsBulanan).render();
        }

        // --- 4. GRAFIK TOP PRODUK (DONUT CHART BRUTAL) ---
        if (document.querySelector("#chartTopProduk")) {
            const labelsProduk = dataTopProduk.map(item => item.nama);
            const dataProduk = dataTopProduk.map(item => parseInt(item.total) || 0);

            if (dataTopProduk.length > 0) {
                var optionsTopProduk = {
                    series: dataProduk,
                    chart: {
                        type: 'donut',
                        height: 350,
                        fontFamily: 'Space Mono, monospace',
                        background: 'transparent'
                    },
                    labels: labelsProduk,
                    // Palette warna kontras
                    colors: ['#ff90e8', '#fff000', '#23a6d5', '#00e676', '#7b2cbf'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'TOTAL',
                                        color: '#000',
                                        fontFamily: 'Space Mono, monospace',
                                        fontWeight: 700,
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: { enabled: false },
                    stroke: { show: true, colors: ['#000'], width: 3 }, // Border hitam di antara pie
                    legend: { 
                        position: 'bottom', 
                        fontSize: '12px',
                        fontFamily: 'Space Mono, monospace',
                        fontWeight: 'bold',
                        markers: { shape: 'square' }
                    },
                    tooltip: { 
                        y: { 
                            formatter: function (value) { return value + " ITEM"; } 
                        } 
                    }
                };
                new ApexCharts(document.querySelector("#chartTopProduk"), optionsTopProduk).render();
            } else {
                document.querySelector("#chartTopProduk").innerHTML = '<div class="text-center py-5 fw-bold">DATA KOSONG</div>';
            }
        }

    });
</script>
@endsection

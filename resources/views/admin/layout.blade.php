<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') - Coffee Makmur</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* WRAPPER */
.pagination-wrap{
  display:flex;
  align-items:center;
  justify-content:center;
  gap:12px;
  margin-top:25px;
}

/* GROUP ANGKA */
.pg-numbers{
  display:flex;
  gap:10px;
}

/* BUTTON BASE */
.pg-btn{
  min-width:42px;
  text-align:center;
  padding:10px 14px;
  background:var(--light);
  border:3px solid var(--dark);
  font-weight:900;
  text-decoration:none;
  color:var(--dark);
  box-shadow:var(--shadow);
  transition:all 0.15s ease;
}

/* HOVER */
.pg-btn:hover{
  transform:translate(-3px,-3px);
  box-shadow:9px 9px 0 var(--dark);
  background:var(--secondary);
}

/* ACTIVE PAGE */
.pg-btn.active{
  background:var(--primary);
  color:var(--light);
  transform:translate(-2px,-2px);
  box-shadow:6px 6px 0 var(--dark);
}

/* DISABLED */
.pg-btn.disabled{
  opacity:0.4;
  pointer-events:none;
  background:#ddd;
}
:root{
  --bg:#fefefe;
  --primary:#7ca36a;
  --secondary:#f4d35e;
  --accent:#ee6c4d;
  --dark:#111;
  --light:#fff;
  --shadow:6px 6px 0 var(--dark);
}

*{box-sizing:border-box;font-family:Arial, Helvetica, sans-serif;}
body{margin:0;background:var(--bg);}
.app{display:flex;height:100vh;}

.sidebar{
  width:240px;
  background:var(--secondary);
  border-right:4px solid var(--dark);
  padding:26px 20px;
}

.sidebar h2{margin:0 0 28px;font-weight:900;}

.menu a{
  display:block;
  padding:14px;
  margin-bottom:14px;
  background:var(--light);
  border:3px solid var(--dark);
  box-shadow:var(--shadow);
  text-decoration:none;
  color:var(--dark);
  font-weight:900;
}

.menu a.active{
  background:var(--primary);
  color:white;
}

.main{
  flex:1;
  padding:26px;
  overflow:auto;
}

.card{
  background:var(--light);
  border:3px solid var(--dark);
  box-shadow:var(--shadow);
  padding:20px;
  margin-bottom:20px;
}

button{
  background:var(--primary);
  color:white;
  border:3px solid var(--dark);
  padding:8px 14px;
  font-weight:900;
  cursor:pointer;
  box-shadow:var(--shadow);
}

table{
  width:100%;
  border-collapse:collapse;
}

table th, table td{
  border:3px solid var(--dark);
  padding:10px;
  text-align:left;
}

table th{
  background:var(--secondary);
}
input, textarea {
    width:100%;
    padding:8px;
    border:3px solid var(--dark);
    box-shadow: var(--shadow);
}

.card div:hover {
    transform: translate(-3px,-3px);
    box-shadow:6px 6px 0px #000;
    transition:0.2s;
}
/* Semua tombol (termasuk <button>) */
button, .btn-theme {
  display: inline-block;
  background: var(--primary);
  color: var(--light);
  border: 3px solid var(--dark);
  padding: 10px 18px;
  font-weight: 900;
  text-decoration: none;
  cursor: pointer;
  box-shadow: var(--shadow);
  transition: all 0.15s ease;
  letter-spacing: 0.5px;
}

/* Hover (efek khas brutalism: geser + shadow makin jauh) */
button:hover, .btn-theme:hover {
  transform: translate(-3px, -3px);
  box-shadow: 9px 9px 0 var(--dark);
}

/* Active (efek ditekan) */
button:active, .btn-theme:active {
  transform: translate(3px, 3px);
  box-shadow: 0px 0px 0 var(--dark);
}

/* group tombol aksi */
.aksi-group{
    display:flex;
    align-items:center;
    gap:12px;
}

/* tombol edit */
.btn-edit{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:75px;
    height:38px;

    padding:0 16px;

    background:#c08b5c;
    color:white;

    border:none;
    border-radius:8px;

    text-decoration:none;

    font-size:13px;
    font-weight:600;

    font-family:'Poppins',sans-serif;

    cursor:pointer;

    transition:0.25s ease;

    box-shadow:4px 4px 0px #000;
}

.btn-edit:hover{
    background:#a56f43;
    transform:translateY(-2px);
}

/* tombol hapus */
.btn-delete{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:75px;
    height:38px;

    padding:0 16px;

    background:#6ea061;
    color:white;

    border:none;
    border-radius:8px;

    font-size:13px;
    font-weight:600;

    font-family:'Poppins',sans-serif;

    cursor:pointer;

    transition:0.25s ease;

    box-shadow:4px 4px 0px #000;
}

.btn-delete:hover{
    background:#4f7d45;
    transform:translateY(-2px);
}

.btn-qr {
  display: inline-block;
  background: var(--light);
  color: var(--primary);
  padding: 8px 14px;
  font-size: 13px;
  font-weight: 900;
  border: 3px solid var(--primary);
  text-decoration: none;
  box-shadow: var(--shadow);
  transition: all 0.15s ease;
}

/* Hover → jadi kuning */
.btn-qr:hover {
  background: var(--secondary);
  color: var(--dark);
  border-color: var(--dark);
  transform: translate(-3px, -3px);
  box-shadow: 9px 9px 0 var(--dark);
}

/* Klik → jadi merah (biar terasa aksi) */
.btn-qr:active {
  background: var(--accent);
  color: var(--light);
  border-color: var(--dark);
  transform: translate(3px, 3px);
  box-shadow: 0px 0px 0 var(--dark);
}

/* status */
.status-aktif{
    color:green;
    font-weight:bold;
}

.status-nonaktif{
    color:red;
    font-weight:bold;
}

/* data kosong */
.table-empty{
    text-align:center;
    padding:20px;
}
.form-group {
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    font-size: 15px;
    font-weight: 600;
    color: #333;
}

.custom-select {
    position: relative;
    width: 100%;
}

/* SELECT */
.custom-select select {
    width: 100%;
    padding: 12px 50px 12px 14px;

    font-size: 15px;
    font-weight: 500;

    border: 2px solid #111;
    border-radius: 12px;

    background: #fff;
    color: #111;

    cursor: pointer;
    outline: none;

    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    transition: 0.2s ease;

    /* supaya option gampang diklik */
    line-height: 1.5;

    /* neobrutalism */
    box-shadow: 4px 4px 0px #111;
}

/* HOVER */
.custom-select select:hover {
    transform: translate(-1px, -1px);
    box-shadow: 6px 6px 0px #111;
}

/* FOCUS */
.custom-select select:focus {
    border-color: #22c55e;
    box-shadow: 6px 6px 0px #111;
}

/* OPTION */
.custom-select select option {
    background: #fff;
    color: #111;
    padding: 10px;
}

/* ICON ARROW */
.custom-select::after {
    content: "▼";

    position: absolute;

    top: 50%;
    right: 16px;

    transform: translateY(-50%);

    font-size: 14px;
    font-weight: bold;

    color: #111;

    pointer-events: none;
}
/* =========================
   AKSI BUTTON NEOBRUTALISM
========================= */

.aksi-group{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

/* BASE */
.btn-edit,
.btn-delete{

    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:10px 16px;
    min-width:95px;

    border:3px solid #111;
    border-radius:12px;

    font-size:13px;
    font-weight:900;

    text-decoration:none;

    cursor:pointer;

    transition:all 0.15s ease;

    box-shadow:5px 5px 0px #111;

    letter-spacing:0.5px;

    position:relative;
}

/* DETAIL */
.btn-edit{
    background:#f4d35e;
    color:#111;
}

/* DETAIL HOVER */
.btn-edit:hover{
    transform:translate(-3px,-3px);
    box-shadow:8px 8px 0px #111;
    background:#ffd43b;
}

/* DETAIL ACTIVE */
.btn-edit:active{
    transform:translate(3px,3px);
    box-shadow:0px 0px 0px #111;
}

/* DELETE */
.btn-delete{
    background:#ff4d6d;
    color:#fff;
}

/* DELETE HOVER */
.btn-delete:hover{
    transform:translate(-3px,-3px);
    box-shadow:8px 8px 0px #111;
    background:#e63956;
}

/* DELETE ACTIVE */
.btn-delete:active{
    transform:translate(3px,3px);
    box-shadow:0px 0px 0px #111;
}
/* =========================
   FILTER TRANSAKSI
========================= */

.filter-card{
    margin-bottom:25px;
}

.filter-wrapper{
    display:flex;
    align-items:end;
    gap:18px;
    flex-wrap:wrap;
}

.filter-item{
    flex:1;
    min-width:220px;
}

.filter-item label{
    display:block;
    margin-bottom:10px;
    font-size:14px;
    font-weight:900;
    color:#111;
}

.filter-item input{
    height:52px;
    border-radius:12px;
    background:#fff;
}

/* ACTION */
.filter-action{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

/* FILTER BUTTON */
.btn-filter{

    display:inline-flex;
    align-items:center;
    justify-content:center;

    height:52px;

    padding:0 22px;

    background:#7ca36a;
    color:#fff;

    border:3px solid #111;
    border-radius:12px;

    font-weight:900;
    text-decoration:none;

    cursor:pointer;

    box-shadow:5px 5px 0 #111;

    transition:all .15s ease;
}

.btn-filter:hover{
    transform:translate(-3px,-3px);
    box-shadow:8px 8px 0 #111;
}

/* RESET BUTTON */
.btn-reset{

    display:inline-flex;
    align-items:center;
    justify-content:center;

    height:52px;

    padding:0 22px;

    background:#f4d35e;
    color:#111;

    border:3px solid #111;
    border-radius:12px;

    font-weight:900;
    text-decoration:none;

    box-shadow:5px 5px 0 #111;

    transition:all .15s ease;
}

.btn-reset:hover{
    transform:translate(-3px,-3px);
    box-shadow:8px 8px 0 #111;
}

/* STATUS BADGE */
.status-badge{
    display:inline-block;
    padding:8px 14px;
    border:3px solid #111;
    border-radius:10px;
    font-weight:900;
    font-size:12px;
    box-shadow:4px 4px 0 #111;
}

/* MENUNGGU */
.status-pending{
    background:#ffe066;
    color:#111;
}

/* PENDING PAYMENT */
.status-warning{
    background:#74c0fc;
    color:#111;
}

/* DIBAYAR */
.status-success{
    background:#8ce99a;
    color:#111;
}

/* RESPONSIVE */
@media(max-width:768px){

    .filter-wrapper{
        flex-direction:column;
        align-items:stretch;
    }

    .filter-action{
        width:100%;
    }

    .btn-filter,
    .btn-reset{
        width:100%;
    }

}
</style>
</head>
@stack('styles')
<body>
<div class="app">

<aside class="sidebar">
  <h2>☕ COFFEE MAKMUR</h2>
  <nav class="menu">
    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
       Dashboard
    </a>

    <a href="{{ route('admin.produk.index') }}"
       class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
       Produk
    </a>

    <a href="{{ route('admin.meja.index') }}"
       class="{{ request()->routeIs('admin.meja.*') ? 'active' : '' }}">
       Meja
    </a>

    <a href="{{ route('admin.transaksi.index') }}"
       class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
       Transaksi
    </a>
    <a href="{{ route('admin.kategori.index') }}"
       class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
       Kategori
    </a>

    <a href="{{ route('admin.kasir.index') }}"
       class="{{ request()->routeIs('admin.kasir.*') ? 'active' : '' }}">
       Kasir
    </a>
    <a href="{{ route('admin.laporan') }}"
       class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
       Laporan
</a>
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="{{ request()->routeIs('logout') ? 'active' : '' }}">Logout</button>
      </form>
   
  </nav>
</aside>

<main class="main">
    <h2>@yield('title')</h2>
    @yield('content')
</main>

</div>

@yield('script')

</body>
</html>
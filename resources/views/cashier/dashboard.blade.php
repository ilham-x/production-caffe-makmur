<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kasir Modern</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700;900&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* =========================
   ROOT VARIABLES
========================= */
:root{
  --bg-color:#f8f9fa;

  --primary:#00e676;
  --primary-dark:#00b248;

  --secondary:#ffb300;
  --secondary-dark:#c68400;

  --accent:#ff4081;
  --accent-dark:#c60055;

  --danger:#ef4444;
  --danger-dark:#dc2626;

  --dark:#212529;
  --light:#ffffff;

  --border-width:3px;
  --shadow:5px 5px 0px var(--dark);
  --shadow-hover:8px 8px 0px var(--dark);
  --radius:14px;
}

/* =========================
   RESET & BASE
========================= */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Roboto Mono', monospace;
}

body{
  background:var(--bg-color);
  background-image:radial-gradient(var(--dark) 1.5px, transparent 1.5px);
  background-size:24px 24px;
  color:var(--dark);
  min-height:100vh;
  padding-bottom:40px;
}

/* =========================
   LAYOUT UTILITIES
========================= */
.container{
  max-width:1400px;
  margin:auto;
  padding:20px;
}

/* =========================
   HEADER
========================= */
.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:20px;

  margin-bottom:30px;
  padding:24px;

  background:var(--light);

  border:var(--border-width) solid var(--dark);
  border-radius:20px;

  box-shadow:var(--shadow);
}

.header-left h1{
  font-size:28px;
  font-weight:900;
  text-transform:uppercase;
  letter-spacing: -1px;
}

.header-left p {
  font-size: 14px;
  margin-top: 4px;
  opacity: 0.8;
}

.header-right{
  display:flex;
  gap:15px;
  align-items:center;
  flex-wrap: wrap;
}

/* =========================
   BUTTON GLOBAL
========================= */
button{
  width:100%;
  border:var(--border-width) solid var(--dark);
  background:var(--primary);
  color:var(--dark);

  padding:12px;

  font-size:14px;
  font-weight:900;

  cursor:pointer;

  border-radius:12px;

  box-shadow:4px 4px 0px var(--dark);

  transition:0.15s ease;

  text-transform:uppercase;
}

button:hover{
  transform:translate(-2px,-2px);
  box-shadow:7px 7px 0px var(--dark);
}

button:active{
  transform:translate(2px,2px);
  box-shadow:1px 1px 0px var(--dark);
}

/* =========================
   HEADER BUTTON
========================= */
.header-btn{
  position:relative;

  width:auto;
  padding:12px 22px;

  display:flex;
  align-items:center;
  gap:10px;

  background:var(--light);

  border:var(--border-width) solid var(--dark);
  border-radius:14px;

  font-weight:900;

  box-shadow:var(--shadow);

  transition:0.2s;
}

.header-btn:hover{
  background:var(--primary);
}

.logout-btn{
  background:var(--dark);
  color:var(--light);
}

.logout-btn:hover{
  background:var(--accent);
}

/* =========================
   BADGE
========================= */
.notification-badge{
  position:absolute;
  top:-10px;
  right:-10px;

  min-width:24px;
  height:24px;

  display:flex;
  align-items:center;
  justify-content:center;

  padding:4px;

  background:var(--accent);
  color:var(--light);

  border:2px solid var(--dark);
  border-radius:50%;

  font-size:11px;
  font-weight:900;

  box-shadow:3px 3px 0px var(--dark);

  transform:scale(0);

  transition:0.3s;
}

.notification-badge.show{
  transform:scale(1);
}

/* =========================
   MAIN GRID
========================= */
.grid{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:24px;
}

.menu-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); /* Sedikit diperlebar */
  gap:24px;
}

/* =========================
   CARD STYLE UMUM
========================= */
.card{
  background:var(--light);

  border:var(--border-width) solid var(--dark);
  border-radius:var(--radius);

  padding:20px; /* Padding lebih lega */

  box-shadow:var(--shadow);

  transition:0.2s ease;
}

/* =========================
   MEJA CARD (REVAMPED)
========================= */
.meja-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
}

.meja-card {
  cursor: pointer;
  
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  
  padding: 24px 16px;
  
  border: var(--border-width) solid var(--dark);
  border-radius: 16px;
  
  text-align: center;
  
  /* Background diatur via inline style di HTML untuk logika PHP, 
     tapi transition tetap ada */
  transition: all 0.2s ease;
  box-shadow: 4px 4px 0px var(--dark);
  position: relative;
  overflow: hidden;
}

.meja-card:hover {
  transform: translateY(-4px);
  box-shadow: 6px 6px 0px var(--dark);
  z-index: 2;
}

.meja-icon {
  font-size: 40px;
  margin-bottom: 12px;
  filter: drop-shadow(2px 2px 0px rgba(0,0,0,0.2));
}

.meja-number {
  font-size: 18px;
  font-weight: 900;
  margin-bottom: 8px;
  text-shadow: 2px 2px 0px rgba(255,255,255,0.4);
}

.status-meja {
  display: inline-block;
  padding: 4px 12px;
  background: rgba(255,255,255,0.9);
  border: 2px solid var(--dark);
  border-radius: 20px;
  font-size: 12px;
  font-weight: 800;
  box-shadow: 2px 2px 0px rgba(0,0,0,0.2);
}

/* =========================
   PRODUCT CARD (REVAMPED)
========================= */
.product-card{
  display:flex;
  flex-direction:column;
  height: 100%; /* Ensure equal height */
}

/* Wrapper Gambar agar rapi */
.product-image-wrapper {
  width: 100%;
  height: 160px; /* Tinggi tetap */
  
  border: 2px solid var(--dark);
  border-radius: 12px;
  
  margin-bottom: 16px;
  
  overflow: hidden;
  background-color: #eee;
  position: relative;
  
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image-wrapper img {
  transform: scale(1.05);
}

.no-image {
  font-size: 12px;
  font-weight: 900;
  color: #999;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.product-info {
  flex-grow: 1; /* Mendorong tombol ke bawah */
  display: flex;
  flex-direction: column;
  text-align: center;
  margin-bottom: 16px;
}

.product-card h4{
  font-size:16px;
  font-weight: 700;
  
  display: -webkit-box;
  -webkit-line-clamp: 2; /* Maksimal 2 baris */
  -webkit-box-orient: vertical;
  overflow: hidden;
  
  margin-bottom: 12px;
  line-height: 1.3;
  min-height: 42px; /* Align heights */
}

.product-price{
  display:inline-block;
  margin-top: auto; /* Push to bottom of info section */
  
  padding:6px 14px;
  
  background:var(--secondary);
  border:2px solid var(--dark);
  border-radius:8px;
  
  font-size:14px;
  font-weight:900;
  box-shadow: 3px 3px 0px var(--dark);
}

/* =========================
   CART SIDEBAR
========================= */
.cart{
  position:sticky;
  top:20px;

  max-height:85vh;
  overflow-y:auto;

  padding:20px;

  background:var(--light);

  border:var(--border-width) solid var(--dark);
  border-radius:var(--radius);

  box-shadow:var(--shadow);
}

/* =========================
   INPUT
========================= */
input{
  width:100%;

  padding:12px;

  margin-top:8px;

  border:var(--border-width) solid var(--dark);
  border-radius:10px;

  font-weight:700;
}

input:focus{
  outline:none;
  background:#fff8d6;
}

/* =========================
   TOAST
========================= */
#toast-container{
  position:fixed;
  top:20px;
  right:20px;

  z-index:9999;

  display:flex;
  flex-direction:column;
  gap:16px;
}

.toast{
  width:360px;

  overflow:hidden;

  background:rgba(255,255,255,.95);

  border:3px solid var(--dark);
  border-radius:18px;

  box-shadow:8px 8px 0px rgba(0,0,0,.15);

  animation:slideIn .35s ease;
}

.toast-header{
  display:flex;
  justify-content:space-between;
  align-items:center;

  padding:14px 18px;

  border-bottom:2px solid #eee;

  font-weight:900;
}

.toast-body{
  padding:18px;

  line-height:1.5;
  font-size:14px;
}

.toast-close{
  background:none;
  border:none;
  box-shadow:none;

  width:auto;

  padding:0;

  font-size:18px;

  cursor:pointer;
}

.toast-footer{
  padding:14px 18px;

  border-top:2px solid #eee;
}

.toast-footer button{
  width:auto;
  padding:10px 18px;
}

@keyframes slideIn{
  from{
    opacity:0;
    transform:translateX(50px);
  }
  to{
    opacity:1;
    transform:translateX(0);
  }
}

/* =========================
   ORDERS PANEL
========================= */
.orders-panel{
  position:fixed;
  top:0;
  right:-100%;

  width:1000px;
  max-width:100%;
  height:100vh;

  overflow-y:auto;

  padding:30px;

  background:var(--bg-color);

  border-left:4px solid var(--dark);

  transition:0.3s ease;

  z-index:5000;
}

.orders-panel.active{
  right:0;
}

.orders-header{
  position:sticky;
  top:0;

  z-index:10;

  display:flex;
  justify-content:space-between;
  align-items:center;

  padding-bottom:20px;
  margin-bottom:25px;

  background:var(--bg-color);
  border-bottom: 3px solid var(--dark);
}

.orders-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:24px;
}

.order-card{
  display:flex;
  flex-direction:column;
  gap:14px;
}

.order-top{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.status-badge{
  display:inline-block;

  padding:6px 12px;

  border:2px solid var(--dark);
  border-radius:8px;

  font-size:11px;
  font-weight:900;

  box-shadow:3px 3px 0px var(--dark);
}

.order-info{
  display:flex;
  flex-direction:column;
  gap:10px;
}

.order-info-item{
  padding:10px 14px;

  background:#fff;

  border:2px solid var(--dark);
  border-radius:10px;

  font-weight:700;
}

.order-detail{
  max-height:150px;
  overflow:auto;

  padding:14px;

  background:#fff;

  border:2px solid var(--dark);
  border-radius:12px;
}

.order-item{
  display:flex;
  justify-content:space-between;

  padding-bottom:8px;
  margin-bottom:10px;

  border-bottom:2px dashed #ccc;

  font-size:13px;
}

.order-item:last-child{
  margin-bottom:0;
  border:none;
}

.order-total{
  display:flex;
  justify-content:space-between;

  padding:14px;

  background:var(--secondary);

  border:2px solid var(--dark);
  border-radius:12px;

  font-size:18px;
  font-weight:900;
}

.order-actions{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px;
}

/* =========================
   MOBILE
========================= */
@media(max-width:900px){

  .grid{
    grid-template-columns:1fr;
  }

  .orders-grid{
    grid-template-columns:1fr;
  }

  .header{
    flex-direction:column;
    align-items:flex-start;
  }

  .header-right{
    width:100%;
    justify-content:space-between;
  }

  .cart{
    position:relative;
    top:0;
  }

  .toast{
    width:92vw;
  }
}

</style>
</head>

<body>

<!-- AUDIO -->
<audio
    id="sound-notif"
    preload="auto"
>
    <source 
        src="{{ asset('sound.mp3') }}" 
        type="audio/mpeg"
    >
</audio>

<!-- TOAST -->
<div id="toast-container"></div>

<div class="container">

<!-- HEADER -->
<div class="header">

  <div class="header-left">
    <h1>🚀 Kasir App</h1>
    <p>{{auth()->user()->name}}</p>
    <p>Shift: {{auth()->user()->shift ?? 'NonStop'}}</p>
    <p>{{auth()->user()->waktu_shift}} - {{auth()->user()->waktu_selesai_shift}}</p>
  </div>

  <div class="header-right">
    <button
      class="header-btn"
      onclick="toggleKomplain()"
    >
      🚨 Komplain

      @if(count($komplains) > 0)
      <span class="notification-badge show">
        {{ count($komplains) }}
      </span>
      @endif
    </button>
    
    <button 
      class="header-btn"
      id="btnOrders"
      onclick="toggleOrders()"
    >
      📋 Pesanan
      <span class="notification-badge" id="notifBadge">0</span>
    </button>

    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <button 
        type="submit"
        class="header-btn logout-btn"
      >
        Logout
      </button>

    </form>

  </div>

</div>

<!-- GRID -->
<div class="grid">
  
  <!-- LEFT COLUMN (MENU & MEJA) -->
  <div class="main-content">

    <!-- MEJA SECTION (REVAMPED) -->
    <div class="card" style="margin-bottom:24px; padding: 24px;">
      <h2 style="margin-bottom:20px; font-size: 20px;">
        🪑 Status Meja
      </h2>

      <div class="meja-container">
        @foreach($meja as $m)

        <div
          class="meja-card"
          onclick="toggleMeja({{ $m->id }}, this)"
          style="
            background:
            {{ $m->status == 'aktif'
                ? '#ff4081'  /* Accent - Occupied */
                : '#00e676'  /* Primary - Empty */
            }};
            color: #000;
          "
        >
          <div class="meja-icon">🪑</div>
          
          <div class="meja-number">
            Meja {{ $m->nomor_meja }}
          </div>

          <div class="status-meja">
            {{ $m->status == 'aktif' ? 'Digunakan' : 'Kosong' }}
          </div>

        </div>

        @endforeach
      </div>

    </div>

    <!-- MENU SECTION (REVAMPED) -->
    <div class="menu-grid">

      @foreach($anjlok as $menu)

      <div class="card product-card">

        <div class="product-image-wrapper">
          @if($menu->gambar)
            <img 
              src="{{ asset('storage/'.$menu->gambar) }}" 
              alt="{{ $menu->nama_produk }}"
            >
          @else
            <div class="no-image">NO IMAGE</div>
          @endif
        </div>

        <div class="product-info">
          <h4>{{ $menu->nama_produk }}</h4>
          <div class="product-price">
            Rp {{ number_format($menu->harga,0,',','.') }}
          </div>
        </div>

        <form action="{{ route('customer.cart') }}" method="POST" style="margin-top: auto;">
          @csrf

          <input type="hidden" name="produk_id" value="{{ $menu->id }}">
          <input type="hidden" name="nama" value="{{ $menu->nama_produk }}">
          <input type="hidden" name="harga" value="{{ $menu->harga }}">

          <button type="submit">
            + Tambah
          </button>

        </form>

      </div>
      @endforeach

    </div>
  </div>

  <!-- RIGHT COLUMN (CART) -->
  <div class="cart">
    @include('cashier.cart_partial')
  </div>

</div>

</div>

<!-- ORDERS PANEL -->
<div class="orders-panel" id="ordersPanel">
  
  <!-- KOMPLAIN PANEL (Nested inside orders panel logic in original, keeping structure) -->
  <div class="orders-panel" id="komplainPanel">

    <div class="orders-header">
      <h2>🚨 Daftar Komplain</h2>
      <button
        type="button"
        style="width:auto; background:var(--accent); color:#fff; padding:12px 18px;"
        onclick="toggleKomplain()"
      >
        ✕
      </button>
    </div>

    <div class="orders-grid">
      @foreach($komplains as $k)
      <div class="card order-card">
        <div class="order-top">
          <b>Komplain #{{ $k->id }}</b>
          <span
            class="status-badge"
            style="
              background:
              {{ 
              $k->status == 'pending' ? '#ffb300' :
              ($k->status == 'diterima' ? '#00e676' :
              ($k->status == 'refund' ? '#3b82f6' : '#ef4444'))
              }};
            "
          >
            {{ $k->status }}
          </span>
        </div>

        <div class="order-info">
          <div class="order-info-item">🧾 Pesanan: {{ $k->pesanan->kode_pesanan }}</div>
          <div class="order-info-item">🍔 Produk: {{ $k->produk->nama_produk }}</div>
          <div class="order-info-item">🪑 Meja: {{ $k->pesanan->nomor_meja }}</div>
        </div>

        <div class="order-detail">
          <b>Alasan:</b>
          <p style="margin-top:10px;">{{ $k->alasan }}</p>
          @if($k->foto)
            <img src="{{ asset('storage/'.$k->foto) }}" style="width:100%; margin-top:10px; border-radius:12px; border:2px solid #000;">
          @endif
        </div>

        @if($k->status == 'pending')
        <div class="order-actions">
          <form method="POST" action="{{ route('cashier.komplain.approve',$k->id) }}">
            @csrf
            <button style="background:#00e676;">Approve</button>
          </form>
          <form method="POST" action="{{ route('cashier.komplain.reject',$k->id) }}">
            @csrf
            <button style="background:#ef4444; color:#fff;">Reject</button>
          </form>
        </div>
        @endif

      </div>
      @endforeach
    </div>
  </div>
  <!-- END KOMPLAIN PANEL -->

  <!-- STANDARD ORDERS PANEL -->
  <div class="orders-header">
    <h2>📋 Daftar Pesanan</h2>
    <button 
      type="button"
      style="width:auto; background:var(--accent); color:#fff; padding:12px 18px;"
      onclick="toggleOrders()"
    >
      ✕
    </button>
  </div>

  <div class="orders-grid">
    @foreach($pesanans as $psn)
    <div class="card order-card">

      <div class="order-top">
        <b>#{{ $psn->kode_pesanan }}</b>
        <span 
          class="status-badge"
          style="
            background:
            {{ 
            $psn->status == 'menunggu' ? '#ced4da' :
            ($psn->status == 'pending_payment' ? '#ffb300' :
            ($psn->status == 'dibayar' ? '#00e676' : '#ff4081'))
            }};
          "
        >
          {{ $psn->status }}
        </span>
      </div>

      <div class="order-info">
        <div class="order-info-item">🪑 Meja: {{ $psn->nomor_meja }}</div>
        <div class="order-info-item">👤 {{ $psn->nama_pelanggan }}</div>
        <div class="order-info-item">📅 {{ \Carbon\Carbon::parse($psn->created_at)->translatedFormat('d F Y') }}</div>
        <div class="order-info-item">⏰ {{ \Carbon\Carbon::parse($psn->created_at)->format('H:i') }}</div>
      </div>

      <div class="order-detail">
        @foreach($psn->detail as $d)
        <div class="order-item">
          <span>{{ $d->produk->nama_produk }} <small>x{{ $d->qty }}</small></span>
          <span>Rp {{ number_format($d->subtotal,0,',','.') }}</span>
        </div>
        @endforeach
      </div>

      <div class="order-total">
        <span>TOTAL</span>
        <span>Rp {{ number_format($psn->total_harga,0,',','.') }}</span>
      </div>

      <div class="order-actions">
        @if($psn->status == 'menunggu')
        <form method="POST" action="{{ route('cashier.updateStatus',$psn->id) }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="pending_payment">
          <button type="submit">Kirim</button>
        </form>

        @elseif($psn->status == 'pending_payment')
          @if($psn->metode_pembayaran == 'cash')
          <form method="POST" action="{{ route('cashier.bayar',$psn->id) }}">
            @csrf
            <input type="number" name="bayar" placeholder="Jumlah Bayar" required>
            <button type="submit">Bayar</button>
          </form>
          @else
          <form method="POST" action="{{ route('cashier.bayar',$psn->id) }}">
            @csrf
            <button type="submit">Konfirmasi</button>
          </form>
          @endif

        @elseif($psn->status == 'dibayar')
        <form method="POST" action="{{ route('cashier.updateStatus',$psn->id) }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="selesai">
          <button type="submit">Selesai</button>
        </form>
        <a href="{{ route('struk',$psn->id) }}" target="_blank">
          <button type="button" style="background:var(--accent); color:#fff;">Cetak</button>
        </a>

        @else
        <div style="
          padding:14px; background:var(--primary); border:3px solid var(--dark); 
          border-radius:12px; text-align:center; font-weight:900; box-shadow:4px 4px 0px var(--dark);">
          ✔️ Selesai
        </div>
        @endif
      </div>

    </div>
    @endforeach
  </div>
</div>

<script>

/* =========================
   STATE
========================= */
let unreadCount = 0;

/* =========================
   ELEMENT HELPER
========================= */
function safeGetElement(id){
  return document.getElementById(id);
}

/* =========================
   TOGGLE PANEL
========================= */
function toggleOrders(){
  const panel = safeGetElement('ordersPanel');
  const badge = safeGetElement('notifBadge');
  panel.classList.toggle('active');

  if(panel.classList.contains('active')){
    unreadCount = 0;
    updateBadge(0);
  }
}

/* =========================
   UPDATE BADGE
========================= */
function updateBadge(count){
  const badge = safeGetElement('notifBadge');
  badge.innerText = count > 9 ? '9+' : count;
  if(count > 0){
    badge.classList.add('show');
  }else{
    badge.classList.remove('show');
  }
}

/* =========================
   PLAY SOUND (FIXED DUPLICATE)
========================= */
function playNotificationSound(){
  const audio = safeGetElement('sound-notif');
  if(audio){
    audio.currentTime = 0;
    audio.play().catch(error => {
      console.log('Audio blocked:', error);
    });
  }
}

/* =========================
   TOAST (FIXED DUPLICATE)
========================= */
function showNotification(title, message, actionText = null, callback = null){
  const container = safeGetElement('toast-container');
  const toast = document.createElement('div');
  
  toast.className = 'toast';
  toast.innerHTML = `
    <div class="toast-header">
      <span>${title}</span>
      <button class="toast-close">✕</button>
    </div>
    <div class="toast-body">${message}</div>
    ${ actionText ? `<div class="toast-footer"><button class="toast-action-btn">${actionText}</button></div>` : '' }
  `;

  container.appendChild(toast);
  playNotificationSound();

  // Close Button
  const closeBtn = toast.querySelector('.toast-close');
  closeBtn.addEventListener('click', () => toast.remove());

  // Action Button
  const actionBtn = toast.querySelector('.toast-action-btn');
  if(actionBtn && callback){
    actionBtn.addEventListener('click', () => {
      callback();
      toast.remove();
    });
  }

  // Auto remove
  setTimeout(() => {
    if(toast.parentElement){
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(40px)';
      setTimeout(() => toast.remove(), 300);
    }
  }, 7000);
}

/* =========================
   CHECK PESANAN BARU
========================= */
let lastOrderCount = {{ count($pesanans) }};

function checkNewOrders(){
  fetch("{{ route('cashier.check.orders') }}")
    .then(res => res.json())
    .then(data => {
      if(data.count > lastOrderCount){
        let jumlahBaru = data.count - lastOrderCount;
        lastOrderCount = data.count;
        
        playNotificationSound();
        
        unreadCount += jumlahBaru;
        updateBadge(unreadCount);
        
        showNotification('🔔 Pesanan Baru', `${jumlahBaru} pesanan baru masuk`);
      }
    })
    .catch(err => console.log(err));
}

// Polling 3 detik
setInterval(checkNewOrders, 3000);

/* =========================
   DELETE CART
========================= */
function deleteCart(id){
  fetch("{{ route('cashier.cart.delete') }}", {
    method:"POST",
    headers:{
      "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content,
      "Content-Type":"application/json",
      "Accept":"application/json"
    },
    body:JSON.stringify({ produk_id:id })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) location.reload();
  })
  .catch(err => console.log(err));
}

/* =========================
   TOGGLE MEJA (LOGIC INTACT)
========================= */
function toggleMeja(id, element){
  fetch(`/meja/toggle/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      const statusText = element.querySelector('.status-meja');
      
      // Visual Update sesuai class CSS baru
      if(data.status == 'aktif'){
        element.style.background = '#ff4081'; // Pink
        statusText.innerText = 'Digunakan';
      } else {
        element.style.background = '#00e676'; // Green
        statusText.innerText = 'Kosong';
      }
    }
  })
  .catch(err => console.log(err));
}

/* =========================
   TOGGLE KOMPLAIN
========================= */
function toggleKomplain(){
  const panel = document.getElementById('komplainPanel');
  panel.classList.toggle('active');
}

</script>
</body>
</html>
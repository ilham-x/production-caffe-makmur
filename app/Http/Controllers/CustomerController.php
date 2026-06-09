<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Meja;
use App\Models\Detail_Pesanan;
use App\Models\Komplain;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class CustomerController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, $meja)
    {
        $query = Produk::where('is_available', true);

        // SEARCH
        if ($request->q) {
            $query->where('nama_produk', 'like', '%' . $request->q . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $menus = $query->get();

        // BEST SELLER (7 hari terakhir)
        $bestSellerIds = Detail_Pesanan::where('created_at', '>=', Carbon::now()->subDays(7))
            ->select('produk_id')
            ->selectRaw('SUM(qty) as total_qty')
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->pluck('produk_id');

        $bestSellers = Produk::whereIn('id', $bestSellerIds)->get();

        $kategoris = Kategori::all();

        // PESANAN TERAKHIR DI MEJA INI
        $pesanan = Pesanan::with('detail.produk')
            ->where('nomor_meja', $meja)
            ->latest()
            ->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'menus'       => $menus,
                'best_sellers' => $bestSellers,
                'kategoris'   => $kategoris,
                'nomor_meja'  => $meja,
                'pesanan'     => $pesanan,
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    | cart dihandle di frontend (localStorage)
    | method ini tetap ada kalau butuh validasi produk dari backend
    |--------------------------------------------------------------------------
    */

    public function addToCart(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        if (!$produk->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak tersedia'
            ], 422);
        }

        // kembaliin data produk buat disimpen di localStorage frontend
        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke cart',
            'data'    => [
                'produk_id' => $produk->id,
                'nama'      => $produk->nama_produk,
                'harga'     => $produk->harga,
                'qty'       => 1
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    | dihandle di frontend, method ini bisa dihapus
    |--------------------------------------------------------------------------
    */

    public function updateCart(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Update cart dihandle di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE CART (POST)
    |--------------------------------------------------------------------------
    */

    public function removeCartPost(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Remove cart dihandle di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE CART (GET)
    |--------------------------------------------------------------------------
    */

    public function removeCart($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Remove cart dihandle di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    | cart dikirim dari frontend sebagai array JSON
    |--------------------------------------------------------------------------
    */

    public function checkout(Request $request)
    {
        $cart = $request->input('cart');

        if (!$cart || count($cart) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 422);
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += ((int) $item['harga']) * ((int) $item['qty']);
        }

        // CREATE PESANAN
        $pesanan = Pesanan::create([
            'kode_pesanan'      => 'PSN-' . strtoupper(Str::random(6)),
            'nama_pelanggan'    => $request->nama_pelanggan,
            'nomor_meja'        => $request->nomor_meja,
            'total_harga'       => $total,
            'status'            => 'pending_payment',
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // UPDATE STATUS MEJA
        $meja = Meja::where('nomor_meja', $request->nomor_meja)->first();

        if ($meja) {
            $meja->update(['status' => 'aktif']);
        }

        // DETAIL PESANAN
        foreach ($cart as $item) {
            Detail_Pesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id'  => $item['produk_id'],
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
                'subtotal'   => ((int) $item['harga']) * ((int) $item['qty'])
            ]);
        }

        $metode = $request->metode_pembayaran;

        /*
        |--------------------------------------------------------------------------
        | CASH
        |--------------------------------------------------------------------------
        */

        if ($metode == 'cash') {

            Transaksi::create([
                'pesanan_id'  => $pesanan->id,
                'total_bayar' => $pesanan->total_harga,
                'status'      => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat, silakan bayar ke kasir',
                'data'    => $pesanan->load('detail.produk')
            ], 201);
        }

        /*
        |--------------------------------------------------------------------------
        | ONLINE (XENDIT)
        |--------------------------------------------------------------------------
        */

        Configuration::setXenditKey(config('services.xendit.secret_key'));

        $apiInstance = new InvoiceApi();

        $createInvoiceRequest = new CreateInvoiceRequest([
            'external_id'          => $pesanan->kode_pesanan,
            'description'          => 'Pembayaran ' . $pesanan->kode_pesanan,
            'amount'               => $pesanan->total_harga,
            'success_redirect_url' => url('/payment-success?meja=' . $request->nomor_meja),
            'failure_redirect_url' => url('/payment-failed')
        ]);

        $invoice = $apiInstance->createInvoice($createInvoiceRequest);

        Transaksi::create([
            'pesanan_id'  => $pesanan->id,
            'invoice_id'  => $invoice['id'],
            'external_id' => $pesanan->kode_pesanan,
            'total_bayar' => $pesanan->total_harga,
            'status'      => 'pending'
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Invoice berhasil dibuat',
            'invoice_url' => $invoice['invoice_url'],
            'data'        => $pesanan->load('detail.produk')
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | KOMPLAIN
    |--------------------------------------------------------------------------
    */

    public function komplain(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required',
            'produk_id'  => 'required',
            'alasan'     => 'required'
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('komplain', 'public');
        }

        $komplain = Komplain::create([
            'pesanan_id' => $request->pesanan_id,
            'produk_id'  => $request->produk_id,
            'alasan'     => $request->alasan,
            'foto'       => $foto,
            'status'     => 'pending'
        ]);

        Pesanan::find($request->pesanan_id)->update([
            'status' => 'complain'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komplain berhasil dikirim',
            'data'    => $komplain
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | CALLBACK XENDIT
    | dd() dihapus, urutan validasi token dibenerin ke atas
    |--------------------------------------------------------------------------
    */

    public function callback(Request $request)
    {
        // VALIDASI TOKEN DULU
        $callbackToken = $request->header('x-callback-token');

        if ($callbackToken !== config('services.xendit.callback_token')) {
            return response()->json([
                'message' => 'Invalid callback token'
            ], 403);
        }

        $externalId = $request->external_id;
        $status     = $request->status;

        $transaksi = Transaksi::where('external_id', $externalId)->first();

        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        if ($status == 'PAID') {

            $transaksi->update(['status' => 'paid']);

            $transaksi->pesanan->update(['status' => 'selesai']);

        } elseif (in_array($status, ['EXPIRED', 'FAILED'])) {

            $transaksi->update(['status' => 'failed']);

            $transaksi->pesanan->update(['status' => 'cancel']);
        }

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT SUCCESS
    |--------------------------------------------------------------------------
    */

    public function success(Request $request)
    {
        $meja    = $request->meja;
        $pesanan = Pesanan::where('nomor_meja', $meja)->latest()->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        $pesanan->update(['status' => 'selesai']);

        Transaksi::where('pesanan_id', $pesanan->id)->update(['status' => 'paid']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'data'    => $pesanan->load('detail.produk')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT FAILED
    |--------------------------------------------------------------------------
    */

    public function failed(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Pembayaran gagal atau dibatalkan',
            'meja'    => $request->meja
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use App\Models\Komplain;
use App\Models\Transaksi;

use Illuminate\Support\Str;
use Carbon\Carbon;

// XENDIT
use Xendit\Configuration;
use Xendit\Refund\RefundApi;

class CashierController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        $waktuShift = !empty($user->waktu_shift)
            ? $user->waktu_shift
            : '00:00:00';

        $waktuSelesaiShift = !empty($user->waktu_selesai_shift)
            ? $user->waktu_selesai_shift
            : '23:59:59';

        $produk = Produk::all();

        $meja = Meja::all();

        $pesanans = Pesanan::with('detail.produk')
            ->whereDate('created_at', Carbon::today())
            ->whereTime('created_at', '>=', $waktuShift)
            ->whereTime('created_at', '<=', $waktuSelesaiShift)
            ->orderBy('created_at', 'desc')
            ->get();

        $komplains = Komplain::with(['pesanan', 'produk'])
            ->whereHas('pesanan', function ($query) use ($waktuShift, $waktuSelesaiShift) {
                $query->whereDate('created_at', Carbon::today())
                    ->whereTime('created_at', '>=', $waktuShift)
                    ->whereTime('created_at', '<=', $waktuSelesaiShift);
            })
            ->latest()
            ->get();

        $transaksis = Transaksi::whereDate('created_at', Carbon::today())
            ->whereTime('created_at', '>=', $waktuShift)
            ->whereTime('created_at', '<=', $waktuSelesaiShift)
            ->latest()
            ->get();

        return response()->json([
            'success'    => true,
            'data'       => [
                'produk'     => $produk,
                'meja'       => $meja,
                'pesanans'   => $pesanans,
                'komplains'  => $komplains,
                'transaksis' => $transaksis,
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE MEJA
    |--------------------------------------------------------------------------
    */

    public function toggleMeja($id)
    {
        $meja = Meja::findOrFail($id);

        $meja->status = $meja->status == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $meja->save();

        return response()->json([
            'success' => true,
            'status'  => $meja->status
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    | cart sekarang dari frontend (localStorage), 
    | method ini opsional / bisa dihapus
    |--------------------------------------------------------------------------
    */

    public function addToCart(Request $request)
    {
        // cart dihandle di frontend (localStorage)
        // kalau mau tetap server-side, bisa pakai DB cart per user

        return response()->json([
            'success' => true,
            'message' => 'Gunakan localStorage di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    |--------------------------------------------------------------------------
    */

    public function updateCart(Request $request)
    {
        // cart dihandle di frontend (localStorage)

        return response()->json([
            'success' => true,
            'message' => 'Gunakan localStorage di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CART
    |--------------------------------------------------------------------------
    */

    public function deleteCart(Request $request)
    {
        // cart dihandle di frontend (localStorage)

        return response()->json([
            'success' => true,
            'message' => 'Gunakan localStorage di frontend'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS PESANAN
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = $request->status;

        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah',
            'data'    => $pesanan
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BAYAR
    |--------------------------------------------------------------------------
    */

    public function bayar(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->metode_pembayaran == 'cash') {

            $bayar     = (int) $request->bayar;
            $kembalian = $bayar - $pesanan->total_harga;

            if ($kembalian < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Uang kurang'
                ], 422);
            }

            $transaksi = Transaksi::where('pesanan_id', $pesanan->id)->first();

            if ($transaksi) {
                $transaksi->status = 'paid';
                $transaksi->save();
            }

            $pesanan->status = 'dibayar';
            $pesanan->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Pembayaran berhasil',
                'kembalian' => $kembalian,
                'data'      => $pesanan
            ]);
        }

        $pesanan->status = 'dibayar';
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'data'    => $pesanan
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STRUK
    | sekarang return data JSON, render HTML-nya di frontend
    |--------------------------------------------------------------------------
    */

    public function struk($id)
    {
        $pesanan = Pesanan::with('detail.produk')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $pesanan
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    | cart dikirim dari frontend sebagai array JSON di request body
    |--------------------------------------------------------------------------
    */

    public function checkout(Request $request)
    {
        $cart = $request->input('cart');

        if (!$cart || count($cart) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong'
            ], 422);
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += ((int) $item['harga']) * ((int) $item['qty']);
        }

        $pesanan = Pesanan::create([
            'kode_pesanan'      => 'PSN-' . strtoupper(Str::random(6)),
            'nama_pelanggan'    => $request->nama_pelanggan,
            'nomor_meja'        => $request->nomor_meja,
            'total_harga'       => $total,
            'refund_total'      => 0,
            'status'            => 'pending_payment',
            'metode_pembayaran' => $request->metode_pembayaran
        ]);

        foreach ($cart as $item) {
            Detail_Pesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id'  => $item['produk_id'],
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
                'subtotal'   => ((int) $item['harga']) * ((int) $item['qty'])
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'data'    => $pesanan->load('detail.produk')
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE KOMPLAIN
    |--------------------------------------------------------------------------
    */

    public function approveKomplain($id)
    {
        try {

            $komplain = Komplain::findOrFail($id);
            $pesanan  = Pesanan::findOrFail($komplain->pesanan_id);

            $detail = Detail_Pesanan::where('pesanan_id', $pesanan->id)
                ->where('produk_id', $komplain->produk_id)
                ->first();

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail pesanan tidak ditemukan'
                ], 404);
            }

            $refundAmount = (int) $detail->subtotal;

            $pesanan->refund_total = ((int) $pesanan->refund_total) + $refundAmount;
            $pesanan->status       = 'refund';
            $pesanan->save();

            $komplain->status = 'refund';
            $komplain->save();

            $transaksi = Transaksi::where('pesanan_id', $pesanan->id)->first();

            if ($pesanan->metode_pembayaran == 'online' && $transaksi) {

                Configuration::setXenditKey(
                    config('services.xendit.secret_key')
                );

                $refundApi = new RefundApi();

                $refundApi->createRefund([
                    'data' => [
                        'invoice_id' => $transaksi->invoice_id,
                        'amount'     => (float) $refundAmount,
                        'reason'     => 'Komplain customer'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Komplain berhasil direfund',
                'data'    => $komplain
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT KOMPLAIN
    |--------------------------------------------------------------------------
    */

    public function rejectKomplain($id)
    {
        $komplain = Komplain::findOrFail($id);

        $komplain->status = 'ditolak';

        $komplain->save();

        return response()->json([
            'success' => true,
            'message' => 'Komplain ditolak',
            'data'    => $komplain
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Xendit\Xendit;

class TransaksiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE INVOICE XENDIT
    |--------------------------------------------------------------------------
    */
    public function createInvoice()
    {
        Xendit::setApiKey(config('services.xendit.secret_key'));

        $params = [
            'external_id' => 'order-' . time(),
            'amount' => 20000,
            'description' => 'Pembayaran Cafe'
        ];

        $invoice = \Xendit\Invoice::create($params);

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil dibuat',
            'data' => $invoice
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | LIST TRANSAKSI + FILTER
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Transaksi::with([
            'pesanan.meja'
        ]);

        if ($request->filled('search')) {
            $query->where(
                'id',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('bulan')) {
            $query->whereMonth(
                'created_at',
                $request->bulan
            );
        }

        if ($request->filled('tahun')) {
            $query->whereYear(
                'created_at',
                $request->tahun
            );
        }

        $transaksis = $query
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transaksis
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load([
            'pesanan.produks',
            'pesanan.meja'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diambil',
            'data' => $transaksi
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $transaksi = Transaksi::with([
            'pesanan.produks'
        ])->findOrFail($id);

        if ($transaksi->pesanan) {

            if (method_exists(
                $transaksi->pesanan,
                'produks'
            )) {
                $transaksi->pesanan
                    ->produks()
                    ->detach();
            }

            $transaksi->pesanan->delete();
        }

        $transaksi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD UTAMA
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAPATAN
        |--------------------------------------------------------------------------
        | total_harga - refund_total
        */

        $totalPendapatan = Pesanan::selectRaw(
            '
            SUM(
                total_harga - COALESCE(refund_total,0)
            ) as total
            '
        )->value('total') ?? 0;

        $totalTransaksi = Transaksi::count();

        $totalPesanan = Pesanan::count();

        $totalProduk = Produk::count();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PENDAPATAN 7 HARI
        |--------------------------------------------------------------------------
        */

        $raw = Pesanan::selectRaw(
                '
                DATE(created_at) as tanggal,

                SUM(
                    total_harga - COALESCE(refund_total,0)
                ) as total
                '
            )

            ->where(
                'created_at',
                '>=',
                Carbon::now()->subDays(6)
            )

            ->groupBy('tanggal')

            ->orderBy('tanggal', 'ASC')

            ->get()

            ->keyBy('tanggal');

        $pendapatanPerHari = collect();

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::now()
                ->subDays($i)
                ->format('Y-m-d');

            $pendapatanPerHari->push([

                'tanggal' =>
                    Carbon::parse($tanggal)
                    ->format('d M'),

                'total' =>
                    (float) ($raw[$tanggal]->total ?? 0)
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUK TERLARIS
        |--------------------------------------------------------------------------
        */

        $produkTerlaris = Produk::withCount('pesanans')

            ->orderBy('pesanans_count', 'DESC')

            ->take(5)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | ULASAN TERBARU
        |--------------------------------------------------------------------------
        */

        $ulasanTerbaru = Ulasan::with('produk')

            ->latest()

            ->take(5)

            ->get();

        return response()->json([
        'totalPendapatan' => $totalPendapatan,
        'totalTransaksi' => $totalTransaksi,
        'totalPesanan' => $totalPesanan,
        'totalProduk' => $totalProduk,
        'pendapatanPerHari' => $pendapatanPerHari,
        'produkTerlaris' => $produkTerlaris,
        'ulasanTerbaru' => $ulasanTerbaru,
    ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN PENJUALAN
    |--------------------------------------------------------------------------
    */

    public function penjualan()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = Pesanan::selectRaw(
            '
            SUM(
                total_harga - COALESCE(refund_total,0)
            ) as total
            '
        )->value('total') ?? 0;

        $totalTransaksi = Transaksi::count();

        $totalPesanan = Pesanan::count();

        $totalProduk = Produk::count();

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */

        $penjualanHarian = $this->getPenjualanHarian();

        $penjualanBulanan = $this->getPenjualanBulanan();

        $topProduk = $this->getTopProduk();

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaksi::with([
                'cashier',
                'pesanan'
            ])

            ->latest()

            ->take(100)

            ->get();

        return response()->json([
    'totalPendapatan' => $totalPendapatan,
    'totalTransaksi' => $totalTransaksi,
    'totalPesanan' => $totalPesanan,
    'totalProduk' => $totalProduk,
    'penjualanHarian' => $penjualanHarian,
    'penjualanBulanan' => $penjualanBulanan,
    'topProduk' => $topProduk,
    'recentTransactions' => $recentTransactions,
]);
    }

    /*
    |--------------------------------------------------------------------------
    | TOP PRODUK
    |--------------------------------------------------------------------------
    */

    private function getTopProduk()
    {
        return DB::table('detail_pesanans')

            ->join(
                'produks',
                'detail_pesanans.produk_id',
                '=',
                'produks.id'
            )

            ->selectRaw(
                '
                produks.nama_produk as nama,
                SUM(detail_pesanans.qty) as total
                '
            )

            ->groupBy('produks.nama_produk')

            ->orderByDesc('total')

            ->limit(5)

            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | PENJUALAN HARIAN
    |--------------------------------------------------------------------------
    */

    private function getPenjualanHarian()
    {
        $raw = Pesanan::selectRaw(
                '
                DATE(created_at) as tanggal,

                SUM(
                    total_harga - COALESCE(refund_total,0)
                ) as total
                '
            )

            ->where(
                'created_at',
                '>=',
                Carbon::now()->subDays(6)
            )

            ->groupBy('tanggal')

            ->orderBy('tanggal', 'ASC')

            ->get()

            ->keyBy('tanggal');

        $data = collect();

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::now()
                ->subDays($i)
                ->format('Y-m-d');

            $data->push([

                'tanggal' =>
                    Carbon::parse($tanggal)
                    ->format('d M'),

                'total' =>
                    (float) ($raw[$tanggal]->total ?? 0)
            ]);
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | PENJUALAN BULANAN
    |--------------------------------------------------------------------------
    */

    private function getPenjualanBulanan()
    {
        return Pesanan::selectRaw(
                "
                strftime('%m', created_at) as bulan,

                SUM(
                    total_harga - COALESCE(refund_total,0)
                ) as total
                "
            )

            ->whereYear(
                'created_at',
                now()->year
            )

            ->groupBy('bulan')

            ->orderBy('bulan')

            ->get()

            ->map(function ($item) {

                return [

                    'bulan' =>
                        (int) $item->bulan,

                    'total' =>
                        (float) $item->total,
                ];
            });
    }
}
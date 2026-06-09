<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * List semua produk
     */
    public function index()
    {
        $produks = Produk::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $produks
        ]);
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')
                ->store('produk', 'public');
        }

        $produk = Produk::create([
            'nama_produk' => $validated['nama_produk'],
            'harga'       => $validated['harga'],
            'kategori'    => $validated['kategori'] ?? null,
            'gambar'      => $gambarPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $produk
        ], 201);
    }

    /**
     * Detail produk
     */
    public function show(Produk $produk)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail produk berhasil diambil',
            'data' => $produk
        ]);
    }

    /**
     * Update produk
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'nama_produk' => $validated['nama_produk'],
            'harga'       => $validated['harga'],
            'kategori'    => $validated['kategori'] ?? null,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('produk', 'public');
        }

        $produk->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui',
            'data' => $produk->fresh()
        ]);
    }

    /**
     * Hapus produk
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
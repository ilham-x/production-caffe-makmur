<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MejaController extends Controller
{
    /**
     * Tampilkan semua meja
     */
    public function index()
    {
        $mejas = Meja::latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data meja berhasil diambil',
            'data' => $mejas
        ]);
    }

    /**
     * Simpan meja baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja'
        ], [
            'nomor_meja.required' => 'Nomor meja wajib diisi',
            'nomor_meja.unique' => 'Nomor meja sudah digunakan'
        ]);

        $meja = Meja::create([
            'nomor_meja' => $validated['nomor_meja'],
            'kode_qr'     => Str::uuid(),
            'status'      => 'aktif'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil ditambahkan',
            'data' => $meja
        ], 201);
    }

    /**
     * Detail meja
     */
    public function show(Meja $meja)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail meja berhasil diambil',
            'data' => $meja
        ]);
    }

    /**
     * Update data meja
     */
    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja,' . $meja->id,
            'status' => 'required|in:aktif,non aktif'
        ], [
            'nomor_meja.required' => 'Nomor meja wajib diisi',
            'nomor_meja.unique' => 'Nomor meja sudah dipakai',
            'status.required' => 'Status wajib dipilih'
        ]);

        $meja->update([
            'nomor_meja' => $validated['nomor_meja'],
            'status'     => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil diperbarui',
            'data' => $meja->fresh()
        ]);
    }

    /**
     * Hapus meja
     */
    public function destroy(Meja $meja)
    {
        $meja->delete();

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil dihapus'
        ]);
    }
}
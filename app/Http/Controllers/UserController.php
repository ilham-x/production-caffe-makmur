<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/kasir?page=1
    public function index()
    {
        $kasirs = User::where('role', 'cashier')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($kasirs);
    }

    // POST /api/kasir
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'sometimes|in:cashier,admin',
        ]);

        $kasir = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'] ?? 'cashier',
        ]);

        return response()->json($kasir, 201);
    }

    // PUT /api/kasir/{id}
    public function update(Request $request, User $kasir)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $kasir->id,
            'password' => 'sometimes|nullable|min:6',
            'role'     => 'sometimes|in:cashier,admin',
        ]);

        $kasir->name  = $validated['name']  ?? $kasir->name;
        $kasir->email = $validated['email'] ?? $kasir->email;
        $kasir->role  = $validated['role']  ?? $kasir->role;

        // Password hanya diupdate kalau dikirim dan tidak kosong
        if (!empty($validated['password'])) {
            $kasir->password = Hash::make($validated['password']);
        }

        $kasir->save();

        return response()->json($kasir);
    }

    // DELETE /api/kasir/{id}
    public function destroy(User $kasir)
    {
        // Jangan hapus diri sendiri
        if (auth()->id() === $kasir->id) {
            return response()->json([
                'message' => 'Tidak bisa menghapus akun sendiri'
            ], 403);
        }

        $kasir->delete();

        return response()->json(['message' => 'Kasir berhasil dihapus']);
    }
}
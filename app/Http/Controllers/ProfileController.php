<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Ambil data profile user login
     */
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data profile berhasil diambil',
            'data' => $request->user()
        ]);
    }

    /**
     * Update profile user
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'data' => $user->fresh()
        ]);
    }

    /**
     * Hapus akun user
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}
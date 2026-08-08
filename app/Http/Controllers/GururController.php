<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GururController extends Controller
{
    /**
     * Display a listing of all guru accounts (super admin only).
     */
    public function index()
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $gurus = User::where('role', 'guru')
            ->withCount(['kelasDiampu as jumlah_kelas'])
            ->paginate(20);

        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Show the form for editing the specified guru.
     */
    public function edit(User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($user->role !== 'guru') {
            abort(404);
        }

        return view('admin.guru.edit', compact('user'));
    }

    /**
     * Update the specified guru in storage.
     */
    public function update(Request $request, User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($user->role !== 'guru') {
            abort(404);
        }

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'mata_pelajaran' => ['nullable', 'string', 'max:255'],
            'nis'            => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()->route('guru.kelola')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Show form to reset password for specified guru.
     */
    public function editPassword(User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($user->role !== 'guru') {
            abort(404);
        }

        return view('admin.guru.edit-password', compact('user'));
    }

    /**
     * Update password for specified guru.
     */
    public function updatePassword(Request $request, User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($user->role !== 'guru') {
            abort(404);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('guru.kelola')->with('success', 'Password guru berhasil diperbarui.');
    }
}

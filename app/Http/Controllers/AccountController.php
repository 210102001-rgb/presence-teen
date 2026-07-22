<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    /**
     * Display a listing of all accounts (super admin only).
     */
    public function index()
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users = User::paginate(20);

        return view('admin.account.index', compact('users'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function create()
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.account.create');
    }

    /**
     * Store a newly created account in storage.
     */
    public function store(Request $request)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:siswa,guru,orang_tua'],
            'nis' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('account.index')->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified account.
     */
    public function edit(User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.account.edit', compact('user'));
    }

    /**
     * Update the specified account in storage.
     */
    public function update(Request $request, User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:siswa,guru,orang_tua'],
            'nis' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Delete the specified account.
     */
    public function destroy(User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Prevent deleting the super admin account itself
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Tidak dapat menghapus akun super admin.');
        }

        $user->delete();

        return redirect()->route('account.index')->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Show form to reset password for specified user.
     */
    public function editPassword(User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.account.edit-password', compact('user'));
    }

    /**
     * Update password for specified user.
     */
    public function updatePassword(Request $request, User $user)
    {
        if (! Gate::allows('isAdmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $validated = $request->validate([
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('account.index')->with('success', 'Password berhasil diperbarui.');
    }
}

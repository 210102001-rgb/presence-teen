<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'siswa' => redirect()->route('dashboard.siswa'),
            'guru' => redirect()->route('dashboard.guru'),
            'orang_tua' => redirect()->route('dashboard.orang_tua'),
            default => abort(403),
        };
    }
}

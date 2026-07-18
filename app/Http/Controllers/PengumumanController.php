<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();

        return view('features.pengumuman', compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('features.pengumuman-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:Akademik,Administrasi,Kegiatan',
            'prioritas' => 'required|string|in:Penting,Sedang,Biasa',
            'konten' => 'required|string',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi',
            'judul.max' => 'Judul maksimal 255 karakter',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'prioritas.required' => 'Prioritas wajib dipilih',
            'prioritas.in' => 'Prioritas tidak valid',
            'konten.required' => 'Konten pengumuman wajib diisi',
        ]);

        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('features.pengumuman-edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:Akademik,Administrasi,Kegiatan',
            'prioritas' => 'required|string|in:Penting,Sedang,Biasa',
            'konten' => 'required|string',
        ]);

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}

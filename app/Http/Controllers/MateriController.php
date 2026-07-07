<?php
namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::where('siswa_id', auth()->id())->latest()->get();
        return view('materi.index', compact('materi'));
    }

    public function create()
    {
        return view('materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'materi_asli' => 'required|string',
        ]);

        $response = Http::withToken(config('services.anthropic.api_key'))
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-3-haiku-20240307',
                'max_tokens' => 1500,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Ringkas materi pembelajaran berikut menjadi poin-poin penting:\n\n" . $request->materi_asli
                    ]
                ]
            ]);

        $ringkasan = $response->json('content.0.text');

        $materi = Materi::create([
            'siswa_id' => auth()->id(),
            'judul' => $request->judul,
            'materi_asli' => $request->materi_asli,
            'ringkasan_ai' => $ringkasan ?? 'Gagal menghasilkan ringkasan.',
        ]);

        return redirect()->route('materi.show', $materi)->with('success', 'Materi berhasil disimpan.');
    }

    public function show(Materi $materi)
    {
        abort_if($materi->siswa_id !== auth()->id(), 403);
        return view('materi.show', compact('materi'));
    }
}

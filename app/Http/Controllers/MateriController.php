<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
use Smalot\PdfParser\Parser as PdfParser;

class MateriController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'guru') {
            $materi = Materi::with('guru')->where('guru_id', auth()->id())->latest()->get();
        } else {
            $materi = Materi::with('guru')->latest()->get();
        }

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
            'file' => 'required|file|max:10240|mimes:txt,pdf,docx',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materi_uploads', 'public');
        $materiAsli = $this->extractText($file);

        $materi = Materi::create([
            'guru_id' => auth()->id(),
            'judul' => $request->judul,
            'materi_asli' => $materiAsli,
            'file_path' => $filePath,
        ]);

        return redirect()->route('materi.show', $materi)->with('success', 'Materi berhasil diupload.');
    }

    public function show(Materi $materi)
    {
        return view('materi.show', compact('materi'));
    }

    public function ringkas(Materi $materi)
    {
        if (! $materi->materi_asli) {
            return back()->with('error', 'Tidak ada teks untuk diringkas.');
        }

        $response = Http::withOptions([
            'base_uri' => config('services.ai.base_url'),
            'verify' => false,
        ])
            ->withHeaders([
                'x-api-key' => config('services.ai.api_key'),
                'anthropic-version' => config('services.ai.version'),
            ])
            ->post('messages', [
                'model' => config('services.ai.model'),
                'max_tokens' => 1500,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Ringkas materi pembelajaran berikut menjadi poin-poin penting dalam bahasa Indonesia:\n\n".$materi->materi_asli,
                    ],
                ],
            ]);

        $ringkasan = $response->json('content.0.text');

        $materi->update(['ringkasan_ai' => $ringkasan ?? 'Gagal menghasilkan ringkasan.']);

        return redirect()->route('materi.show', $materi)->with('success', 'Ringkasan AI berhasil dibuat.');
    }

    /**
     * Download materi file.
     */
    public function download(Materi $materi)
    {
        if (! $materi->file_path || ! Storage::disk('public')->exists($materi->file_path)) {
            return back()->with('error', 'File materi tidak ditemukan.');
        }

        return Storage::disk('public')->download($materi->file_path, $materi->judul.'.'.pathinfo($materi->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Delete materi.
     */
    public function destroy(Materi $materi)
    {
        // Authorization check - hanya guru pembuat yang bisa hapus
        if ($materi->guru_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus materi ini.');
        }

        // Hapus file dari storage
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        // Hapus record dari database
        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }

    private function extractText($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        return match ($extension) {
            'txt' => file_get_contents($path),
            'pdf' => $this->extractPdfText($path),
            'docx' => $this->extractDocxText($path),
            default => '',
        };
    }

    private function extractPdfText(string $path): string
    {
        try {
            $parser = new PdfParser;
            $pdf = $parser->parseFile($path);

            return $pdf->getText();
        } catch (\Exception $e) {
            return '[Gagal mengekstrak teks dari PDF]';
        }
    }

    private function extractDocxText(string $path): string
    {
        try {
            $phpWord = PhpWordIOFactory::load($path);
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText()."\n";
                    } elseif (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $child) {
                            if (method_exists($child, 'getText')) {
                                $text .= $child->getText()."\n";
                            }
                        }
                    }
                }
            }

            return $text;
        } catch (\Exception $e) {
            return '[Gagal mengekstrak teks dari DOCX]';
        }
    }
}

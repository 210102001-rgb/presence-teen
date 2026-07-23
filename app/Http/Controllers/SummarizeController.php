<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use Smalot\PdfParser\Parser as PdfParser;

class SummarizeController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:txt,pdf,docx',
        ]);

        $file = $request->file('file');

        // Ekstrak teks dari file
        $text = $this->extractText($file);

        if (empty(trim($text))) {
            return back()->with('summarize_error', 'Teks dari file tidak dapat dibaca. Pastikan file tidak rusak dan berisi teks.');
        }

        // Kirim ke Claude AI
        try {
            $apiKey  = config('services.ai.api_key') ?: config('services.anthropic.api_key');
            $baseUrl = rtrim(config('services.ai.base_url', 'https://api.anthropic.com/v1/'), '/');
            $model   = config('services.ai.model', 'claude-3-5-sonnet-20241022');
            $version = config('services.ai.version', '2023-06-01');

            if (empty($apiKey)) {
                return back()->with('summarize_error', 'API Key AI belum dikonfigurasi. Hubungi administrator.');
            }

            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'x-api-key'         => $apiKey,
                    'anthropic-version' => $version,
                    'content-type'      => 'application/json',
                ])
                ->timeout(60)
                ->post($baseUrl . '/messages', [
                    'model'      => $model,
                    'max_tokens' => 2000,
                    'messages'   => [
                        [
                            'role'    => 'user',
                            'content' => "Kamu adalah asisten AI untuk siswa sekolah. Ringkas materi pembelajaran berikut menjadi ringkasan yang jelas, terstruktur, dan mudah dipahami oleh siswa. Gunakan bahasa Indonesia yang baik. Format output:\n- Judul ringkasan\n- Poin-poin utama (bullet points)\n- Kesimpulan singkat\n\nMateri:\n\n" . $text,
                        ],
                    ],
                ]);

            $ringkasan = $response->json('content.0.text');

            if (!$ringkasan) {
                $errBody = $response->body();
                \Log::error('Summarize AI error', ['status' => $response->status(), 'body' => $errBody]);
                return back()->with('summarize_error', 'Gagal mendapatkan respons dari AI (HTTP ' . $response->status() . '). Coba lagi.');
            }
        } catch (\Exception $e) {
            \Log::error('Summarize AI exception', ['message' => $e->getMessage()]);
            return back()->with('summarize_error', 'Koneksi ke AI gagal: ' . $e->getMessage());
        }

        // Generate PDF dari ringkasan menggunakan PhpWord → DOCX lalu convert
        // Karena tidak ada DOMPDF, kita simpan sebagai DOCX yang bisa dibuka & dicetak
        $judulFile = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename  = 'ringkasan-' . str_replace(' ', '-', $judulFile) . '-' . now()->format('Ymd-His') . '.docx';
        $savePath  = storage_path('app/public/ringkasan/' . $filename);

        // Pastikan folder ada
        if (!file_exists(dirname($savePath))) {
            mkdir(dirname($savePath), 0775, true);
        }

        $this->generateDocx($ringkasan, $judulFile, $savePath);

        // Simpan ke session untuk ditampilkan
        session([
            'summarize_result'   => $ringkasan,
            'summarize_filename' => $filename,
            'summarize_judul'    => $judulFile,
        ]);

        return back()->with('summarize_success', true);
    }

    public function downloadRingkasan($filename)
    {
        $path = storage_path('app/public/ringkasan/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File ringkasan tidak ditemukan.');
        }

        // Pastikan hanya user yang login bisa download
        return response()->download($path, 'Ringkasan-' . $filename);
    }

    private function extractText($file): string
    {
        $ext  = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        return match ($ext) {
            'txt'  => file_get_contents($path),
            'pdf'  => $this->extractPdf($path),
            'docx' => $this->extractDocx($path),
            default => '',
        };
    }

    private function extractPdf(string $path): string
    {
        try {
            $parser = new PdfParser;
            return $parser->parseFile($path)->getText();
        } catch (\Exception $e) {
            return '';
        }
    }

    private function extractDocx(string $path): string
    {
        try {
            $phpWord = PhpWordIOFactory::load($path);
            $text    = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    } elseif (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $child) {
                            if (method_exists($child, 'getText')) {
                                $text .= $child->getText() . "\n";
                            }
                        }
                    }
                }
            }
            return $text;
        } catch (\Exception $e) {
            return '';
        }
    }

    private function generateDocx(string $ringkasan, string $judul, string $savePath): void
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop'    => 1440,
            'marginBottom' => 1440,
            'marginLeft'   => 1800,
            'marginRight'  => 1800,
        ]);

        // Header
        $section->addText(
            'RINGKASAN MATERI AI',
            ['bold' => true, 'size' => 16, 'color' => '005f2d'],
            ['alignment' => 'center']
        );
        $section->addText(
            $judul,
            ['bold' => true, 'size' => 13, 'color' => '333333'],
            ['alignment' => 'center']
        );
        $section->addText(
            'Dihasilkan oleh AI pada ' . now()->translatedFormat('d F Y, H:i') . ' WIB',
            ['size' => 9, 'color' => '888888', 'italic' => true],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);
        $section->addLine(['weight' => 1, 'color' => '005f2d', 'width' => 0]);
        $section->addTextBreak(1);

        // Isi ringkasan — pecah per baris
        $lines = explode("\n", $ringkasan);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                $section->addTextBreak(1);
                continue;
            }

            // Heading-style untuk baris yang diawali tanda #
            if (str_starts_with($line, '# ')) {
                $section->addText(ltrim($line, '# '), ['bold' => true, 'size' => 13, 'color' => '005f2d']);
            } elseif (str_starts_with($line, '## ')) {
                $section->addText(ltrim($line, '# '), ['bold' => true, 'size' => 12, 'color' => '0e7a3d']);
            } elseif (str_starts_with($line, '- ') || str_starts_with($line, '• ')) {
                $section->addListItem(ltrim($line, '-• '), 0, ['size' => 11]);
            } elseif (str_starts_with($line, '**') && str_ends_with($line, '**')) {
                $section->addText(trim($line, '*'), ['bold' => true, 'size' => 11, 'color' => '333333']);
            } else {
                $section->addText($line, ['size' => 11]);
            }
        }

        $section->addTextBreak(2);
        $section->addText(
            '— Dibuat otomatis oleh sistem AI Presence Teen —',
            ['size' => 9, 'color' => '888888', 'italic' => true],
            ['alignment' => 'center']
        );

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($savePath);
    }
}

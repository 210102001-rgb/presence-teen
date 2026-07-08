# PRESENCE-TEEN — Agent Context

## Stack
- Laravel 13.19.0, PHP 8.3.26, MySQL, Livewire v4.3.3
- DB: `presence_teen`, user `root`, no password

## Auth
- 3 roles: `siswa`, `guru`, `orang_tua`
- Seed users (password = `password`):
  - `guru@presensi.test` (role: guru)
  - `siswa@presensi.test` (role: siswa, NIS: 123456)
  - `ortu@presensi.test` (role: orang_tua)
- Seed data: 1 kelas "XII IPA 1" (guru_id=guru), SiswaKelas (siswa->kelas), OrangTuaSiswa (ortu->siswa)
- Middleware alias `role` → `RoleMiddleware`

## Routes (key)
| Route | Middleware | Function |
|---|---|---|
| `/dashboard` | auth,verified | Redirect by role |
| `/dashboard/siswa` | auth,verified | Siswa dashboard |
| `/dashboard/guru` | auth,verified | Guru dashboard |
| `/dashboard/orang-tua` | auth,verified | Ortu dashboard |
| `/presensi/scan` | auth,role:siswa | Scan QR |
| `/presensi/scan/{token}` | — | Scan via URL |
| `/presensi/validasi` | POST, auth,role:siswa | Validasi token |
| `/presensi/guru` | auth,role:guru | Pilih kelas & generate QR |
| `/presensi/guru/{kelas}` | auth,role:guru | QR per kelas |
| `/tugas` | auth | Daftar tugas |
| `/tugas/create` | auth,role:guru | Buat tugas |
| `/tugas/{tugas}/kumpul` | POST, auth,role:siswa | Kumpul tugas |
| `/materi` | auth,role:siswa | Daftar materi dari guru |
| `/materi/create` | auth,role:guru | Upload materi baru |
| `/materi/{materi}/ringkas` | POST, auth,role:siswa | Minta AI ringkas materi |
| `/laporan` | auth,role:guru,orang_tua | Laporan peringatan |

## Middleware
- `RoleMiddleware` registered as `role` alias in `bootstrap/app.php`

## Models
- `Kelas`: fillable = `nama_kelas, guru_id, mata_pelajaran`. Relationships: `sesiPresensi()`, `siswa()`, `waliKelas()`
- `PengumpulanTugas`: fillable = `tugas_id, siswa_id, file_path, status, waktu_kumpul, nilai`
- `LaporanAi`: fillable = `siswa_id, periode, hasil_analisis, level_peringatan`. Column `nilai` added via migration `add_nilai_to_pengumpulan_tugas_table` and `laporan_ais` columns via `add_columns_to_laporan_ais_table`

## AI Features
- Uses **Anthropic Claude API** langsung via `api.anthropic.com/v1`
- Config via `.env`: `AI_API_BASE_URL` (default: `https://api.anthropic.com/v1`), `AI_API_KEY`, `AI_MODEL` (default: `claude-sonnet-4-6`)
- Auth: `x-api-key` header + `anthropic-version: 2023-06-01`
- Request: `POST /messages` (Anthropic format)
- Response: `content.0.text`
- `MateriController@store` upload file → extract text → Claude ringkasan
- `app:analisis-kehadiran` command (weekly Mon 06:00) via `routes/console.php`
- Library: `smalot/pdfparser`, `phpoffice/phpword` untuk ekstraksi teks dari PDF/DOCX

## PWA
- `public/manifest.json`, `public/sw.js`

## Layout
- `@stack('scripts')` added in `layouts/app.blade.php` (before `</body>`)
- QR scanner: `resources/views/presensi/scan.blade.php` uses `html5-qrcode` CDN

## Known fixes applied
- All `href="#"` in dashboards replaced with proper named routes
- Auth gaps patched on Materi/Laporan/Tugas show
- Duplicate `⚡qr-presensi.blade.php` deleted
- Seeder creates SiswaKelas + OrangTuaSiswa linkages

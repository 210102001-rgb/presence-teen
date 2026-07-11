# PRESENCE-TEEN — Agent Context

## Stack
- Laravel 13, PHP 8.3, Livewire v4, Breeze (auth scaffolding)
- Frontend: Blade + Alpine.js + Tailwind CSS 3 (via `tailwind.config.js` + PostCSS), Vite 8
- Dev DB: MySQL — database `presence_teen`, user `root`, no password
- Tests: SQLite `:memory:` (configured in `phpunit.xml`)
- `@tailwindcss/vite` v4 is in `package.json` but **not used** — actual Tailwind is v3 via `tailwind.config.js`

## Commands
```sh
composer setup          # install, key:generate, migrate, npm install+build
composer dev            # serve + queue:listen + pail + vite dev (via concurrently)
composer test           # config:clear then php artisan test (PHPUnit 12)
./vendor/bin/pint       # code formatter (default Laravel preset, no pint.json) — run before committing
php artisan db:seed     # creates guru/siswa/ortu users, 1 kelas, linkages
```
Run a single test file: `php artisan test --filter=SomeTest`

No CI pipeline — `.github/workflows/` does not exist.

## Auth & Roles
- 3 roles on `users.role`: `siswa`, `guru`, `orang_tua`
- Middleware alias `role` → `App\Http\Middleware\RoleMiddleware` (registered in `bootstrap/app.php`)
- `RoleMiddleware` accepts variadic roles: `role:guru,orang_tua`
- Seed users (password = `password`):
  - `guru@presensi.test` (guru), `siswa@presensi.test` (siswa, NIS 123456), `ortu@presensi.test` (orang_tua)
- Seed data: kelas "XII IPA 1" (guru_id=guru), `SiswaKelas` (siswa→kelas), `OrangTuaSiswa` (ortu→siswa)

## Project Structure
- `app/Http/Controllers/` — DashboardController, PresensiController, TugasController, MateriController, LaporanController
- `app/Livewire/QrPresensi.php` — Livewire component for QR generation
- `app/Console/Commands/AnalisisKehadiranCommand.php` — weekly AI attendance analysis (scheduled Mon 06:00)
- `app/Models/` — User, Kelas, SiswaKelas, OrangTuaSiswa, SesiPresensi, Presensi, Tugas, PengumpulanTugas, Materi, LaporanAi
- `resources/views/` — Blade views organized by feature: `dashboard/`, `presensi/`, `tugas/`, `materi/`, `laporan/`
- `database/migrations/` — 22 migrations; several `add_columns_to_*` alter-table migrations exist alongside initial creates

## Code Conventions
- PHP 8 attribute syntax throughout: User model uses `#[Fillable([...])]`, `#[Hidden([...])]`; Artisan commands use `#[Signature(...)]`, `#[Description(...)]`
- `tailwind.config.js` has a custom design system with Material Design 3-style color tokens (`primary`, `secondary`, `tertiary`, `error`, `surface`, `on-*`, etc.) and `Inter` as the primary font — use these tokens, not raw Tailwind colors

## AI Integration
- Direct Anthropic Claude API calls via `Http::withOptions(['base_uri' => ...])` (no SDK)
- Config: `config('services.ai.*')` sourced from `.env` vars `AI_API_BASE_URL`, `AI_API_KEY`, `AI_MODEL`
- Auth headers: `x-api-key` + `anthropic-version` from `config('services.ai.version')`
- Used in: `MateriController@ringkas` (summarize uploaded material) and `AnalisisKehadiranCommand` (attendance analysis)
- Text extraction: `smalot/pdfparser` (PDF), `phpoffice/phpword` (DOCX), native `file_get_contents` (TXT)
- SSL verify is disabled (`'verify' => false`) in AI HTTP calls

## Key Gotchas
- `.env.example` defaults to `DB_CONNECTION=sqlite` but dev `.env` uses `DB_CONNECTION=mysql` — new setup must configure MySQL
- `QUEUE_CONNECTION=database` in `.env` — `composer dev` starts `queue:listen`; queue tables must be migrated
- `SESSION_DRIVER=database` — session table migration included in Laravel defaults
- QR scanner view (`presensi/scan.blade.php`) loads `html5-qrcode` from CDN
- Route `/presensi/scan/{token}` is public (no auth) — intentional for QR URL sharing
- `@stack('scripts')` is in `layouts/app.blade.php` before `</body>` — push page-specific JS there
- PWA: `public/manifest.json` + `public/sw.js`

# PRESENCE-TEEN — Agent Context

## Stack
- Laravel 13, PHP 8.3, Livewire v4, Breeze (auth scaffolding)
- Frontend: Blade + Alpine.js + Tailwind CSS 3 (via `tailwind.config.js` + PostCSS), Vite 8
- Dev DB: MySQL — database `presence_teen`, user `root`, no password
- Tests: SQLite `:memory:` (configured in `phpunit.xml`)
- `@tailwindcss/vite` v4 is in `package.json` but **not used** — actual Tailwind is v3 via `tailwind.config.js`

## Figma & Stitch Links
- Design URL: https://www.figma.com/design/wTmPZQIkrf4JWo1RywA0zJ/Solvia-Project?node-id=0-1&p=f&t=OsYHmjI0PjwfAvSb-0
- Stitch Guru URL: https://stitch.withgoogle.com/projects/16068625114209282442
- Stitch Mobile URL: https://stitch.withgoogle.com/projects/7271032810189453938

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

## Missing UI/UX Figma/HTML Menus & Features (From `uiux/` & `resources/html/`)
The following pages/features exist as raw HTML templates but are not yet implemented or integrated into Laravel:
- **Siswa (Student):**
  - **Riwayat Presensi** & **Detail Presensi** (`uiux/siswa/riwayat_presensi/code.html` & `detail_presensi/code.html`)
  - **Profil Siswa Custom** (`uiux/siswa/profil_siswa/code.html`) — currently redirects to Breeze edit profile template.
  - **Splash Screen** (`uiux/siswa/splash_screen/code.html`)
- **Guru (Teacher):**
  - **Jadwal Mengajar** (`uiux/gurudekstop/.../jadwal/code.html`) — teacher class schedules.
  - **Data Siswa & Data Kelas** (`uiux/gurudekstop/.../data_siswa/code.html`, `data_kelas/code.html`) — student and class management lists.
  - **Notifikasi** (`uiux/guru/user guru/notifikasi/code.html`)
  - **Input Manual Kehadiran** (`uiux/guru/user guru/input_manual_kehadiran/code.html`) — teacher manual correction overrides.
  - **Sesi Presensi Berhasil Dibuat Confirmation Screen** (`uiux/guru/user guru/sesi_berhasil_dibuat/...`)
  - **Preview & Ekspor Laporan** (`uiux/guru/user guru/preview_ekspor_laporan/code.html`)
- **Orang Tua (Parent):**
  - **AI Insight Chat Window** (`uiux/walisiswa/ai_insight_chat_window/code.html`) — interactive AI chatbot assistant.
  - **Profil Anak** & **Profil Orang Tua Custom** (`uiux/walisiswa/profil_anak_desktop/code.html`, `profil_orang_tua_desktop_1/code.html`)
  - **Pengaturan & Logout Custom** (`uiux/walisiswa/pengaturan_desktop/code.html`)

## Discrepancies Between Stitch Guru & Laravel Views
- **Jadwal Mengajar (`guru/jadwal.blade.php`):**
  - Stitch shows a full weekly interactive calendar grid with absolute time-based event blocks (Monday-Friday, 08:00-12:00) and a "Daily Agenda" sidebar tracking "In Progress" sessions.
  - Laravel currently renders a simple table listing classes and subjects with a "Mulai Sesi" quick link.
- **Data Siswa & Data Kelas (`guru/kelas_siswa.blade.php`):**
  - Stitch lists students in a "Student Directory" layout with filter dropdowns (by class and device status), device active indicators, attendance percentage progress bars, and pagination footer.
  - Laravel displays nested tables grouped by classes, showing basic columns (No, Name, Email, NIS) without device status, attendance progress bars, filters, or export/import actions.
- **Input Manual Kehadiran (`guru/manual_presensi.blade.php`):**
  - Stitch uses a distinct visual layout with search filters, quick attendance action buttons, and student cards.
  - Laravel uses a standard HTML input form containing dropdown selects for sessions, students, and status.
- **Top Bar & Navigation:**
  - Stitch uses `Poppins` font throughout and custom container parameters (like `sidebar-width: 280px`).
  - Laravel uses `Inter` font, a standard `w-64` (256px) sidebar, and locks views within `x-app-layout`.

## Discrepancies Between Stitch Mobile & Laravel Views
- **Bottom Navigation Bar:**
  - Stitch Mobile defines a fixed bottom navigation bar (`fixed bottom-0 left-0 right-0 h-20 bg-white border-t border-outline-variant pb-safe`) with 5 tabs: Dashboard, Presensi, Aktivitas, AI Insight, and Profil.
  - Laravel now has `components/mobile-bottom-nav.blade.php` included in `layouts/app.blade.php` — role-aware, `lg:hidden`, safe-area support. Matches Stitch design.
- **Floating AI Button:**
  - Stitch Mobile has a prominent pulsing circular Floating Action Button (`fixed bottom-24 right-margin-mobile w-14 h-14 bg-primary`) for the AI assistant.
  - Laravel displays a custom Livewire AI chat widget (`livewire/chat-ai.blade.php`) but lacks the floating indicator/pulsing action button specified in Stitch.
- **Mobile Cards & Layout:**
  - Stitch Mobile displays student information inside a card (`bg-primary-container text-on-primary`) at the top, followed by a grid of 4 attendance and activity metrics (Kehadiran, Izin/Sakit, Terlambat, Poin Prestasi), a custom progress gauge ("Prediksi Kelulusan"), and inline AI recommendation insights.
  - Laravel views render responsive desktop elements stacked vertically on mobile viewports.

## Critical UI/UX Issues to Address (From `.impeccable/critique/`)
- **Broken Mobile Layout:** The sidebar layout (`layouts/navigation.blade.php`) locks to `w-64 fixed left-0 top-0` and main content is offset by `ml-64`. Needs Alpine.js state for mobile responsive toggling (`-translate-x-full lg:translate-x-0`).
- **Parent Dashboard Attribution:** Parent task list display shows "Belum dikumpulkan" but fails to specify which child it belongs to when parent has multiple registered children.
- **Theme Color Token Consistency:** blade views bypass configured Tailwind tokens and use hardcoded hex values (e.g. `bg-[#0e7a3d]`, `bg-[#ffdad6]`). Use custom Material Design 3 tokens defined in `tailwind.config.js` (e.g. `bg-primary`, `bg-error-container`).
- **Destructive Action Warning:** The "Akhiri Sesi Presensi" button on the teacher dashboard terminates the session immediately with no confirmation. Needs confirmation warning modal or dialogue.

## Key Gotchas
- `.env.example` defaults to `DB_CONNECTION=sqlite` but dev `.env` uses `DB_CONNECTION=mysql` — new setup must configure MySQL
- `QUEUE_CONNECTION=database` in `.env` — `composer dev` starts `queue:listen`; queue tables must be migrated
- `SESSION_DRIVER=database` — session table migration included in Laravel defaults
- QR scanner view (`presensi/scan.blade.php`) loads `html5-qrcode` from CDN
- Route `/presensi/scan/{token}` is public (no auth) — intentional for QR URL sharing
- `@stack('scripts')` is in `layouts/app.blade.php` before `</body>` — push page-specific JS there
- PWA: `public/manifest.json` + `public/sw.js`
- `@livewireStyles` and `@livewireScripts` are in `layouts/app.blade.php` — do not duplicate in child views
- **CRITICAL**: `resources/js/app.js` must NOT import or start Alpine.js — Livewire v4 bundles Alpine inside `livewire.min.js` via `@livewireScripts`. A separate Alpine instance breaks all `wire:` directives silently
- QR token validation (`PresensiController@validasiToken`) must handle full URLs (`http://.../{token}`) — uses `parse_url()` + `basename()`
- `SesiPresensi` model uses `qr_expired_at` (not `durasi`) — timer calculations use `now()->diffInSeconds()`
- Livewire `wire:click` buttons need `type="button"` to prevent native form submit; form needs `onsubmit="return false;"`
- Seed data creates 1 guru, 1 siswa, 1 ortu, 1 kelas ("XII IPA 1") — 30+ active sessions may exist from testing
- **CRITICAL**: `welcome.blade.php` is standalone (own `<!DOCTYPE html>`, no layout) — does NOT use Livewire. Alpine.js must be loaded via CDN (`<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">`). Without it, all `x-data`, `x-show`, `@click`, `x-transition` directives are dead
- Mobile bottom nav (`components/mobile-bottom-nav.blade.php`) is included in `layouts/app.blade.php` — role-aware (siswa/guru/orang_tua), `lg:hidden`, safe-area support

## Presensi System Architecture
- `QrPresensi` Livewire component handles all session lifecycle (create, extend, end)
- QR URL format: `/presensi/scan/{token}` — public route for student QR scanning
- Student attendance recorded in `presensi` table with foreign keys to `siswa_id` and `sesi_presensi_id`
- Session expiration: QR refreshes every 15s, session auto-closes after 60 min

# PRESENCE-TEEN — Agent Notes

## What matters here
- Laravel 13 + PHP 8.3 + Livewire v4 + Breeze.
- Frontend is Blade + Alpine.js + Tailwind CSS 3 via `tailwind.config.js` and PostCSS; `@tailwindcss/vite` in `package.json` is not the active setup.
- Dev uses MySQL (`presence_teen`, `root`, no password). Tests use SQLite `:memory:` from `phpunit.xml`.

## Commands
```sh
composer setup   # install, copy .env, key:generate, migrate, npm install, build
composer dev     # serve + queue:listen + pail + vite
composer test    # config:clear then php artisan test
./vendor/bin/pint
php artisan db:seed
php artisan test --filter=SomeTest
```
- Run `pint` before finishing code changes.
- `composer dev` depends on database tables because queue + sessions use the database.

## Repo structure
- `app/Http/Controllers/` contains the main feature controllers: Dashboard, Presensi, Tugas, Materi, Laporan.
- `app/Livewire/QrPresensi.php` owns QR session lifecycle.
- `app/Console/Commands/AnalisisKehadiranCommand.php` handles weekly AI attendance analysis.
- `resources/views/` is organized by feature area.
- `database/migrations/` includes several `add_columns_to_*` alter migrations alongside initial tables.

## Important conventions and gotchas
- `resources/js/app.js` must not start its own Alpine instance; Livewire v4 already bundles Alpine in `@livewireScripts`.
- `welcome.blade.php` is standalone and needs Alpine loaded from the CDN if you edit it.
- `layouts/app.blade.php` already includes `@livewireStyles`, `@livewireScripts`, `@stack('scripts')`, and the mobile bottom nav.
- QR scan URLs are public at `/presensi/scan/{token}`; token validation must accept full URLs too.
- `SesiPresensi` uses `qr_expired_at` for timing, not `durasi`.
- Livewire action buttons need `type="button"`, and forms using them should prevent native submit.
- Use the custom Tailwind theme tokens (`primary`, `surface`, `error`, `on-*`, etc.); avoid hardcoded hex colors.
- AI requests go through `Http::withOptions(['base_uri' => ...])` with `x-api-key` and `anthropic-version`; SSL verification is disabled in those calls.

## Roles / seed data
- Roles are `siswa`, `guru`, and `orang_tua`.
- `RoleMiddleware` supports multiple roles like `role:guru,orang_tua`.
- Seed users exist for `guru@presensi.test`, `siswa@presensi.test`, and `ortu@presensi.test` with password `password`.
- Seeder creates kelas `XII IPA 1` and the user links.

## UI context worth knowing
- Mobile bottom nav is role-aware and already implemented.
- The app uses `Inter` in Laravel views; some design files use `Poppins`, but the codebase currently standardizes on `Inter`.
- The repo has no `.github/workflows/` CI configuration.
- PWA service worker (`public/sw.js`) is cache-first for assets only; keep HTML `navigate` requests network-first or users will see stale authenticated pages after logout (service worker cache ignores `Cache-Control: no-store`). If you change `sw.js`, bump `CACHE_NAME` to purge old caches on activate.

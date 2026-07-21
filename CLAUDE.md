# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel 11 (PHP 8.1+) website for an arts/cinema venue, driven by **Laravel Nova 4** as the admin/CMS. The public site's programme (films, events, memberships, funds, shop products) is imported from the **Spektrix** ticketing system; editors layer marketing content on top of that imported data through Nova.

## Commands

```bash
# Frontend (Vite is the primary build)
npm run dev        # Vite dev server (expects hpph2.test Valet HTTPS certs; falls back to plain http)
npm run build      # Production asset build
npm run build:mix  # Legacy laravel-mix build (webpack.mix.js) — rarely needed

# PHP
php artisan test                 # Run the PHPUnit suite
php artisan test --filter=Name   # Run a single test by name
vendor/bin/pint                  # Format PHP (laravel/pint, default ruleset)
npx prettier --write resources   # Format Blade/CSS/JS (@shufo blade plugin, tailwind class sort)

# Spektrix data (see routes/console.php)
php artisan fetch:all            # Import events, memberships, funds, shop from Spektrix
php artisan fetch:events         # Import events + instances only
php artisan cache:programme      # Rebuild cache-intensive listing queries
php artisan cache:availability   # Refresh per-instance ticket availability
```

Blade edits trigger a full HMR reload via a custom Vite plugin in `vite.config.js`.

## Architecture

### Spektrix import pipeline
External Spektrix REST API → `app/Jobs/Fetch*Data.php` → local Eloquent models. `FetchEventData` is the core job: it pulls events/instances/venues and `updateOrCreate`s `Event`, `Instance`, `Season`, `Strand` rows. Imported models (`Event`, `Instance`, `Membership`, `Fund`, `Product`) use **string primary keys** (the Spektrix IDs), `$incrementing = false`, and often `$timestamps = false` — keep that in mind when writing queries or factories.

`app/Console/Kernel.php` schedules `fetch:all` hourly and `cache:programme` / `cache:availability` every five minutes. The Spektrix base URL is built from the `spektrix_client_name` Nova setting (`https://system.spektrix.com/{client}/...`), not from `.env`.

### Settings
Site configuration lives in **Outl1ne Nova Settings**, read via the global helpers `nova_get_setting('key')` / `nova_get_settings()`. The `spektrix` route middleware (`ExceptionIfNoSpektrixSettings`) caches all settings under the `"settings"` cache key on every request and aborts 500 if Spektrix settings are missing — so all front-end routes depend on that middleware being present (see `routes/web.php`, which wraps everything in `Route::middleware(["spektrix"])`).

### Page content / flexible layouts
Editable page bodies use **Whitecube Nova Flexible Content**. `app/Casts/PageContentCast.php` maps layout keys (e.g. `"banner"`, `"home-hero"`, `"film"`) to classes in `app/Nova/Flexible/Layouts/`, each with a matching Blade partial. Adding a content block = new Layout class + its Blade view + an entry in the relevant cast/Nova resource.

### Models
Models mix several Spatie/Astrotomic packages: `HasMedia`/`InteractsWithMedia` (media library), `CachesAttributes` (Astrotomic cachable attributes — computed values cached per-model), `Sluggable`, `HasTags`, `LogsActivity`, and `SoftDeletes`. `Event` carries the domain query scopes that drive listings: `shownInProgramme()`, `hasFutureOrRecentInstances()`, `hasFutureInstances()`, `audioDescribed()`.

### Front end
Server-rendered Blade + **Livewire 3** (`app/Livewire/`: search, programme listings by day/alphabetical, shop, posts) + **Alpine.js** (with focus/intersect plugins). Interactive search/listing components query the `Event` scopes above. Assets: `resources/js/app.js`, `resources/css/app.css` and friends, entry points registered in `vite.config.js`.

### Caching & invalidation
Full-page caching is **Spatie ResponseCache** (all successful GET requests). Routes that must stay dynamic use the `doNotCacheResponse` middleware (e.g. the email preview and `event/{event}/instances` API route). Model **observers** in `app/Observers/` clear the response cache (and the `"settings"` cache) when content changes — when adding a model whose edits should bust the public cache, wire up a matching observer.

### Nova admin
Resources in `app/Nova/`, with custom `Actions/`, `Metrics/` (incl. `SpektrixOverview`, `ImportHistory`), `Dashboards/`, menu-builder types, and flexible layouts. Queue jobs are dispatched from Nova actions (`FetchData`, `FetchShopData`) as well as from artisan/scheduler.

## Notes

- `QUEUE_CONNECTION` defaults to `sync` in `.env`; Laravel Horizon is installed for Redis-backed queues in production. Fetch/cache jobs run inline unless the queue is configured.
- The catch-all `{page}` route (excluding `nova*`) resolves CMS `Page` models by slug — it must stay last in `routes/web.php`.
- Tests currently contain only Laravel's example stubs; there is no established suite to mirror yet.

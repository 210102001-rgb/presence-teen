# How to Properly Clear Caches in Presence Teen

## Quick Clear (Recommended)
Run this command to clear all Laravel caches:

```bash
php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear
```

Or as a one-liner:
```bash
php artisan config:clear; php artisan cache:clear; php artisan view:clear; php artisan route:clear
```

## What Each Command Does

### 1. **config:clear** (Configuration Cache)
```bash
php artisan config:clear
```
- Clears: `.env` configuration cache
- Use when: You change `.env` values
- Effect: `.env` values reloaded on next request

### 2. **cache:clear** (Application Cache)
```bash
php artisan cache:clear
```
- Clears: Application data cache
- Use when: Cached data seems stale
- Effect: All cached queries/data refreshed

### 3. **view:clear** (Compiled Views)
```bash
php artisan view:clear
```
- Clears: Compiled Blade templates
- Use when: Blade views aren't updating
- Effect: Views recompiled on next render
- **MOST IMPORTANT FOR YOUR ISSUE** ← Use this one!

### 4. **route:clear** (Route Cache)
```bash
php artisan route:clear
```
- Clears: Compiled route cache
- Use when: New routes added or routes not working
- Effect: Routes re-registered

### 5. **optimize:clear** (Everything)
```bash
php artisan optimize:clear
```
- Clears: All caches at once (config, cache, view, route, bootstrap)
- Most thorough option
- **Best for your situation**

## Browser Cache Clear

Sometimes the browser also caches HTML/CSS/JS. Do this:

### Windows/Chrome:
1. Press `Ctrl + Shift + Delete`
2. Select "All time"
3. Check all boxes
4. Click "Clear data"
5. Hard refresh: `Ctrl + Shift + R`

### Windows/Firefox:
1. Press `Ctrl + Shift + Delete`
2. Click "Clear All"
3. Hard refresh: `Ctrl + F5`

## Complete Cache Clear (For Your Issue)

Run this sequence:

```bash
# Step 1: Clear Laravel caches
php artisan optimize:clear

# Step 2: Clear browser cache (in your browser)
# Ctrl + Shift + Delete → Select All Time → Clear

# Step 3: Hard refresh page
# Ctrl + Shift + R (or Cmd + Shift + R on Mac)
```

## For Blade Template Issues Specifically

Since your issue is with the form dropdowns not showing updated data:

```bash
# Most direct fix:
php artisan view:clear

# Then hard refresh in browser:
# Ctrl + Shift + R
```

## When to Use Each

| Issue | Command | Browser Cache |
|-------|---------|---------------|
| `.env` not updating | `config:clear` | Not needed |
| Stale data in form | `cache:clear` | May help |
| **Views not updating** | **`view:clear`** | **YES - Hard refresh** |
| Routes not found | `route:clear` | Not needed |
| Everything broken | `optimize:clear` | YES - Hard refresh |
| Form dropdowns empty | `view:clear` + `cache:clear` | YES - Hard refresh |

## Batch Clear Script

### For Windows (PowerShell)
Create a file `clear-cache.ps1`:

```powershell
Write-Host "🧹 Clearing all caches..." -ForegroundColor Green
php artisan optimize:clear
Write-Host "`n✅ All caches cleared!" -ForegroundColor Green
Write-Host "Now do:" -ForegroundColor Yellow
Write-Host "1. Hard refresh browser: Ctrl + Shift + R" -ForegroundColor Yellow
Write-Host "2. Or: Ctrl + Shift + Delete → Clear All Time" -ForegroundColor Yellow
```

Run it:
```bash
.\clear-cache.ps1
```

### For Windows (CMD)
Create a file `clear-cache.bat`:

```batch
@echo off
cls
echo Clearing all caches...
php artisan optimize:clear
echo.
echo Caches cleared successfully!
echo.
echo Next steps:
echo 1. Hard refresh browser: Ctrl+Shift+R
echo 2. Check the form again
pause
```

Run it:
```bash
clear-cache.bat
```

### For Mac/Linux (Bash)
Create a file `clear-cache.sh`:

```bash
#!/bin/bash
echo "🧹 Clearing all caches..."
php artisan optimize:clear
echo ""
echo "✅ Caches cleared!"
echo "Now do:"
echo "1. Hard refresh: Cmd+Shift+R (Mac) or Ctrl+Shift+R (Linux)"
echo "2. Check the form again"
```

Run it:
```bash
chmod +x clear-cache.sh
./clear-cache.sh
```

## Complete Reset (Nuclear Option)

If everything is still broken:

```bash
# Clear Laravel caches
php artisan optimize:clear

# Delete bootstrap cache directory
rm -r bootstrap/cache/*    # Linux/Mac
# OR
rmdir /s /q bootstrap\cache    # Windows

# Delete composer cache
composer clear-cache

# Clear browser completely
# Ctrl+Shift+Delete → All time → Clear all

# Hard refresh
# Ctrl+Shift+R
```

## Verify Caches Are Cleared

Check that these files/folders are gone:

```bash
# These should NOT exist after clearing:
ls bootstrap/cache/
ls storage/framework/cache/
```

Or check manually:
- Windows: `d:\Project\presence-teen\bootstrap\cache\`
- Should have few files (packages.php, services.php) but NOT:
  - `config.php` ← Should be gone
  - Any other compiled files

## Your Specific Issue

Since dropdowns showing empty data, you need:

```bash
# Step 1: Clear views (most important)
php artisan view:clear

# Step 2: Clear cache
php artisan cache:clear

# Step 3: Browser hard refresh
# Ctrl+Shift+R

# Step 4: Check form again
```

Or all in one:
```bash
php artisan optimize:clear && echo "Clear browser with Ctrl+Shift+R"
```

## Laravel Cache System

```
┌─────────────────────────────────────────┐
│          Your Code Changes              │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│     Config Cache (config/*)             │ ← config:clear
│     View Cache (storage/framework/views)│ ← view:clear  
│     Route Cache (bootstrap/cache)       │ ← route:clear
│     App Cache (storage/framework/cache) │ ← cache:clear
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      PHP/Laravel Renders                │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│     Browser Cache (Chrome/Firefox)      │ ← Ctrl+Shift+Delete
│     Hard Refresh (Ctrl+Shift+R)         │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      User Sees Updated Page             │
└─────────────────────────────────────────┘
```

## Recommended Daily Workflow

After making code changes:

```bash
# 1. Clear caches
php artisan optimize:clear

# 2. Test in browser
# Go to page...

# 3. If still not working
# Hard refresh: Ctrl+Shift+R

# 4. If STILL not working
# Clear browser cache: Ctrl+Shift+Delete
```

## Summary

For your specific issue (form dropdowns not showing):

1. **In terminal:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

2. **In browser:**
   - Hard refresh: `Ctrl+Shift+R`
   - Or full browser cache clear: `Ctrl+Shift+Delete` → All time

3. **Reload the form page**

4. **Check if dropdowns now show data**

---

**Most Common:** Just run:
```bash
php artisan optimize:clear
```

Then hard refresh: `Ctrl+Shift+R`

That fixes 95% of "changes not showing" issues!

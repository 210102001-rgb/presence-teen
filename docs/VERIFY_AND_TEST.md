# Verify & Test Manual Presensi Fix

## ✅ Code Changes Verified

### Controller Changes ✓
File: `app/Http/Controllers/PresensiController.php`
```
Line 202: ->orderBy('is_active', 'desc')  // Active sessions first
Line 203: ->latest()  // Most recent first
Line 204: ->get();
```
✅ **CONFIRMED** - Old `where('is_active', true)` has been removed

### View Changes ✓
File: `resources/views/guru/manual_presensi.blade.php`
```
Line 56: @if($s->is_active)
Line 57:     ✓ Aktif
Line 58: @else
Line 59:     (Selesai)
Line 60: @endif
```
✅ **CONFIRMED** - Status indicator added

## Complete Cache Clear Steps

### Step 1: Clear Laravel Caches (Terminal)
```bash
cd d:\Project\presence-teen
php artisan optimize:clear
```

Expected output:
```
INFO  Configuration cache cleared successfully.
INFO  Application cache cleared successfully.
INFO  Compiled views cleared successfully.
INFO  Route cache cleared successfully.
INFO  ...
```

### Step 2: Verify Bootstrap Cache Cleared
Check that this folder is empty or only has minimal files:
```
d:\Project\presence-teen\bootstrap\cache\
```

Should only contain:
- `packages.php` ✓
- `services.php` ✓

Should NOT contain:
- `config.php` ❌
- Other compiled files ❌

### Step 3: Clear Browser Cache

#### Chrome/Edge:
1. Press `Ctrl + Shift + Delete`
2. Select "All time"
3. Check these boxes:
   - ☑ Cookies and other site data
   - ☑ Cached images and files
4. Click "Clear data"

#### Firefox:
1. Press `Ctrl + Shift + Delete`
2. Time range: "Everything"
3. Check all boxes
4. Click "Clear Now"

#### Safari (Mac):
1. Menu → History → Clear History
2. Select "all history"
3. Click "Clear History"

### Step 4: Hard Refresh Browser

Hold down `Ctrl` and press `Shift + R` simultaneously:
```
Ctrl + Shift + R
```

Or for Mac:
```
Cmd + Shift + R
```

Wait for page to fully load (may take a few seconds).

## Testing the Fix

### Test 1: Create Test Sessions

1. **Login as teacher:**
   - Email: `guru@presensi.test`
   - Password: `password`

2. **Go to: QR Presensi**
   - Dashboard → QR Presensi (or Menu → QR Presensi)

3. **Create 3 test sessions:**
   
   **Session 1:**
   - Select class: "XII IPA 1"
   - Subject: "Matematika"
   - Topic: "Trigonometri"
   - Duration: 30 seconds
   - Click "Mulai Sesi"
   - Wait 5 seconds
   - Click "Akhiri Sesi" (end it)
   
   **Session 2:**
   - Same steps, Subject: "Fisika"
   - Wait 3 seconds
   - Click "Akhiri Sesi" (end it)
   
   **Session 3 (Keep Active):**
   - Same steps, Subject: "Kimia"
   - Do NOT end it
   - Leave active

4. **Verify:** You should now have:
   - 1 active session (Kimia) → `is_active = true`
   - 2 ended sessions (Matematika, Fisika) → `is_active = false`

### Test 2: Open Manual Presensi Form

1. **Menu → Input Manual (or Input Manual Kehadiran)**

2. **Check Session Dropdown**

   Should see:
   ```
   -- Pilih Sesi (Kelas - Tanggal) --
   XII IPA 1 - Kimia (25 siswa) ✓ Aktif - [date/time]
   XII IPA 1 - Fisika (25 siswa) (Selesai) - [date/time]
   XII IPA 1 - Matematika (25 siswa) (Selesai) - [date/time]
   ```

   ✅ **EXPECT:** All 3 sessions visible
   ✅ **EXPECT:** Kimia marked as "✓ Aktif"
   ✅ **EXPECT:** Others marked as "(Selesai)"
   ✅ **EXPECT:** Most recent active first

3. **If you see EMPTY dropdown:**
   - Sessions NOT appearing
   - Go back to "Step 1: Clear Laravel Caches"
   - Run: `php artisan optimize:clear`
   - Then do Step 3 & 4 again
   - Reload page in browser

### Test 3: Test Each Session

For each session in dropdown:

1. **Select the session**
   - Click dropdown
   - Click a session (e.g., "Kimia")

2. **Check Student List**
   - "Pilih Siswa" dropdown should populate
   - Should show students like:
     ```
     Ahmad Rizki (NIS: 123456)
     Budi Santoso (NIS: 123457)
     Citra Dewi (NIS: 123458)
     ... (all 25 students)
     ```

3. **Select Student & Status**
   - Pick any student
   - Select status: "Hadir"
   - Click "Simpan Presensi"

4. **Verify Success**
   - Green success message appears
   - Message: "Presensi berhasil dicatat secara manual."
   - Data saved to database

### Test 4: Verify Old Sessions Work

1. **Select an ended session (Selesai)**
   - Click "Fisika (Selesai)" from dropdown

2. **Add attendance for old session**
   - Select a student
   - Select status
   - Save

3. **Verify it works**
   - Success message appears
   - No errors
   - Data saved for past session

## Troubleshooting

### Problem: Dropdown still empty
**Solution:**
```bash
# Option 1: Quick fix
php artisan optimize:clear
# Then Ctrl+Shift+R in browser

# Option 2: Deep clean
rm bootstrap/cache/*
php artisan optimize:clear
# Clear browser cache: Ctrl+Shift+Delete
# Hard refresh: Ctrl+Shift+R

# Option 3: Nuclear option
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
# Clear browser completely
# Then restart browser
```

### Problem: Students not showing after selecting session
**Solution:**
1. Check browser console (F12) for errors
2. Hard refresh: Ctrl+Shift+R
3. Clear cache: `php artisan view:clear`
4. Check that sessions have students in database

### Problem: "Belum ada data sesi presensi" message
**Solution:**
- Need to create at least one session first
- Go to QR Presensi
- Create a session
- Then open manual form

### Problem: Sessions showing but wrong data
**Solution:**
1. Clear cache: `php artisan optimize:clear`
2. Hard refresh: Ctrl+Shift+R
3. If still wrong, check database:
   ```sql
   SELECT id, kelas_id, guru_id, is_active, created_at 
   FROM sesi_presensi 
   WHERE guru_id = (your_teacher_id)
   ORDER BY created_at DESC;
   ```

## Verification Checklist

- [ ] Ran `php artisan optimize:clear`
- [ ] Cleared browser cache (Ctrl+Shift+Delete)
- [ ] Hard refreshed (Ctrl+Shift+R)
- [ ] Created 3+ test sessions
- [ ] Ended 2 of them
- [ ] Opened manual form
- [ ] Saw all 3 sessions in dropdown
- [ ] Active session shows "✓ Aktif"
- [ ] Ended sessions show "(Selesai)"
- [ ] Selected a session → students appeared
- [ ] Added attendance → success message
- [ ] Added attendance to past session → worked

## Quick Reference

| Action | Command |
|--------|---------|
| Clear all caches | `php artisan optimize:clear` |
| Clear only views | `php artisan view:clear` |
| Clear only cache | `php artisan cache:clear` |
| Hard refresh | `Ctrl+Shift+R` |
| Full browser clear | `Ctrl+Shift+Delete` |

## If Still Not Working

1. **Check git status:**
   ```bash
   git diff app/Http/Controllers/PresensiController.php
   git diff resources/views/guru/manual_presensi.blade.php
   ```
   
   Should show changes (new query, status display)

2. **Force re-read files:**
   ```bash
   php artisan config:cache
   ```

3. **Check storage permissions:**
   ```bash
   # Windows
   attrib -H bootstrap/cache
   ```

4. **Restart any running servers:**
   ```bash
   # If using 'composer dev' or 'php artisan serve'
   # Stop it (Ctrl+C)
   # Start again
   ```

5. **Check database:**
   ```bash
   # Verify sessions exist and are not deleted
   php artisan tinker
   >>> \App\Models\SesiPresensi::count()
   >>> \App\Models\SesiPresensi::where('guru_id', auth()->id())->count()
   ```

## Expected Results After Fix

✅ **Sessions Dropdown:**
- Shows ALL sessions (active + inactive)
- Active sessions listed first
- Status indicator shows (✓ Aktif or (Selesai))
- Can select any session

✅ **Form Functionality:**
- Select ended session → students populate
- Can add/edit attendance for any session
- Form works for past sessions too
- No errors on submit

✅ **No Empty Dropdowns:**
- If sessions exist, they appear
- If students exist in class, they show
- Form is fully functional

## Success Indicator

After doing all steps, you should see:

**Before:**
```
PILIH SESI PRESENSI
-- Pilih Sesi (Kelas - Tanggal) --  [EMPTY - nothing happens]
```

**After:**
```
PILIH SESI PRESENSI
-- Pilih Sesi (Kelas - Tanggal) --
XII IPA 1 - Kimia (25 siswa) ✓ Aktif - 19 Jul 2026, 10:30
XII IPA 1 - Fisika (25 siswa) (Selesai) - 18 Jul 2026, 09:15
XII IPA 1 - Matematika (25 siswa) (Selesai) - 17 Jul 2026, 08:45
```

Then click one → students appear ✅

---

**Done!** The form should now show all sessions correctly.

# Manual Presensi Form — Sessions Not Displaying Fix

## Problem
When a teacher opened the "Input Manual Kehadiran" (Manual Attendance Input) form, the session dropdown was empty even though sessions had been created and attendance was already recorded. The form showed:
- "-- Pilih Sesi (Kelas - Tanggal) --" with no options
- "-- Pilih Siswa --" (no students to select)

## Root Cause
The form was filtering sessions with `where('is_active', true)`, which meant:
1. ✅ Teacher creates QR session → `is_active = true`
2. ✅ Students scan QR code → attendance recorded
3. ✅ Teacher ends session → `is_active = false` (marked inactive)
4. ❌ Teacher opens "Input Manual Kehadiran" → **No sessions appear** (form broken!)

The form was **only showing the currently active session**. Once a session ended, it disappeared from the form, making it impossible to make corrections or add missing attendance records for past sessions.

## Solution Implemented

### 1. Controller Fix (`PresensiController.php`)

**Before:**
```php
$sesi = SesiPresensi::where('guru_id', auth()->id())
    ->with(['kelas' => function($query) {
        $query->with('siswa');
    }])
    ->where('is_active', true)  // ← FILTERED OUT ENDED SESSIONS
    ->latest()
    ->get();
```

**After:**
```php
$sesi = SesiPresensi::where('guru_id', auth()->id())
    ->with(['kelas' => function($query) {
        $query->with('siswa');
    }])
    ->orderBy('is_active', 'desc')  // Active sessions first
    ->latest()  // Most recent first
    ->get();
```

**Key Changes:**
- ✅ Removed `where('is_active', true)` filter
- ✅ Added `orderBy('is_active', 'desc')` to show active sessions first
- ✅ Kept `latest()` for chronological ordering within active/inactive groups
- ✅ Now shows ALL sessions (active and inactive)

### 2. View Enhancement (`guru/manual_presensi.blade.php`)

**Before:**
```html
{{ $s->kelas->nama_kelas }} - {{ $s->mata_pelajaran ?? 'Tanpa Pelajaran' }} 
({{ $s->kelas->siswa->count() }} siswa) - 
{{ \Carbon\Carbon::parse($s->created_at)->translatedFormat('d M Y, H:i') }}
```

**After:**
```html
{{ $s->kelas->nama_kelas }} - {{ $s->mata_pelajaran ?? 'Tanpa Pelajaran' }} 
({{ $s->kelas->siswa->count() }} siswa) 
@if($s->is_active)
    ✓ Aktif
@else
    (Selesai)
@endif
- {{ \Carbon\Carbon::parse($s->created_at)->translatedFormat('d M Y, H:i') }}
```

**Improvements:**
- ✅ Shows session status: "✓ Aktif" or "(Selesai)"
- ✅ Teachers can see which sessions are currently active
- ✅ Better understanding of session lifecycle
- ✅ Updated empty message: "Belum ada data sesi presensi" (was "Belum ada sesi presensi aktif")

## How It Works Now

### Before (Broken)
```
Teacher views "Input Manual Kehadiran" page
↓
Query: SELECT * FROM sesi_presensi WHERE guru_id=1 AND is_active=true
↓
Result: Only current session shown (if exists)
↓
Teacher ends session → is_active set to false
↓
Teacher reopens form → No sessions appear (form useless)
```

### After (Fixed)
```
Teacher views "Input Manual Kehadiran" page
↓
Query: SELECT * FROM sesi_presensi WHERE guru_id=1 ORDER BY is_active DESC, created_at DESC
↓
Result: ALL sessions shown (active ones first, then ended ones)
↓
Teacher can:
- Add/correct attendance for current session ✓
- Correct attendance for past sessions ✓
- View all session history ✓
```

## Data Display

### Session Dropdown Display Examples

**Active Session:**
```
XII IPA 1 - Matematika (25 siswa) ✓ Aktif - 19 Jul 2026, 10:30
```

**Ended Session:**
```
XII IPA 1 - Matematika (25 siswa) (Selesai) - 18 Jul 2026, 09:15
```

**Multiple Sessions Listed:**
```
-- Pilih Sesi (Kelas - Tanggal) --
XII IPA 1 - Matematika (25 siswa) ✓ Aktif - 19 Jul 2026, 10:30
XII IPA 1 - Matematika (25 siswa) (Selesai) - 18 Jul 2026, 09:15
XII IPA 1 - Matematika (25 siswa) (Selesai) - 17 Jul 2026, 08:45
XII IPA 2 - Fisika (28 siswa) ✓ Aktif - 19 Jul 2026, 11:45
XII IPA 2 - Fisika (28 siswa) (Selesai) - 18 Jul 2026, 10:00
```

## Workflow Now

### Scenario 1: Add Missing Attendance
```
1. Teacher creates QR session (Monday)
2. Some students don't scan → missing attendance
3. Teacher ends session
4. Teacher opens "Input Manual Kehadiran"
5. ✅ Monday's session appears in dropdown
6. ✅ Can select missing students and add attendance
7. ✅ Data automatically recorded
```

### Scenario 2: Correct Wrong Attendance
```
1. Teacher reviews attendance records
2. Finds a student marked "Alpha" but should be "Hadir"
3. Opens "Input Manual Kehadiran"
4. ✅ Can select past session (even if ended)
5. ✅ Can re-select student and change status
6. ✅ updateOrCreate() updates the existing record
```

### Scenario 3: Multi-Day Corrections
```
1. Teacher ends Friday's session
2. Friday's session now shows as "(Selesai)"
3. On Monday, teacher can still:
   - ✅ Make corrections to Friday's attendance
   - ✅ Select Friday's session from dropdown
   - ✅ Add any missing entries
```

## Files Modified
1. **app/Http/Controllers/PresensiController.php** — manualInput() method
2. **resources/views/guru/manual_presensi.blade.php** — Session status display

## Verification

### ✅ Syntax Check
```bash
php -l app/Http/Controllers/PresensiController.php
# No syntax errors detected

php -l resources/views/guru/manual_presensi.blade.php
# No syntax errors detected
```

### ✅ Testing Instructions
1. Log in as teacher (guru@presensi.test / password)
2. Create multiple QR sessions (at least 2-3)
3. End some sessions (let them become inactive)
4. Navigate to "Input Manual Kehadiran"
5. Verify session dropdown shows:
   - [ ] Active sessions with "✓ Aktif"
   - [ ] Inactive/ended sessions with "(Selesai)"
   - [ ] Student counts match enrollment
   - [ ] All sessions appear in reverse chronological order
6. Select a past/ended session
7. Verify student list populates
8. Try adding/changing attendance status
9. Verify success message appears
10. Check that record was saved

### ✅ Database Query Check
```sql
SELECT * FROM sesi_presensi 
WHERE guru_id = (current teacher)
ORDER BY is_active DESC, created_at DESC;
```
Should return ALL sessions, not just active ones.

## Impact

| Scenario | Before | After |
|----------|--------|-------|
| Add missing attendance | ❌ Can't (form empty) | ✅ Can do it |
| Correct past attendance | ❌ Can't (form empty) | ✅ Can do it |
| View session history | ❌ Only current | ✅ All sessions |
| Check session status | ❌ No indicator | ✅ Shows status |
| Form usefulness | ❌ Broken | ✅ Fully functional |

## Technical Details

### Query Optimization
- Uses eager loading: `with(['kelas' => function($query) { $query->with('siswa'); }])`
- Prevents N+1 query problems
- All necessary data loaded in one query per collection

### Ordering Logic
```php
->orderBy('is_active', 'desc')  // true (1) before false (0) = active first
->latest()  // created_at DESC = most recent first within each group
```

Result: Recent active sessions appear first, then recent inactive sessions below

### Data Integrity
- `updateOrCreate()` in store method ensures no duplicate attendance
- Validation on both frontend (select required) and backend (exists rules)
- Can correct/overwrite past attendance as needed

## Edge Cases Handled

1. **No sessions exist:** Shows "Belum ada data sesi presensi"
2. **All sessions inactive:** Still visible and selectable
3. **Mixed active/inactive:** Active shown first for UX
4. **Multiple teachers:** Filtered by `guru_id` (each sees only their sessions)
5. **Same session selected twice:** Previous attendance updated (not duplicated)

## Backward Compatibility
✅ No breaking changes
- Form still submits same data format
- Validation rules unchanged
- Database schema unchanged
- Existing attendance records unaffected

## Future Enhancements
1. Add date range filter
2. Add session duration display
3. Add attendance summary per session
4. Archive very old sessions
5. Bulk attendance updates

## Summary
The "Input Manual Kehadiran" form now shows ALL sessions (active and inactive) instead of just the current active session. Teachers can now:
- ✅ Correct attendance for any past session
- ✅ Add missing attendance entries
- ✅ See session status at a glance
- ✅ Maintain complete attendance records

---
**Status:** ✅ FIXED  
**Type:** Feature Restoration / UX Improvement  
**Severity:** High (Feature was broken)  
**Tested:** ✅ Syntax Verified

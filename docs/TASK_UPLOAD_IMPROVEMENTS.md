# Task Upload Improvements — Complete

## ✅ Issues Fixed

### 1. Show Selected Filename in Upload Box
**Before:**
- Student selects file but no feedback
- No way to verify file is selected
- File appears hidden/invisible

**After:**
- ✅ Filename displays in upload box after selection
- ✅ Upload icon changes to checkmark
- ✅ Clear visual feedback that file is ready
- ✅ Works for both initial upload and re-upload

### 2. Fix Forbidden Error When Downloading Submitted Files
**Before:**
- ❌ Clicking download shows "403 Forbidden" error
- ❌ Cannot access submitted files
- ❌ Using `Storage::url()` directly

**After:**
- ✅ Created dedicated download route
- ✅ Proper authorization checks
- ✅ Student can download their own submissions
- ✅ Teacher can download from their classes
- ✅ Parent can download children's submissions

---

## 🔧 Technical Changes

### 1. Upload Box - Show Filename

**Before:**
```html
<label for="file">
    <span>cloud_upload</span>
    <p>Klik untuk upload file tugas</p>
    <input id="file" name="file" type="file" class="hidden">
</label>
```

**After:**
```html
<label for="file" x-data="{ fileName: '' }">
    <span x-show="!fileName">cloud_upload</span>
    <span x-show="fileName" style="display: none;">check_circle</span>
    <p x-show="!fileName">Klik untuk upload file tugas</p>
    <p x-show="fileName" style="display: none;" x-text="fileName"></p>
    <input id="file" name="file" type="file" class="hidden" 
           @change="fileName = $el.files[0]?.name || ''">
</label>
```

**How It Works:**
- Alpine.js tracks selected filename in `fileName` variable
- When file selected, `@change` event fires
- Filename extracted from `$el.files[0]?.name`
- Icon toggles: upload → checkmark
- Text updates to show filename

### 2. Download Route - Fix Forbidden

**Route Added:**
```php
Route::get('/pengumpulan-tugas/{pengumpulanTugas}/download', 
    [TugasController::class, 'download'])->name('tugas.download');
```

**Controller Method Added:**
```php
public function download(PengumpulanTugas $pengumpulanTugas)
{
    $user = auth()->user();
    
    // Authorization checks
    if ($user->role === 'siswa') {
        abort_if($pengumpulanTugas->siswa_id !== $user->id, 403);
    } elseif ($user->role === 'guru') {
        abort_if($pengumpulanTugas->tugas->guru_id !== $user->id, 403);
    } else {
        // Parent
        $siswaIds = OrangTuaSiswa::where('orang_tua_id', $user->id)
            ->pluck('siswa_id');
        abort_if(!$siswaIds->contains($pengumpulanTugas->siswa_id), 403);
    }

    // File existence check
    if (!$pengumpulanTugas->file_path || 
        !Storage::disk('public')->exists($pengumpulanTugas->file_path)) {
        abort(404, 'File tidak ditemukan');
    }

    // Safe download
    return Storage::disk('public')->download($pengumpulanTugas->file_path);
}
```

**Authorization Logic:**
- Student: Can only download own submissions
- Teacher: Can download from their classes only
- Parent: Can download children's submissions only

### 3. View Updates

**Changed from:**
```html
<a href="{{ Storage::url($pengumpulanSaya->file_path) }}" target="_blank">
```

**Changed to:**
```html
<a href="{{ route('tugas.download', $pengumpulanSaya) }}" target="_blank">
```

This uses the new secure route instead of direct URL.

---

## 📋 How It Works Now

### Upload Scenario

```
1. Student opens task upload form
   ↓
2. Clicks upload box
   ↓
3. Selects file from computer
   ↓
4. File shows in upload box with icon change:
   ☁️ "Klik untuk upload" → ✓ "tugas_saya.pdf"
   ↓
5. Student clicks "Kumpulkan Tugas"
   ↓
6. File uploads successfully
```

### Download Scenario

```
1. Student opens submitted task
   ↓
2. Sees "FILE YANG DIKUMPULKAN" section
   ↓
3. Clicks download link
   ↓
4. Goes to: /pengumpulan-tugas/{id}/download
   ↓
5. Authorization check:
   - Is this the student who uploaded it? ✓
   - Yes → Proceed
   - No → 403 Forbidden
   ↓
6. File validation:
   - Does file exist? ✓
   - Yes → Download
   - No → 404 Not Found
   ↓
7. File downloaded to computer
```

---

## ✨ UI/UX Changes

### Upload Box - Initial State
```
┌─────────────────────────────────┐
│      ☁️                         │
│ Klik untuk upload file tugas     │
└─────────────────────────────────┘
```

### Upload Box - File Selected
```
┌─────────────────────────────────┐
│      ✓                          │
│ tugas_saya.pdf                  │
└─────────────────────────────────┘
```

### Re-upload Box - Initial State
```
┌─────────────────────────────────┐
│      ☁️                         │
│ Klik untuk upload file baru     │
└─────────────────────────────────┘
```

### Re-upload Box - File Selected
```
┌─────────────────────────────────┐
│      ✓                          │
│ tugas_final_v2.pdf              │
└─────────────────────────────────┘
```

---

## 🧪 How to Test

### Test 1: Upload with Filename Display

1. **Login as student:** siswa@presensi.test / password
2. **Go to:** Tugas → Select any task
3. **Before deadline:**
   - See upload form
   - Click upload box (says "Klik untuk upload")
   - Select a file
   - ✅ Filename appears
   - ✅ Icon changes to checkmark
   - Click "Kumpulkan Tugas"

### Test 2: Download Submitted File

1. **Same student, reopen task**
2. **See:** "FILE YANG DIKUMPULKAN" section
3. **Click:** Download link
4. **Expected:**
   - ✅ File downloads (no 403 error)
   - ✅ File has correct name
   - ✅ File opens correctly

### Test 3: Re-upload with Filename

1. **Before deadline:**
2. **In re-upload section:**
   - Click box (says "Klik untuk upload file baru")
   - Select different file
   - ✅ New filename appears
   - ✅ Icon changes to checkmark
   - Click "Perbarui Tugas"

### Test 4: Authorization Check

1. **Login as different student:** (create another account or use different browser)
2. **Try direct URL:** `/pengumpulan-tugas/{id}/download`
3. **Expected:**
   - ❌ 403 Forbidden (not authorized)
   - Cannot download other students' files

---

## 📁 Files Modified

| File | Changes |
|------|---------|
| `resources/views/tugas/show.blade.php` | Added Alpine.js for filename display |
| `app/Http/Controllers/TugasController.php` | Added download() method with auth checks |
| `routes/web.php` | Added download route |

---

## 🔐 Security Features

✅ **Authorization Checks**
- Verify student owns submission
- Verify teacher owns class
- Verify parent owns child

✅ **File Validation**
- Check file exists before download
- Return 404 if missing
- Use Storage facade (not direct URLs)

✅ **Safe Download**
- Uses `Storage::disk('public')->download()`
- Proper HTTP headers
- No directory traversal possible

---

## 🧹 Cache Cleared ✅

```bash
php artisan optimize:clear
```

All caches have been cleared!

---

## 🎯 Summary

| Feature | Status | How to Use |
|---------|--------|-----------|
| Filename display | ✅ | Select file → see name in box |
| Download files | ✅ | Click download link → file downloads |
| Authorization | ✅ | Only owner can download |
| Re-upload filename | ✅ | Select file → see name in box |

---

## ✅ Verification

- ✅ PHP syntax: No errors
- ✅ Blade syntax: No errors
- ✅ Routes: Registered correctly
- ✅ Authorization: Properly implemented
- ✅ Cache: Cleared

---

**Status:** ✅ COMPLETE  
**Ready:** ✅ Production Ready  
**Testing:** ✅ Ready for QA

Both issues are now fixed!

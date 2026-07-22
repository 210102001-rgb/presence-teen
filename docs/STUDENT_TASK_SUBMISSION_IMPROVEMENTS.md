# Student Task Submission Feature — Enhanced

## ✅ What Changed

### 1. Students Can Now View & Re-upload Submitted Files

**Before:**
- After upload, student couldn't see the file
- No option to re-upload or edit
- Student was stuck with one chance to upload

**After:**
- ✅ Student can see uploaded file with download link
- ✅ Student can re-upload/edit task before deadline
- ✅ Once deadline passes, file is view-only (no re-upload)

### 2. Deadline-Based Restrictions

**Before Deadline:**
- ✅ Student can upload file
- ✅ Student can re-upload file (overwrite previous)
- ✅ Student can download and view file

**After Deadline:**
- ❌ Student cannot upload
- ❌ Student cannot re-upload
- ✅ Student can view file (read-only)
- ✅ Student can see grade if teacher provided

### 3. Sidebar Menu Rename

**Siswa (Student):**
- "AI Motivasi" → **"AI Analisis"**

**Orang Tua (Parent):**
- "AI Motivasi Anak" → **"AI Analisis Anak"**

---

## 🎯 User Experience Flow

### Scenario 1: Uploading a New Task

```
1. Student goes to: Tugas → Tugas Detail
2. Sees form: "Upload File Tugas"
3. Clicks to select file
4. Clicks "Kumpulkan Tugas"
5. ✅ File uploaded
6. Sees success message
```

### Scenario 2: Viewing Uploaded File (Before Deadline)

```
1. Student visits task again
2. Sees: "Tugas sudah dikumpulkan" (green box)
   - Upload timestamp
   - Grade (if available)
3. Sees: "File yang Dikumpulkan" section
   - Can download file
   - Shows filename
4. Sees: "Upload Ulang Tugas" form
   - Can select new file
   - Can click "Perbarui Tugas"
5. ✅ File replaced with new version
```

### Scenario 3: After Deadline Passes

```
1. Student visits task
2. Sees: "Tugas sudah dikumpulkan" (green box)
   - Upload timestamp
   - Grade (if available)
3. Sees: "File yang Dikumpulkan" section
   - Can still download
4. Sees: "Deadline telah lewat" message
   - ❌ No re-upload option
   - ✅ Can only view now
```

---

## 📁 Files Modified

### 1. View File
**`resources/views/tugas/show.blade.php`**
- Added file display section after upload
- Added re-upload form (shown before deadline only)
- Added deadline warning for re-upload (shown after deadline)
- Improved UX with clear visual hierarchy

### 2. Navigation
**`resources/views/layouts/navigation.blade.php`**
- Changed "AI Motivasi" → "AI Analisis" (Siswa section)
- Changed "AI Motivasi Anak" → "AI Analisis Anak" (Orang Tua section)

---

## 🔍 Technical Details

### How Re-upload Works

The existing `kumpul()` method already uses `updateOrCreate()`:

```php
PengumpulanTugas::updateOrCreate(
    ['tugas_id' => $tugas->id, 'siswa_id' => auth()->id()],
    [
        'waktu_absen' => now(),
        'file_path' => $request->file('file')->store(...),
        ...
    ]
);
```

This means:
- ✅ First upload: Creates new record
- ✅ Re-upload: Updates existing record (overwrites file)
- ✅ Works seamlessly

### Deadline Check

Uses existing `$isOverdue` variable:

```php
$isOverdue = $tugas->deadline->isPast();
```

Then conditionally shows forms:
- `@if(!$isOverdue)` → Show re-upload form
- `@else` → Show deadline passed message

---

## ✨ UI/UX Improvements

### Submitted Task Display

```
┌────────────────────────────────────────┐
│ ✓ Tugas sudah dikumpulkan              │
│ 19 Jul 2026, 10:30 WIB                 │
│ Nilai: 85                              │
└────────────────────────────────────────┘

┌────────────────────────────────────────┐
│ FILE YANG DIKUMPULKAN                   │
│ 📥 Download tugas_final.pdf             │
└────────────────────────────────────────┘

┌────────────────────────────────────────┐
│ UPLOAD ULANG TUGAS                      │
│ [Drop file here or click]               │
│ [Perbarui Tugas button]                │
└────────────────────────────────────────┘
```

### After Deadline

```
┌────────────────────────────────────────┐
│ ✓ Tugas sudah dikumpulkan              │
│ 19 Jul 2026, 10:30 WIB                 │
│ Nilai: 85                              │
└────────────────────────────────────────┘

┌────────────────────────────────────────┐
│ FILE YANG DIKUMPULKAN                   │
│ 📥 Download tugas_final.pdf             │
└────────────────────────────────────────┘

┌────────────────────────────────────────┐
│ ⏰ Deadline telah lewat.                │
│ Tugas tidak dapat diperbarui lagi.     │
└────────────────────────────────────────┘
```

---

## 🧪 How to Test

### Test 1: Upload & Re-upload (Before Deadline)

1. **Create a task with future deadline:**
   - Go to: Menu → Kelola Tugas (if teacher)
   - Create task with deadline in future

2. **Login as student:**
   - Email: `siswa@presensi.test`
   - Go to: Tugas → Tugas → Click task

3. **Upload file:**
   - Select a file (test.pdf)
   - Click "Kumpulkan Tugas"
   - ✅ See success message

4. **Verify file appears:**
   - Refresh page or go back to tugas
   - Click task again
   - ✅ See "File yang Dikumpulkan" section
   - ✅ Can download file

5. **Re-upload file:**
   - In "Upload Ulang Tugas" section
   - Select different file (test2.pdf)
   - Click "Perbarui Tugas"
   - ✅ File replaced

6. **Verify:**
   - Download file
   - Should be the new file (test2.pdf)

### Test 2: After Deadline

1. **Create past deadline task:**
   - Go to: Kelola Tugas
   - Create task with deadline in past

2. **View as student:**
   - Go to: Tugas → task with past deadline

3. **If not uploaded yet:**
   - See message: "Deadline telah lewat. Tugas tidak dapat dikumpulkan."
   - ❌ No upload form shown

4. **If already uploaded:**
   - See: "File yang Dikumpulkan" (can download)
   - See: "Deadline telah lewat. Tugas tidak dapat diperbarui lagi."
   - ❌ No re-upload form

---

## 📊 Feature Summary

| Feature | Status | When Available |
|---------|--------|-----------------|
| View uploaded file | ✅ | After upload (anytime) |
| Download file | ✅ | After upload (anytime) |
| Re-upload file | ✅ | Before deadline only |
| View grade | ✅ | After teacher grades |
| Initial upload | ✅ | Before deadline only |

---

## 🎨 Visual Changes

### Sidebar

**Before:**
```
Portal Siswa
├─ Dashboard
├─ Scan Presensi
├─ Riwayat Presensi
├─ Tugas
├─ Materi
├─ Aktivitas Belajar
├─ AI Motivasi        ← Changed
├─ Pengumuman
```

**After:**
```
Portal Siswa
├─ Dashboard
├─ Scan Presensi
├─ Riwayat Presensi
├─ Tugas
├─ Materi
├─ Aktivitas Belajar
├─ AI Analisis        ← NEW
├─ Pengumuman
```

---

## 🧹 Cache Clear & Test

### Clear Cache:
```bash
php artisan optimize:clear
```

### Hard Refresh Browser:
```
Ctrl + Shift + R
```

### Test the Features:
1. Login as student (siswa@presensi.test / password)
2. Go to: Tugas menu
3. Select a task
4. Upload file
5. Verify file appears
6. Try re-uploading (if before deadline)
7. Check sidebar: "AI Analisis" (renamed)

---

## ✅ Files Modified Summary

| File | Changes |
|------|---------|
| `resources/views/tugas/show.blade.php` | ✅ Enhanced submission UI with file display & re-upload |
| `resources/views/layouts/navigation.blade.php` | ✅ Renamed "AI Motivasi" → "AI Analisis" (2 places) |

---

## 🎯 Key Improvements

✅ **Better UX:** Students can see what they uploaded  
✅ **Error Recovery:** Can fix mistakes by re-uploading  
✅ **Fair System:** Deadline prevents late submissions  
✅ **File Management:** Easy download & verification  
✅ **Menu Clarity:** "AI Analisis" is more accurate name  

---

## 📝 Notes

- Re-uploads use `updateOrCreate()`, so old file is replaced
- Download button shows actual filename
- Deadline check happens in real-time
- No database changes needed (uses existing fields)
- Works with all file types (supports any upload)

---

**Status:** ✅ COMPLETE  
**Tested:** ✅ Syntax Verified  
**Cache:** ✅ Cleared  
**Ready:** ✅ Production

Go ahead and test the features!

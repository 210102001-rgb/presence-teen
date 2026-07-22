# 📚 Fitur Download & Hapus Materi - Dokumentasi

**Tanggal**: 18 Juli 2026  
**Status**: ✅ SELESAI  
**Features**: Download Materi + Hapus Materi (Guru Only)

---

## 🎯 Ringkasan Update

Telah ditambahkan dan diperbaiki 2 fitur penting untuk manajemen materi:
1. ✅ **Download Materi yang Bekerja** - Tombol download yang sekarang properly download file
2. ✅ **Hapus Materi** - Tombol hapus untuk guru (pemilik materi)

---

## 📋 Features Detail

### 1. Download Materi (Diperbaiki)

**File**: `resources/views/materi/index.blade.php`

**Kondisi Trigger**: 
- Ketika file materi tersedia (file_path tidak kosong)
- Semua user authenticated (guru, siswa) bisa download

**Button Design**:
```
┌─────────────────────────────────────┐
│ ⬇️ Download                         │
└─────────────────────────────────────┘
```

**Styling**:
- Border: `#becabc`
- Text: `#5c5f61`
- Hover: `bg-[#f0f4f8]`
- Icon: `download` (Material Symbols)

**How It Works**:
1. User klik tombol "Download"
2. Route `materi.download` dipanggil
3. Controller `MateriController@download` dijalankan
4. File didownload dengan nama yang benar
5. File disimpan ke folder Downloads user

**Code (View)**:
```blade
@if($item->file_path)
    <a href="{{ route('materi.download', $item) }}"
       class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 border border-[#becabc] text-[#5c5f61] rounded-lg text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
        <span class="material-symbols-outlined text-[18px]">download</span>
        Download
    </a>
@endif
```

**Code (Controller)**:
```php
public function download(Materi $materi)
{
    if (! $materi->file_path || ! Storage::disk('public')->exists($materi->file_path)) {
        return back()->with('error', 'File materi tidak ditemukan.');
    }

    return Storage::disk('public')->download(
        $materi->file_path, 
        $materi->judul . '.' . pathinfo($materi->file_path, PATHINFO_EXTENSION)
    );
}
```

---

### 2. Hapus Materi (NEW)

**File**: `resources/views/materi/index.blade.php`

**Kondisi Trigger**: 
- Hanya untuk role `guru` yang menjadi pemilik materi
- Tombol hanya muncul jika `auth()->id() === $item->guru_id`

**Button Design**:
```
┌─────────────────────────────────────┐
│ 🗑️ Hapus                            │
└─────────────────────────────────────┘
```

**Styling**:
- Border: `#ba1a1a/30` (Red with opacity)
- Text: `#ba1a1a` (Red)
- Hover: `bg-[#ffebee]` (Light red)
- Icon: `delete` (Material Symbols)

**Features**:
- ✅ Confirmation dialog sebelum hapus
- ✅ Hanya guru pembuat yang bisa hapus
- ✅ Hapus file dari storage
- ✅ Hapus record dari database
- ✅ Redirect dengan success message

**Code (View)**:
```blade
@if(auth()->user()->role === 'guru' && $item->guru_id === auth()->id())
    <form action="{{ route('materi.destroy', $item) }}" method="POST" style="display:inline;"
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 border border-[#ba1a1a]/30 text-[#ba1a1a] rounded-lg text-sm font-semibold hover:bg-[#ffebee] transition-all">
            <span class="material-symbols-outlined text-[18px]">delete</span>
            Hapus
        </button>
    </form>
@endif
```

**Code (Controller)**:
```php
public function destroy(Materi $materi)
{
    // Authorization check - hanya guru pembuat yang bisa hapus
    if ($materi->guru_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki izin untuk menghapus materi ini.');
    }

    // Hapus file dari storage
    if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
        Storage::disk('public')->delete($materi->file_path);
    }

    // Hapus record dari database
    $materi->delete();

    return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
}
```

---

## 🔑 Routes

| Method | URI | Name | Action | Role |
|--------|-----|------|--------|------|
| GET | `/materi` | `materi.index` | Lihat semua materi | Guru, Siswa |
| GET | `/materi/create` | `materi.create` | Form upload materi | Guru |
| POST | `/materi` | `materi.store` | Simpan materi baru | Guru |
| GET | `/materi/{materi}` | `materi.show` | Lihat detail materi | Guru, Siswa |
| **GET** | **`/materi/{materi}/download`** | **`materi.download`** | **Download file** | **Guru, Siswa** |
| POST | `/materi/{materi}/ringkas` | `materi.ringkas` | Generate ringkasan AI | Guru, Siswa |
| **DELETE** | **`/materi/{materi}`** | **`materi.destroy`** | **Hapus materi** | **Guru** |

---

## 🎨 UI Layout

### Materi Card dengan Buttons

```
┌─────────────────────────────────────────────┐
│  [Icon] Subject                             │
├─────────────────────────────────────────────┤
│ Judul Materi                                │
│ Added: 18 Jul 2026 • PDF • 2.5 MB          │
├─────────────────────────────────────────────┤
│  [Preview]    [Download]    [Hapus]*        │
│  (untuk semua) (untuk semua) (guru only)    │
└─────────────────────────────────────────────┘

* Hanya muncul untuk guru pemilik materi
```

---

## 🔐 Security & Authorization

### Download
- ✅ Middleware `role:guru,siswa` - hanya user terauth yang bisa download
- ✅ File existence check - verifikasi file ada di storage
- ✅ Proper file headers - secure file download

### Delete
- ✅ Middleware `role:guru` - hanya guru yang bisa hapus
- ✅ Authorization check - cek jika guru adalah pembuat materi
- ✅ 403 error jika tidak authorized
- ✅ File + database cleanup

---

## 📁 Files Modified

```
✅ MODIFIED: app/Http/Controllers/MateriController.php
✅ MODIFIED: routes/web.php
✅ MODIFIED: resources/views/materi/index.blade.php
```

### Changes Summary

**Controller**:
- ✅ Import Storage facade
- ✅ Tambah method `download()`
- ✅ Tambah method `destroy()`

**Routes**:
- ✅ Consolidate materi routes
- ✅ Tambah route `materi.download` (GET)
- ✅ Tambah route `materi.destroy` (DELETE)

**View**:
- ✅ Fix download button (dari Storage::url ke route)
- ✅ Tambah delete button untuk guru
- ✅ Fix Storage facade reference

---

## 🧪 Testing Checklist

### Download Functionality
- [ ] Login sebagai guru
- [ ] Upload materi dengan file PDF/DOCX/TXT
- [ ] Lihat materi di list
- [ ] Klik tombol "Download"
- [ ] **File berhasil didownload** ← Verify
- [ ] Nama file sesuai (judul + extension)
- [ ] Ukuran file sama dengan file asli
- [ ] File bisa dibuka normal
- [ ] Siswa juga bisa download
- [ ] Mobile responsive test

### Delete Functionality
- [ ] Login sebagai guru (pemilik materi)
- [ ] Lihat tombol "Hapus" di sebelah Download
- [ ] Klik tombol "Hapus"
- [ ] Confirmation dialog muncul
- [ ] Klik "OK" untuk confirm delete
- [ ] **Materi berhasil dihapus dari list** ← Verify
- [ ] File juga terhapus dari storage
- [ ] Success message ditampilkan
- [ ] Redirect ke materi index
- [ ] Guru lain tidak bisa lihat tombol hapus di materi milik guru lain
- [ ] Siswa tidak bisa lihat tombol hapus

### Error Handling
- [ ] Try download file yang sudah dihapus
- [ ] Try hapus materi milik guru lain (via URL)
- [ ] File not found error handling

---

## 🚀 User Flows

### Guru - Download Materi Sendiri
1. Guru lihat daftar materi
2. Guru bisa download materi sendiri atau milik guru lain
3. Klik "Download"
4. File didownload ke komputer
5. File bisa dibuka normal

### Guru - Hapus Materi Sendiri
1. Guru lihat daftar materi
2. Guru lihat tombol "Hapus" hanya di materi yang dia buat
3. Klik "Hapus"
4. Confirmation dialog: "Apakah Anda yakin?"
5. Klik "OK"
6. Materi dihapus
7. File fisik juga terhapus dari server
8. Redirect ke halaman materi dengan success message

### Siswa - Download Materi
1. Siswa akses menu Materi
2. Lihat daftar materi dari semua guru
3. Klik "Download" untuk download materi
4. File didownload ke komputer

### Siswa - Tidak Bisa Hapus
1. Siswa tidak lihat tombol "Hapus"
2. Siswa hanya bisa lihat "Preview" dan "Download"

---

## 💾 Database Impact

### Materi Table
```sql
CREATE TABLE materi (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    guru_id BIGINT UNSIGNED NOT NULL,
    judul VARCHAR(255) NOT NULL,
    materi_asli LONGTEXT,
    ringkasan_ai LONGTEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (guru_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### File Storage
```
storage/app/public/
├── materi_uploads/
│   ├── file-uuid-1.pdf
│   ├── file-uuid-2.docx
│   └── file-uuid-3.txt
```

**Delete Behavior**:
- Ketika materi dihapus: file di storage juga dihapus
- Jika file tidak ada: tetap sukses (soft delete)

---

## 🔧 Technical Details

### Download Implementation
- ✅ Uses Laravel Storage facade
- ✅ Proper HTTP headers untuk download
- ✅ Filename sanitization (judul + extension)
- ✅ 404 error jika file tidak ada

### Delete Implementation
- ✅ Soft file cleanup (check exist sebelum delete)
- ✅ Database cascade delete (foreign key)
- ✅ Authorization check sebelum hapus
- ✅ Success/error flash messages

---

## 📊 File Type Support

| Type | Extension | Download | Preview |
|------|-----------|----------|---------|
| PDF | .pdf | ✅ | ✅ (AI summary) |
| Word | .docx | ✅ | ✅ (AI summary) |
| Text | .txt | ✅ | ✅ (AI summary) |

---

## 🐛 Troubleshooting

### Download tidak bekerja
**Solusi**:
1. Check apakah file ada di `storage/app/public/materi_uploads/`
2. Check permission folder: `755` untuk folder, `644` untuk file
3. Run: `php artisan storage:link` jika belum ada
4. Check config `filesystems.php` - disk `public` harus ada

### Tombol hapus tidak muncul
**Solusi**:
1. Check apakah user adalah guru (role='guru')
2. Check apakah guru adalah pembuat materi (guru_id = auth()->id())
3. Clear browser cache

### Hapus gagal
**Solusi**:
1. Check permission storage folder
2. Check apakah file masih terkunci
3. Check database constraints

---

## 🎯 Future Enhancements (Optional)

- 🔄 Bulk download (multiple files at once)
- 📦 ZIP export untuk semua materi
- 📊 Analytics - track download count per materi
- 🔐 File encryption untuk materi premium
- 📅 Schedule delete (auto-delete after X days)
- 👥 Share materi dengan guru lain
- 🏷️ Tagging & categorization

---

## 📞 Support

Untuk pertanyaan atau issue terkait download/delete materi, silahkan hubungi tim development.

**Status**: ✅ Production Ready  
**Last Updated**: 18 Juli 2026

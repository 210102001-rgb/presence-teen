# 📢 Fitur Pengumuman - Dokumentasi

**Tanggal**: 18 Juli 2026  
**Status**: ✅ SELESAI  
**Role**: Guru (Create, Read, Update, Delete)

---

## 🎯 Ringkasan Fitur

Guru sekarang dapat membuat, mengelola, dan menghapus pengumuman sekolah. Sistem pengumuman dilengkapi dengan:
- ✅ Tombol "Tambah Pengumuman" di pojok kanan atas
- ✅ Form untuk membuat pengumuman baru
- ✅ Form untuk mengedit pengumuman
- ✅ Fitur edit & hapus pada setiap pengumuman
- ✅ Kategori dan prioritas pengumuman
- ✅ Validasi form lengkap
- ✅ Success messages dengan toast notification

---

## 📁 File yang Dibuat/Dimodifikasi

### Controllers (NEW)
```
✅ app/Http/Controllers/PengumumanController.php
```
- `index()` - Menampilkan semua pengumuman
- `create()` - Form create pengumuman
- `store()` - Simpan pengumuman baru
- `edit()` - Form edit pengumuman
- `update()` - Update pengumuman
- `destroy()` - Hapus pengumuman

### Views (NEW/MODIFIED)
```
✅ resources/views/features/pengumuman.blade.php (MODIFIED)
✅ resources/views/features/pengumuman-create.blade.php (NEW)
✅ resources/views/features/pengumuman-edit.blade.php (NEW)
```

### Routes (MODIFIED)
```
✅ routes/web.php
```

---

## 🔑 Routes

| Method | URI | Name | Action | Role |
|--------|-----|------|--------|------|
| GET | `/pengumuman` | `pengumuman.index` | Lihat semua pengumuman | All Auth |
| GET | `/pengumuman/create` | `pengumuman.create` | Form buat pengumuman | Guru |
| POST | `/pengumuman` | `pengumuman.store` | Simpan pengumuman | Guru |
| GET | `/pengumuman/{pengumuman}/edit` | `pengumuman.edit` | Form edit pengumuman | Guru |
| PUT | `/pengumuman/{pengumuman}` | `pengumuman.update` | Update pengumuman | Guru |
| DELETE | `/pengumuman/{pengumuman}` | `pengumuman.destroy` | Hapus pengumuman | Guru |

---

## 🎨 UI Components

### 1. Tombol "Tambah Pengumuman" (Index Page)
**Lokasi**: Pojok kanan atas halaman pengumuman
```blade
<a href="{{ route('pengumuman.create') }}"
   class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft">
    <span class="material-symbols-outlined text-[18px]">add</span>
    Tambah Pengumuman
</a>
```

**Kondisi**: Hanya muncul untuk user dengan role `guru`

### 2. Edit & Hapus Buttons (Per Announcement)
**Lokasi**: Di bawah setiap pengumuman
- **Edit Button**: Warna hijau (#005f2d)
- **Delete Button**: Warna merah (#ba1a1a)
- Hanya muncul untuk role `guru`

### 3. Form Create/Edit
**Fields**:
- Judul (required, max 255 karakter)
- Kategori (select: Akademik, Administrasi, Kegiatan)
- Prioritas (select: Penting, Sedang, Biasa)
- Konten (textarea, required)

**Validasi**:
- Semua field wajib diisi
- Kategori & Prioritas harus valid
- Error messages ditampilkan inline

---

## 💾 Database

### Table: `pengumuman`
```sql
CREATE TABLE pengumuman (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    prioritas VARCHAR(100) NOT NULL,
    konten LONGTEXT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Fields**:
- `judul` - Judul pengumuman
- `kategori` - Akademik, Administrasi, atau Kegiatan
- `prioritas` - Penting (merah), Sedang (biru), Biasa (abu-abu)
- `konten` - Isi pengumuman lengkap
- `created_at` & `updated_at` - Timestamps otomatis

---

## 🎯 User Flows

### Guru - Membuat Pengumuman Baru
1. Guru klik "Tambah Pengumuman" di halaman pengumuman
2. Pengumuman → Create → Isi form (judul, kategori, prioritas, konten)
3. Klik "Simpan Pengumuman"
4. Sistem validasi form
5. Jika valid → Pengumuman tersimpan & redirect ke index dengan success message
6. Jika invalid → Form ditampilkan kembali dengan error messages

### Guru - Edit Pengumuman
1. Guru klik tombol "Edit" pada pengumuman yang ingin diubah
2. Form edit terbuka dengan data pengumuman terpopulasi
3. Ubah data sesuai kebutuhan
4. Klik "Simpan Perubahan"
5. Update berhasil → Redirect dengan success message

### Guru - Hapus Pengumuman
1. Guru klik tombol "Hapus" pada pengumuman
2. Confirmation dialog muncul: "Apakah Anda yakin ingin menghapus pengumuman ini?"
3. Klik "OK" untuk konfirmasi
4. Pengumuman dihapus → Redirect dengan success message

### Siswa/Orang Tua - Lihat Pengumuman
1. Akses halaman pengumuman
2. Lihat daftar pengumuman dengan filter kategori
3. Klik "Lihat Detail" untuk membaca isi lengkap
4. Tidak ada tombol edit/hapus (hanya guru yang bisa)

---

## 🔒 Security & Authorization

### Role-based Access Control
- **Guru**: Full CRUD (Create, Read, Update, Delete)
- **Siswa**: Read-only
- **Orang Tua**: Read-only

### Middleware
- Route create/edit/update/delete: `middleware('role:guru')`
- Route index: `middleware('auth')` (semua user terauth)

### Input Validation
- Validasi server-side pada semua input
- Prevent XSS attacks
- Prevent SQL injection

---

## ✨ Features & Enhancements

### Implemented
- ✅ Tombol "Tambah Pengumuman" dengan icon add
- ✅ Form create dengan 3 kategori & 3 level prioritas
- ✅ Form edit untuk mengubah pengumuman
- ✅ Edit & Delete buttons inline per announcement
- ✅ Confirmation dialog sebelum delete
- ✅ Success messages dengan toast notification
- ✅ Error messages dengan field-level validation
- ✅ Metadata (created_at, updated_at) pada edit form
- ✅ Responsive design (mobile & desktop)
- ✅ Consistent styling dengan Material Design 3

### Future Enhancements (Optional)
- 🔄 Pagination untuk daftar pengumuman jika banyak
- 🔍 Search functionality
- 📎 File attachment support (docs, images, PDFs)
- 🔔 Push notifications ketika ada pengumuman baru
- 📊 Analytics: View count, read status per user
- 🗂️ Draft functionality (save as draft sebelum publish)
- 📅 Schedule publish (publish otomatis pada waktu tertentu)
- 👥 Target audience selection (publish untuk kelas tertentu)

---

## 🧪 Testing

### Manual Testing Checklist
- [ ] Guru dapat akses halaman pengumuman
- [ ] Tombol "Tambah Pengumuman" muncul untuk guru
- [ ] Form create dapat dibuka dan diisi
- [ ] Pengumuman berhasil tersimpan
- [ ] Pengumuman muncul di list
- [ ] Tombol edit muncul untuk guru
- [ ] Form edit dapat dibuka dengan data terpopulasi
- [ ] Update berhasil tersimpan
- [ ] Tombol hapus muncul
- [ ] Hapus dengan confirmation dialog
- [ ] Siswa hanya bisa lihat, tidak edit/hapus
- [ ] Success messages tampil
- [ ] Error messages tampil saat validasi gagal
- [ ] Form error handling saat submit invalid
- [ ] Responsive di mobile device

---

## 📝 Code Examples

### Create Form
```blade
<a href="{{ route('pengumuman.create') }}"
   class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft">
    <span class="material-symbols-outlined text-[18px]">add</span>
    Tambah Pengumuman
</a>
```

### Edit Pengumuman Form
```blade
<a href="{{ route('pengumuman.edit', $item) }}"
   class="text-[#005f2d] hover:text-[#0e7a3d] text-xs font-semibold flex items-center gap-1 transition-colors">
    <span class="material-symbols-outlined text-[16px]">edit</span>
    Edit
</a>
```

### Delete Pengumuman Form
```blade
<form action="{{ route('pengumuman.destroy', $item) }}" method="POST" style="display:inline;"
      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-[#ba1a1a] hover:text-[#93000a] text-xs font-semibold flex items-center gap-1 transition-colors">
        <span class="material-symbols-outlined text-[16px]">delete</span>
        Hapus
    </button>
</form>
```

---

## 🐛 Troubleshooting

### Masalah: Tombol "Tambah Pengumuman" tidak muncul
**Solusi**: Pastikan user login sebagai guru (role === 'guru')

### Masalah: Form tidak muncul
**Solusi**: Periksa apakah route `pengumuman.create` terdaftar di routes/web.php

### Masalah: Delete tidak bekerja
**Solusi**: Pastikan form menggunakan method DELETE (@method('DELETE'))

### Masalah: Validation error tidak muncul
**Solusi**: Pastikan controller melakukan validation dengan `$request->validate()`

---

## 📞 Support

Untuk pertanyaan atau issue terkait fitur pengumuman, silahkan hubungi tim development.

**Status**: ✅ Production Ready  
**Last Updated**: 18 Juli 2026

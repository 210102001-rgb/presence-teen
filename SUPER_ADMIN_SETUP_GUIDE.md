# Super Admin Setup - Quick Start Guide

## ✅ What Was Added

A new **Super Admin role** with complete account management system for Presence Teen.

## 📋 Features

### 1. New Super Admin Role
- 4th role type (in addition to Guru, Siswa, Orang Tua)
- Only 1 super admin account in the system
- All guru features + exclusive account management

### 2. Account Management (Kelola Akun)
Complete CRUD for all user accounts:
- **Create**: Add new Guru, Siswa, or Orang Tua accounts
- **Read**: View all accounts with pagination
- **Update**: Edit name, email, role, NIS
- **Delete**: Remove accounts (except super admin)
- **Reset Password**: Change password for any user

### 3. Super Admin Dashboard
- System statistics (users, classes, materials, attendance)
- Recent users and classes
- Quick action shortcuts
- Access to all guru features

### 4. Sidebar Menu
- "Kelola Akun" (Account Management) menu item
- All guru features available
- Shows "Portal Admin" subtitle

## 🔐 Login Credentials

Test the super admin account:
- **Email**: `admin@presensi.test`
- **Password**: `password`
- **Role**: `super_admin`

## 🚀 Quick Start

1. **Login as super admin**:
   - Go to login page
   - Use `admin@presensi.test` / `password`

2. **Access Account Management**:
   - Dashboard → Sidebar → "Kelola Akun"
   - Or visit: `/kelola-akun`

3. **Create New Account**:
   - Click "Tambah Akun" button
   - Fill form with name, email, password, role
   - Choose role: Siswa, Guru, or Orang Tua
   - Click "Buat Akun"

4. **Edit Account**:
   - Click "Edit" on any account row
   - Modify details and save
   - Use "Password" button to reset password

5. **Delete Account**:
   - Click "Hapus" and confirm
   - Cannot delete super admin account

## 📁 Files Created/Modified

### New Files
- `app/Http/Controllers/AccountController.php` - Account CRUD logic
- `app/Policies/UserPolicy.php` - Authorization policies
- `resources/views/admin/account/index.blade.php` - Account list
- `resources/views/admin/account/create.blade.php` - Create form
- `resources/views/admin/account/edit.blade.php` - Edit form
- `resources/views/admin/account/edit-password.blade.php` - Password reset
- `resources/views/dashboard/super_admin.blade.php` - Admin dashboard
- `database/migrations/2026_07_20_025103_add_super_admin_user.php` - Create admin

### Modified Files
- `app/Providers/AppServiceProvider.php` - Added `isAdmin` gate
- `app/Http/Controllers/DashboardController.php` - Added `superAdmin()` method
- `routes/web.php` - Added account management routes
- `resources/views/layouts/navigation.blade.php` - Added super admin menu

## 🔗 Routes

All account management routes:
```
GET     /kelola-akun                              List accounts
GET     /kelola-akun/create                       Create form
POST    /kelola-akun                              Store new
GET     /kelola-akun/{user}/edit                  Edit form
PUT     /kelola-akun/{user}                       Update
DELETE  /kelola-akun/{user}                       Delete
GET     /kelola-akun/{user}/edit-password         Password form
PUT     /kelola-akun/{user}/update-password       Update password
GET     /dashboard/super-admin                    Admin dashboard
```

## 🛡️ Security Features

- ✅ Super admin account protected from deletion
- ✅ Only super admin can access account management
- ✅ Strong password requirements (8+, numbers, uppercase, symbols)
- ✅ Confirmation dialogs for destructive actions
- ✅ Role middleware protection on all admin routes
- ✅ Email uniqueness validation
- ✅ Cannot create other super admin accounts

## 📊 Database

No new tables created. Uses existing `users` table with `role` column.

Super admin user automatically created via migration:
```php
User::updateOrCreate(
    ['email' => 'admin@presensi.test'],
    [
        'name' => 'Administrator',
        'password' => Hash::make('password'),
        'role' => 'super_admin',
        'email_verified_at' => now(),
    ]
);
```

## ⚙️ Configuration

### Roles
Four roles now supported:
1. `siswa` - Student
2. `guru` - Teacher
3. `orang_tua` - Parent
4. `super_admin` - Administrator (NEW)

### Middleware
- Route protection: `middleware('role:super_admin')`
- Gate: `can('isAdmin')` or `authorize('isAdmin')`

## 🧪 Testing

### Test Creating Account
1. Login as admin
2. Go to Kelola Akun
3. Click Tambah Akun
4. Fill in test data:
   - Name: Test Guru
   - Email: testguru@test.com
   - Role: Guru
   - Password: TestPass123!
5. Click Buat Akun
6. Should see success message

### Test Edit
1. Click Edit on the new account
2. Change name to "Test Guru Edited"
3. Click Simpan Perubahan
4. Verify changes

### Test Password Reset
1. Click Password button on account
2. Enter new password: NewPass123!
3. Click Ubah Password
4. Try login with old password (should fail)
5. Try login with new password (should work)

### Test Delete
1. Click Hapus on an account
2. Confirm deletion
3. Verify account is removed from list

## ✅ Verification Checklist

- [ ] Super admin migration ran successfully
- [ ] Can login with `admin@presensi.test`
- [ ] Dashboard shows "Portal Admin"
- [ ] "Kelola Akun" appears in sidebar
- [ ] Can create new account
- [ ] Can edit account details
- [ ] Can reset password
- [ ] Can delete account (except super admin)
- [ ] All 4 roles visible in role selector
- [ ] Role badges show correct colors
- [ ] Toast notifications work
- [ ] Confirmation dialogs appear

## 🔧 Troubleshooting

**Q: Super admin account not created**
- A: Run `php artisan migrate` to apply migrations

**Q: Can't access account management**
- A: Verify you're logged in as super admin (check sidebar subtitle)

**Q: Password validation errors**
- A: Ensure password has: 8+ chars, numbers, uppercase, symbols

**Q: Pages not loading after changes**
- A: Run `php artisan optimize:clear` to clear cache

## 📝 Next Steps

1. **Change default password**:
   - Login as admin
   - Click Profil → change password
   - Use strong password

2. **Create other admin accounts** (if needed):
   - Currently only 1 super admin allowed by design
   - Can create separate guru/siswa/orang_tua accounts for testing

3. **Set up user guidelines**:
   - Document role responsibilities
   - Create user onboarding process
   - Document account creation procedures

## 📚 Documentation

Full documentation available in:
- `SUPER_ADMIN_FEATURE.md` - Detailed feature documentation
- `SUPER_ADMIN_SETUP_GUIDE.md` - This file

## 🎉 All Done!

The super admin feature is now ready to use. Start by logging in and creating accounts from the Kelola Akun page.

---

**Support**: For issues or questions, refer to SUPER_ADMIN_FEATURE.md for detailed documentation.

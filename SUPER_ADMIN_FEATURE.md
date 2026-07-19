# Super Admin Feature Documentation

## Overview
The Super Admin role has been added to the Presence Teen system as the 4th role type (in addition to Guru, Siswa, and Orang Tua). The super admin has full system control with exclusive account management capabilities.

## Features

### 1. Super Admin Role
- **Role Value**: `super_admin` (stored in `users.role` column)
- **Uniqueness**: Only ONE super admin account is allowed in the system
- **Default Account**: Created during migration
  - Email: `admin@presensi.test`
  - Password: `password`
  - Name: `Administrator`

### 2. Account Management System (Kelola Akun)
The super admin can perform full CRUD operations on user accounts:

#### Create Account
- Navigate to: Dashboard → Kelola Akun → Tambah Akun
- Route: `/kelola-akun/create` (GET) → `account.create`
- Features:
  - Set name, email, password
  - Choose role: Siswa, Guru, Orang Tua (not Super Admin)
  - Optional NIS field for student accounts
  - Password validation: Min 8 chars, numbers, uppercase, symbols

#### Read/List Accounts
- Navigate to: Dashboard → Kelola Akun
- Route: `/kelola-akun` (GET) → `account.index`
- Features:
  - Paginated list (20 per page)
  - Display: Name, Email, Role, NIS
  - Color-coded role badges
  - Quick action buttons

#### Update Account
- Navigate to: Dashboard → Kelola Akun → Edit
- Route: `/kelola-akun/{user}/edit` (GET) → `account.edit`
- Features:
  - Edit name, email, role, NIS
  - Separate password reset flow
  - Cannot convert to super admin
  - Super admin account marked as "protected"

#### Delete Account
- From account list, click Delete button
- Route: `/kelola-akun/{user}` (DELETE) → `account.destroy`
- Features:
  - Requires confirmation dialog
  - Cannot delete super admin account
  - Cascade delete-safe (related data handled by DB)

#### Reset Password
- From account list, click Password button
- Route: `/kelola-akun/{user}/edit-password` (GET) → `account.edit-password`
- Route: `/kelola-akun/{user}/update-password` (PUT) → `account.update-password`
- Features:
  - Set new password for any user
  - User must use new password on next login
  - Only accessible for non-super-admin accounts

### 3. Dashboard
- Route: `/dashboard/super-admin` (GET) → `dashboard.super_admin`
- Statistics displayed:
  - Total users (breakdown by role)
  - Total classes
  - Total learning materials
  - Total attendance records
  - Recent users list (10 most recent)
  - Recent classes list (5 most recent)
- Quick action cards:
  - Add user
  - Manage accounts
  - Preview guru portal

### 4. Navigation Sidebar
- Super admin can see all guru features:
  - QR Presensi
  - Input Manual
  - Jadwal Mengajar
  - Kelas
  - Siswa
  - Materi
  - Kelola Tugas
  - Laporan Siswa
  - Pengumuman
- **Plus exclusive menu item**: "Kelola Akun" (Account Management)

### 5. Sidebar Branding
- Portal subtitle shows: "Portal Admin" (instead of "Portal Guru", "Portal Siswa", etc.)

## Authorization & Security

### Gates & Policies
- **Gate**: `isAdmin` defined in `AppServiceProvider`
  - Checks if `user->role === 'super_admin'`
- **Policy**: `UserPolicy` 
  - Manages authorization for user-related operations
  - Prevents deletion of super admin accounts
  - All account management routes use `middleware('role:super_admin')`

### Route Protection
All account management routes are protected:
```php
Route::middleware('role:super_admin')->group(function () {
    Route::get('/kelola-akun', ...)           // List
    Route::get('/kelola-akun/create', ...)    // Create form
    Route::post('/kelola-akun', ...)          // Store
    Route::get('/kelola-akun/{user}/edit', ...)  // Edit form
    Route::put('/kelola-akun/{user}', ...)    // Update
    Route::delete('/kelola-akun/{user}', ...)  // Delete
    Route::get('/kelola-akun/{user}/edit-password', ...)     // Password form
    Route::put('/kelola-akun/{user}/update-password', ...)   // Update password
});
```

## Database
- Uses existing `users` table with `role` column
- Super admin account created via migration: `2026_07_20_025103_add_super_admin_user.php`
- No new tables required

## File Structure
```
app/
├── Http/Controllers/
│   ├── AccountController.php        (NEW)
│   └── DashboardController.php       (MODIFIED - added superAdmin method)
├── Policies/
│   └── UserPolicy.php               (NEW)
├── Providers/
│   └── AppServiceProvider.php        (MODIFIED - added isAdmin gate)
└── Models/
    └── User.php                      (no changes - role column already exists)

database/migrations/
└── 2026_07_20_025103_add_super_admin_user.php  (NEW)

resources/views/
├── admin/account/
│   ├── index.blade.php              (NEW - list accounts)
│   ├── create.blade.php             (NEW - create form)
│   ├── edit.blade.php               (NEW - edit form)
│   └── edit-password.blade.php      (NEW - password reset form)
├── dashboard/
│   ├── super_admin.blade.php        (NEW - dashboard)
│   └── ...
└── layouts/
    └── navigation.blade.php          (MODIFIED - added super admin menu)
```

## Routes
```
GET     /kelola-akun                          account.index       (list)
GET     /kelola-akun/create                   account.create      (create form)
POST    /kelola-akun                          account.store       (store)
GET     /kelola-akun/{user}/edit              account.edit        (edit form)
PUT     /kelola-akun/{user}                   account.update      (update)
DELETE  /kelola-akun/{user}                   account.destroy     (delete)
GET     /kelola-akun/{user}/edit-password     account.edit-password       (password form)
PUT     /kelola-akun/{user}/update-password   account.update-password     (update password)
GET     /dashboard/super-admin                dashboard.super_admin       (dashboard)
```

## Testing Login
Super Admin Credentials:
- Email: `admin@presensi.test`
- Password: `password`
- Role: `super_admin`

Access test: http://your-app/dashboard → redirects to `/dashboard/super-admin`

## UI/UX Details
- Account list table uses color-coded role badges:
  - Super Admin: Primary blue
  - Guru: Secondary color
  - Siswa: Tertiary color
  - Orang Tua: Error red
- Action buttons:
  - Edit (Secondary)
  - Password (Tertiary) - not shown for super admin
  - Delete (Error) - not shown for super admin
- Toast notifications for success/error messages
- Confirmation dialogs for destructive actions (delete)
- Pagination with 20 items per page

## Security Considerations
1. Super admin account cannot be deleted
2. Super admin account cannot be converted to another role
3. Password reset requires confirmation with warning
4. All role checks use strict role middleware
5. Only super admin (and no one else) can access account management
6. Email uniqueness enforced for new accounts
7. Password validation enforces strong passwords

## Limitations
- Only 1 super admin account allowed (by design)
- Super admin cannot create other super admin accounts
- Account deletion is permanent (soft delete not implemented)
- Cannot bulk create/delete accounts

## Future Enhancements
- Bulk account operations
- Account import/export (CSV)
- Account audit logs
- Role-specific permissions matrix
- Two-factor authentication for super admin
- IP whitelisting for admin access
- Activity logging and monitoring

## Migration & Rollback
Run migrations:
```bash
php artisan migrate
```

Rollback (removes super admin account):
```bash
php artisan migrate:rollback
```

## Cache Clearing
After deployment:
```bash
php artisan optimize:clear
```

## Troubleshooting

**Super admin account not created:**
- Ensure migrations have run: `php artisan migrate`
- Check database for user with email `admin@presensi.test`

**Cannot access account management:**
- Verify logged-in user has `role = 'super_admin'`
- Check middleware in routes
- Verify gate is defined in AppServiceProvider

**Password reset not working:**
- Verify password meets requirements (8+ chars, numbers, uppercase, symbols)
- Check `Hash` facade import in AccountController

**Pagination not showing:**
- Default is 20 items per page
- Modify in `AccountController::index()` if needed

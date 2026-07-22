# Deployment Guide - Rumahweb Subdomain

Deploy Presence Teen project to `presence.solvianova.my.id` using Rumahweb hosting

## 📋 Prerequisites

Before starting, ensure you have:
- ✅ Rumahweb hosting account (with cPanel access)
- ✅ Domain: `solvianova.my.id`
- ✅ FTP/SFTP credentials from Rumahweb
- ✅ Database credentials (MySQL)
- ✅ SSH access (recommended but optional)
- ✅ Project ready locally with all features tested

## 🎯 Overview

We'll setup:
1. Create subdomain `presence.solvianova.my.id` in cPanel
2. Setup separate database for production
3. Configure Laravel `.env` for production
4. Upload project files via FTP/SFTP
5. Run migrations and setup
6. Configure SSL certificate
7. Setup proper permissions
8. Optimize for production

---

## Step 1: Create Subdomain in cPanel

### 1.1 Login to Rumahweb cPanel
1. Go to: `https://rumahweb.com/` or your Rumahweb control panel URL
2. Enter your credentials
3. Find and click **"Subdomains"** (usually under Domains section)

### 1.2 Add New Subdomain
1. Click **"Create a New Subdomain"**
2. Fill in the form:
   - **Subdomain**: `presence` (will become `presence.solvianova.my.id`)
   - **Domain**: Select `solvianova.my.id` from dropdown
   - **Document Root**: Leave as default or set to `/public_html/presence.solvianova.my.id` or `/public_html/presence`
3. Click **"Create"**

### 1.3 Verify Subdomain
- cPanel should confirm: "Subdomain creation added to queue"
- Wait 5-15 minutes for DNS propagation
- Try accessing: `http://presence.solvianova.my.id` (should show default page)

---

## Step 2: Create Production Database

### 2.1 Create MySQL Database in cPanel
1. Go to cPanel → **"MySQL Databases"**
2. Click **"Create New Database"**
3. Enter database name:
   - **Suggested**: `solvianova_presence_prod` or `solvianova_presence`
   - **Full name will be**: `solvianova_presence` (prefix added by Rumahweb)
4. Click **"Create Database"**

### 2.2 Create MySQL User
1. Go to **"MySQL Users"** section
2. Click **"Create New User"**
3. Fill in:
   - **Username**: `solvianova_presnc` (keep short, Rumahweb adds prefix)
   - **Password**: Generate strong password (save this!)
     - Recommended: Mix of uppercase, lowercase, numbers, symbols
     - Min 12 characters
   - **Password (again)**: Confirm password
4. Click **"Create User"**

### 2.3 Assign User to Database
1. Scroll down to **"Add User To Database"**
2. Select the user you just created
3. Select the database you created
4. Click **"Add"**
5. Check **"ALL PRIVILEGES"** and click **"Make Changes"**

### 2.4 Document Database Credentials
Save these for later:
```
Database Name: solvianova_presence
Database User: solvianova_presnc
Database Password: [your_strong_password]
Database Host: localhost (or as shown in cPanel)
```

---

## Step 3: Prepare Project for Deployment

### 3.1 Install Dependencies Locally
```bash
cd d:\Project\presence-teen
composer install --no-dev --optimize-autoloader
npm run build
```

### 3.2 Create Production .env File
Copy and modify `.env`:

```bash
# Copy to .env.production
cp .env .env.production
```

Edit `.env.production` with production settings:

```env
APP_NAME="Presence Teen"
APP_ENV=production
APP_KEY=base64:your_app_key_here
APP_DEBUG=false
APP_URL=https://presence.solvianova.my.id

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=solvianova_presence
DB_USERNAME=solvianova_presnc
DB_PASSWORD=your_database_password_here

CACHE_DRIVER=file
SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.rumahweb.com
MAIL_PORT=465
MAIL_USERNAME=your_email@solvianova.my.id
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@solvianova.my.id"
MAIL_FROM_NAME="Presence Teen"

# Optional: AI integration
AI_API_BASE_URL=https://api.anthropic.com
AI_API_KEY=your_anthropic_api_key
AI_MODEL=claude-3-5-sonnet-20241022
```

### 3.3 Generate APP_KEY
If you don't have APP_KEY locally, generate it:
```bash
php artisan key:generate --show
```

Copy the output and paste into `.env.production` as `APP_KEY`

---

## Step 4: Upload Project to Rumahweb

### Option A: Using FTP/SFTP (Recommended for beginners)

#### 4A.1 Get FTP Credentials from cPanel
1. Go to cPanel → **"FTP Accounts"**
2. Click on your main FTP account or create new one
3. Note down:
   - **FTP Host**: Usually `presence.solvianova.my.id` or your cPanel hostname
   - **FTP User**: Your FTP username
   - **FTP Password**: Your FTP password
   - **FTP Port**: 21 (or 22 for SFTP)

#### 4A.2 Use FTP Client (FileZilla recommended)
1. Download FileZilla: https://filezilla-project.org/
2. Open FileZilla
3. Go to **File** → **Site Manager** → **New Site**
4. Fill in:
   - **Protocol**: SFTP (SSH File Transfer) - more secure
   - **Host**: `presence.solvianova.my.id` or hostname from cPanel
   - **Port**: 22 (for SFTP) or 21 (for FTP)
   - **Logon Type**: Normal
   - **User**: Your FTP username
   - **Password**: Your FTP password
5. Click **Connect**

#### 4A.3 Upload Project Files
1. Navigate to the subdomain folder on remote server
   - Path should be: `/public_html/presence.solvianova.my.id/` or `/home/[username]/public_html/presence/`
2. On left panel, navigate to your local project: `d:\Project\presence-teen`
3. Select all folders except:
   - `.git` (don't upload version control)
   - `node_modules` (will install on server)
   - `.env` (don't upload, create new on server)
   - `storage/logs` (create empty on server)
4. Drag and drop to upload

#### 4A.4 Important: Don't Upload These Files
- `.env` (we'll create on server)
- `.git` directory
- `node_modules`
- `vendor` (will install via composer)
- Local development files

### Option B: Using SSH/Git (For advanced users)

#### 4B.1 Connect via SSH
```bash
ssh your_username@presence.solvianova.my.id
# Or use the hostname provided by Rumahweb

# Navigate to subdomain directory
cd public_html/presence.solvianova.my.id
# or
cd public_html/presence
```

#### 4B.2 Clone Project from Git
```bash
git clone https://github.com/your-username/presence-teen.git .
# or if repository exists locally, you can push and pull
```

---

## Step 5: Setup Project on Server

### 5.1 Connect to Server via SSH (Recommended)

If you have SSH access (much faster):

```bash
ssh your_username@presence.solvianova.my.id
```

### 5.2 Navigate to Project Directory
```bash
cd public_html/presence.solvianova.my.id
# or
cd public_html/presence
```

### 5.3 Create Production .env File
```bash
# Create .env from .env.example
cp .env.example .env

# Edit .env with production settings
nano .env
# or use your preferred editor
```

Paste the production .env settings (from Step 3.2)

### 5.4 Set APP_KEY
```bash
php artisan key:generate
# This will auto-generate and add APP_KEY to .env
```

### 5.5 Install Composer Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

This installs all PHP dependencies for production.

### 5.6 Build Frontend Assets
```bash
npm install
npm run build
```

Or if Node.js is not available on server:
- Build locally: `npm run build`
- Upload `public/build` folder to server

### 5.7 Create Storage Link
```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`

### 5.8 Set Permissions
```bash
# Set ownership to web server user
chown -R nobody:nobody /home/username/public_html/presence.solvianova.my.id
# or for specific folders:
chmod -R 755 public/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chmod 644 .env
```

### 5.9 Run Migrations
```bash
php artisan migrate --force
```

The `--force` flag skips confirmation (use only in production)

### 5.10 Seed Database (Optional)
To create demo data (super admin, test users):
```bash
php artisan db:seed --force
```

Or seed specific seeder:
```bash
php artisan db:seed --class=DatabaseSeeder --force
```

### 5.11 Clear Caches
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 5.12 Optimize for Production
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 6: Configure Web Server (.htaccess)

Laravel requires `.htaccess` configuration for routing.

### 6.1 Check if .htaccess Exists
The file `public/.htaccess` should already exist. If not, create it.

### 6.2 Create/Update public/.htaccess
If file doesn't exist, create `public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```

### 6.3 Check .htaccess in Root (if needed)
Create root `.htaccess` if subdomain still has routing issues:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## Step 7: Setup SSL Certificate

### 7.1 Using AutoSSL (Automatic - Recommended)
Most Rumahweb plans include AutoSSL:

1. Go to cPanel → **"AutoSSL"**
2. Check if `presence.solvianova.my.id` is listed
3. If not, click **"Check & Install"**
4. Wait for SSL to be issued (automatic, usually within minutes)

### 7.2 Verify SSL Works
```bash
https://presence.solvianova.my.id
```

Should show green lock icon

### 7.3 Force HTTPS in Laravel
Edit `.env`:
```env
APP_URL=https://presence.solvianova.my.id
```

In `app/Providers/AppServiceProvider.php`, add:
```php
public function boot()
{
    if ($this->app->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

---

## Step 8: Configure Public HTML Directory Structure

### 8.1 Subdomain Directory Structure
The subdomain should point to the `public` folder:

**Option 1: Setup via cPanel**
1. Go to cPanel → **Subdomains**
2. Edit subdomain
3. Set **Document Root** to: `/public_html/presence.solvianova.my.id/public`

**Option 2: Using .htaccess**
If you can't change document root, use `.htaccess` in root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## Step 9: Test Deployment

### 9.1 Basic Tests
1. **Test URL**: Visit `https://presence.solvianova.my.id`
2. **Login**: Try login with credentials
3. **Database**: Check if data loads

### 9.2 Test Login
```
Email: admin@presensi.test
Password: password
Role: super_admin
```

### 9.3 Check Error Logs
If issues occur, check logs:
```bash
# Via SSH
tail -f storage/logs/laravel.log

# Or via FTP: download storage/logs/laravel.log
```

### 9.4 Test Key Features
- ✅ Login page works
- ✅ Dashboard loads
- ✅ Can create accounts (super admin)
- ✅ Can scan QR codes
- ✅ Can upload files
- ✅ Database queries work

---

## Step 10: Configure Email (Optional but Recommended)

### 10.1 Get SMTP Details from Rumahweb
1. Contact Rumahweb support or check your account
2. Usually:
   - Host: `smtp.rumahweb.com` or `mail.solvianova.my.id`
   - Port: 465 (SSL) or 587 (TLS)
   - Username: Your email address
   - Password: Email password

### 10.2 Update .env
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.rumahweb.com
MAIL_PORT=465
MAIL_USERNAME=your_email@solvianova.my.id
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@solvianova.my.id"
MAIL_FROM_NAME="Presence Teen"
```

### 10.3 Test Email (Optional)
```bash
php artisan tinker
Mail::raw('Test email', function($message) {
    $message->to('your_email@test.com')->subject('Test');
});
```

---

## Step 11: Setup Backups & Monitoring

### 11.1 Backup Strategy
1. **Database backups**: Via cPanel → Backups
2. **File backups**: Ask Rumahweb about backup plans
3. **Manual backups**: Regular FTP downloads

### 11.2 Monitor Application
- Check Laravel logs regularly: `storage/logs/laravel.log`
- Monitor database size: cPanel → MySQL Databases
- Monitor storage: cPanel → Disk Usage

---

## Step 12: Production Checklist

Before going live, verify:

- [ ] Domain `presence.solvianova.my.id` resolves correctly
- [ ] SSL certificate installed (green lock icon)
- [ ] `.env` has `APP_DEBUG=false`
- [ ] `.env` has `APP_ENV=production`
- [ ] Database migrated successfully
- [ ] Storage permissions set correctly (755/775)
- [ ] `.htaccess` working (routes responsive)
- [ ] Composer dependencies installed (`vendor` folder exists)
- [ ] Assets compiled (`public/build` or `public/css,js` exist)
- [ ] Login works with test credentials
- [ ] Super admin dashboard accessible
- [ ] Can create accounts
- [ ] Email sending works (if configured)
- [ ] Database backups configured
- [ ] Error logs being written to `storage/logs/laravel.log`
- [ ] No sensitive data in version control
- [ ] `.env` file not visible publicly

---

## Troubleshooting

### Issue: 404 Errors on All Routes Except Home
**Solution**: `.htaccess` not working
```bash
# Check if mod_rewrite is enabled
# Contact Rumahweb support if needed
# Or use root .htaccess redirection
```

### Issue: "Invalid APP_KEY"
**Solution**: 
```bash
php artisan key:generate
# Verify in .env: APP_KEY=base64:...
```

### Issue: Database Connection Failed
**Solution**:
```bash
# Verify .env credentials match cPanel
DB_HOST=localhost
DB_DATABASE=solvianova_presence
DB_USERNAME=solvianova_presnc
DB_PASSWORD=correct_password
```

### Issue: "The stream does not support seeking"
**Solution**: Usually file upload issue
```bash
# Ensure storage permissions are correct
chmod -R 775 storage/
```

### Issue: Blank Page / 500 Error
**Solution**:
```bash
# Check logs
tail -f storage/logs/laravel.log

# Run optimization
php artisan optimize
php artisan config:cache

# Clear caches
php artisan optimize:clear
```

### Issue: "No application encryption key has been specified"
**Solution**:
```bash
php artisan key:generate
# Verify APP_KEY is set in .env
```

---

## Performance Optimization

### 11.1 Cache Configuration
Edit `.env`:
```env
CACHE_DRIVER=file
# Or if Redis available:
CACHE_DRIVER=redis
```

### 11.2 Session Configuration
```env
SESSION_DRIVER=database
```

### 11.3 Queue Processing
For background jobs:
```bash
php artisan queue:work &
# Or setup cron job:
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

### 11.4 Optimize Commands
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Useful Commands for Production

```bash
# Check application status
php artisan tinker

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Clear all caches
php artisan optimize:clear

# Optimize for production
php artisan optimize

# Check Laravel version
php artisan --version

# View error logs
tail -f storage/logs/laravel.log

# Backup database
mysqldump -u solvianova_presnc -p solvianova_presence > backup.sql

# Restore database
mysql -u solvianova_presnc -p solvianova_presence < backup.sql
```

---

## Support & Help

### Rumahweb Support
- **Website**: https://rumahweb.com/
- **Support Ticket**: Via cPanel or email
- **Documentation**: https://rumahweb.com/bantuan/

### Laravel Support
- **Documentation**: https://laravel.com/docs
- **Discord Community**: https://discord.gg/laravel

### Common Issues
Check `storage/logs/laravel.log` for detailed error messages

---

## Final Notes

1. **Keep .env secure** - Never commit to git, never share
2. **Regular backups** - Setup automated backups via Rumahweb
3. **Monitor logs** - Check `storage/logs/laravel.log` regularly
4. **Update dependencies** - Keep Laravel and packages updated
5. **Test thoroughly** - Test all features after deployment
6. **Document changes** - Keep track of production configurations

---

## Summary

✅ Subdomain created: `presence.solvianova.my.id`
✅ Database configured and connected
✅ Project uploaded and installed
✅ Migrations run successfully
✅ SSL certificate active
✅ Application accessible and tested

Your Presence Teen project is now live on `presence.solvianova.my.id`!

---

**Last Updated**: July 20, 2026
**Status**: Complete & Ready for Production

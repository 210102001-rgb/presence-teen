# SSH Commands Reference - Deployment to Rumahweb

Quick reference for SSH commands when deploying to `presence.solvianova.my.id`

## 📞 SSH Connection

```bash
# Connect via SSH (replace with your credentials)
ssh username@presence.solvianova.my.id

# Or use your Rumahweb hostname
ssh username@rumahweb-server.com

# With specific port (if provided)
ssh -p 22 username@presence.solvianova.my.id
```

## 🗂️ File Management

```bash
# Navigate to project directory
cd public_html/presence.solvianova.my.id
# Or
cd public_html/presence

# List files
ls -la

# Create directory
mkdir directory-name

# Remove file
rm filename

# Remove directory and contents
rm -r directory-name

# Copy file
cp source.txt destination.txt

# Copy directory
cp -r source-dir destination-dir

# Move/rename file
mv oldname.txt newname.txt

# Change permissions (755 = read/execute for all)
chmod 755 filename

# Change permissions recursively
chmod -R 755 public/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Change ownership
chown -R user:group /path/to/directory

# View file content
cat .env
less .env          # Scroll with arrow keys
nano .env          # Edit file

# Search in files
grep "DB_HOST" .env

# Count files
ls -1 | wc -l
```

## 🐘 PHP & Laravel Commands

### Initial Setup

```bash
# Generate APP_KEY
php artisan key:generate

# Show APP_KEY
php artisan key:generate --show

# Check Laravel version
php artisan --version

# Check PHP version
php --version
```

### Migrations & Database

```bash
# Run migrations
php artisan migrate

# Run migrations with force (production)
php artisan migrate --force

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Refresh (rollback all then migrate)
php artisan migrate:refresh --force

# See migration status
php artisan migrate:status
```

### Seeding

```bash
# Run seeder
php artisan db:seed

# Run with force (production)
php artisan db:seed --force

# Run specific seeder
php artisan db:seed --class=DatabaseSeeder --force
```

### Cache Management

```bash
# Clear all caches
php artisan optimize:clear

# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Optimize for production
php artisan optimize

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Storage

```bash
# Create storage link (public/storage → storage/app/public)
php artisan storage:link

# Remove storage link
unlink public/storage

# Check storage link
ls -la public/ | grep storage
```

### Other Commands

```bash
# Enter interactive shell
php artisan tinker

# Test database connection
# In tinker:
> DB::connection()->getPdo();
> exit

# List all routes
php artisan route:list

# Check artisan help
php artisan help

# Run tests (if using testing)
php artisan test
```

## 📦 Composer Commands

```bash
# Install dependencies
composer install

# Install without dev dependencies (production)
composer install --no-dev --optimize-autoloader

# Update dependencies
composer update

# Check for security vulnerabilities
composer audit

# Show installed packages
composer show

# Show package info
composer show package/name
```

## 📝 npm Commands (if available)

```bash
# Install dependencies
npm install

# Build for production
npm run build

# Build with watch mode (development)
npm run dev
```

## 🔍 Viewing & Monitoring Logs

```bash
# View entire log file
cat storage/logs/laravel.log

# View last 20 lines
tail -20 storage/logs/laravel.log

# Follow log in real-time (press Ctrl+C to stop)
tail -f storage/logs/laravel.log

# View last 50 lines and follow
tail -f -n 50 storage/logs/laravel.log

# Search for errors
grep "ERROR" storage/logs/laravel.log

# Count errors
grep -c "ERROR" storage/logs/laravel.log

# View specific time period (last 10 minutes)
tail -f storage/logs/laravel.log | grep "$(date '+%Y-%m-%d %H:%M')"

# View errors only
grep "\[ERROR\]\|\[Exception\]" storage/logs/laravel.log | tail -20
```

## 🗄️ MySQL Database Commands

```bash
# Connect to MySQL
mysql -u solvianova_presnc -p
# Then enter password when prompted

# Inside MySQL:

# Show all databases
SHOW DATABASES;

# Select database
USE solvianova_presence;

# Show all tables
SHOW TABLES;

# Describe table structure
DESCRIBE users;
DESC users;

# Show table contents
SELECT * FROM users;

# Show number of users
SELECT COUNT(*) FROM users;

# Show super admin
SELECT * FROM users WHERE role='super_admin';

# Exit MySQL
EXIT;
```

### MySQL Backup & Restore

```bash
# Backup database
mysqldump -u solvianova_presnc -p solvianova_presence > backup.sql

# Restore database
mysql -u solvianova_presnc -p solvianova_presence < backup.sql

# Backup with timestamp
mysqldump -u solvianova_presnc -p solvianova_presence > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup all databases
mysqldump -u solvianova_presnc -p --all-databases > full_backup.sql
```

## 🔐 File Permissions

```bash
# Make file readable/writable by all
chmod 666 filename

# Make file readable by all, writable by owner
chmod 644 filename

# Make directory accessible by all
chmod 755 directory

# Make directory and files within accessible, writable by owner
chmod 755 directory
chmod 644 directory/*

# Set .env permissions (secure)
chmod 644 .env

# Typical Laravel permissions
chmod 755 public/
chmod 755 storage/
chmod 755 bootstrap/cache/
chmod 644 .env

# Change owner to web user
chown -R nobody:nobody /path/to/project
# Or
chown -R www-data:www-data /path/to/project
```

## 📊 System Information

```bash
# Check disk space
df -h

# Check current directory size
du -sh .

# Check storage folder size
du -sh storage/

# Check directory breakdown
du -sh */ | sort -rh

# Check system uptime
uptime

# Check current date/time
date

# Check server load
top
# Press 'q' to quit

# Check memory usage
free -h

# Check CPU info
nproc

# Check PHP configuration
php -i

# Check PHP modules loaded
php -m
```

## 🔗 Web Server Configuration

```bash
# Check if Apache is running
systemctl status apache2
# or
service apache2 status

# Check Apache modules
apache2ctl -M | grep rewrite

# Check web server user
ps aux | grep apache
ps aux | grep www-data

# Check .htaccess file
cat public/.htaccess
```

## 🚀 Common Deployment Workflow

```bash
# 1. Connect to server
ssh username@presence.solvianova.my.id

# 2. Navigate to project
cd public_html/presence.solvianova.my.id

# 3. Create .env if needed
cp .env.example .env
# Edit with: nano .env

# 4. Generate key
php artisan key:generate

# 5. Install dependencies
composer install --no-dev --optimize-autoloader

# 6. Run migrations
php artisan migrate --force

# 7. Seed database (optional)
php artisan db:seed --force

# 8. Set permissions
chmod -R 755 public/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# 9. Build assets (if npm available)
npm install
npm run build

# 10. Create storage link
php artisan storage:link

# 11. Clear and optimize
php artisan optimize:clear
php artisan optimize

# 12. Check logs
tail -f storage/logs/laravel.log
```

## 🐛 Troubleshooting Commands

```bash
# Check if PHP is working
php -r "echo 'PHP Works!';"

# Check if composer is installed
composer --version

# Check if npm is installed
npm --version

# Check current Laravel version
php artisan --version

# Check configuration
php artisan config:show

# Check database connection
php artisan tinker
> DB::connection()->getPdo();

# Check storage permissions
ls -la storage/
ls -la bootstrap/cache/

# Find large files
find . -type f -size +10M

# Find empty directories
find . -type d -empty

# Check error logs
tail -50 storage/logs/laravel.log | grep ERROR

# Verify .env exists and readable
cat .env | head -5

# Check if routes work
curl -I https://presence.solvianova.my.id/login
```

## 🔄 Quick Restart/Maintenance

```bash
# Clear all caches and reoptimize
php artisan optimize:clear && php artisan optimize

# Restart web server (may require sudo)
sudo systemctl restart apache2
# or
sudo service apache2 restart

# Flush database cache (if using)
php artisan cache:forget anything

# Run scheduled tasks
php artisan schedule:run

# Maintenance mode (on)
php artisan down --message "Updating..." --retry=60

# Maintenance mode (off)
php artisan up
```

## 📋 Useful Aliases (Optional)

Add to `.bashrc` or `.bash_profile`:

```bash
# Add these to make commands shorter
alias artisan="php artisan"
alias migrate="php artisan migrate --force"
alias seed="php artisan db:seed --force"
alias clearall="php artisan optimize:clear && php artisan optimize"
alias logs="tail -f storage/logs/laravel.log"
alias tinker="php artisan tinker"
```

Then use:
```bash
artisan migrate
seed
clearall
logs
tinker
```

## 💡 Tips

1. **Always use `--force` in production** for migrate and seed commands
2. **Monitor logs regularly**: `tail -f storage/logs/laravel.log`
3. **Backup before major changes**: `mysqldump -u user -p db > backup.sql`
4. **Test commands locally first** before running on production
5. **Use `cd` to navigate** then verify with `pwd`
6. **Check permissions** after uploading files
7. **Save important info** (credentials, IPs, etc.)

## 🆘 Emergency Commands

```bash
# If application is down:

# 1. Check logs
tail -50 storage/logs/laravel.log

# 2. Verify permissions
chmod -R 775 storage/

# 3. Clear caches
php artisan optimize:clear

# 4. Optimize
php artisan optimize

# 5. Check database connection
php artisan tinker
> DB::connection()->getPdo();
> exit

# 6. If still down, enable maintenance mode
php artisan down --message "Maintenance in progress"

# Then fix issues and turn off:
php artisan up
```

---

**Pro Tip**: Keep this file handy for quick reference during deployment!

For complete guide, see: DEPLOYMENT_RUMAHWEB_GUIDE.md

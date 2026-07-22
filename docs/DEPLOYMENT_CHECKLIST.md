# Deployment Checklist - Presence Teen to presence.solvianova.my.id

Use this checklist to ensure everything is configured correctly before deploying to production.

## 📋 Pre-Deployment Preparation (Local)

### Code & Dependencies
- [ ] All features tested locally
- [ ] No console errors in browser
- [ ] No compile errors in code
- [ ] Dependencies installed: `composer install --no-dev`
- [ ] Frontend assets built: `npm run build`
- [ ] Git committed: All changes committed (don't commit `.env`)
- [ ] `.gitignore` includes: `.env`, `node_modules`, `vendor`, `storage/`

### Database
- [ ] Migrations created for all features
- [ ] Seeder created: `DatabaseSeeder.php`
- [ ] Test run locally: `php artisan migrate:refresh --seed`
- [ ] Super admin account setup: `admin@presensi.test`

### Environment
- [ ] `.env` file configured locally
- [ ] `APP_KEY` generated: `php artisan key:generate`
- [ ] `.env.production` template created

### Security
- [ ] No sensitive data in code
- [ ] API keys not committed to git
- [ ] Passwords hashed properly
- [ ] CSRF protection enabled
- [ ] SQL injection prevention (using queries properly)

---

## 🌐 Rumahweb Setup

### Domain & Subdomains
- [ ] Domain `solvianova.my.id` verified in Rumahweb
- [ ] Subdomain `presence` created in cPanel
- [ ] Subdomain points to correct document root
- [ ] DNS records updated (if needed)
- [ ] Subdomain accessible via `http://presence.solvianova.my.id`

### Database
- [ ] MySQL database created: `solvianova_presence`
- [ ] Database user created: `solvianova_presnc`
- [ ] User assigned to database with ALL PRIVILEGES
- [ ] Credentials saved and verified:
  - [ ] Host: `localhost`
  - [ ] Database: `solvianova_presence`
  - [ ] User: `solvianova_presnc`
  - [ ] Password: ✓ (saved securely)

### FTP/SSH Access
- [ ] FTP credentials obtained
- [ ] SSH access confirmed (if available)
- [ ] Can connect to subdomain directory
- [ ] Correct permissions on folders

### SSL Certificate
- [ ] AutoSSL enabled/configured
- [ ] SSL certificate issued for `presence.solvianova.my.id`
- [ ] HTTPS works: `https://presence.solvianova.my.id`
- [ ] Certificate auto-renews

---

## 📤 Deployment

### File Upload
- [ ] All project files uploaded (except .git, vendor, node_modules, .env)
- [ ] `public` folder accessible
- [ ] `storage` folder writable
- [ ] `bootstrap/cache` folder writable
- [ ] File permissions correct (755 for public, 775 for writable)

### Configuration
- [ ] `.env` file created on server
- [ ] Correct database credentials in `.env`
- [ ] `APP_URL=https://presence.solvianova.my.id`
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` generated: `php artisan key:generate`
- [ ] CSRF token working

### Installation
- [ ] Composer dependencies installed: `composer install --no-dev`
- [ ] npm dependencies installed: `npm install` (if Node available)
- [ ] Frontend built: `npm run build`
- [ ] Storage link created: `php artisan storage:link`

### Database
- [ ] Migrations run: `php artisan migrate --force`
- [ ] Seeder run (optional): `php artisan db:seed --force`
- [ ] Super admin account exists in database
- [ ] Tables created successfully

### Optimization
- [ ] Cache cleared: `php artisan optimize:clear`
- [ ] Caches configured: `php artisan optimize`
- [ ] Config cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`

### Web Server
- [ ] `.htaccess` in `public/` folder
- [ ] Routing working (not 404 on nested routes)
- [ ] `/login` page loads
- [ ] Static files load (CSS, JS, images)
- [ ] File uploads working in `public/uploads`

---

## ✅ Testing & Verification

### Basic Functionality
- [ ] Homepage loads: `https://presence.solvianova.my.id`
- [ ] Login page displays
- [ ] Can login with test credentials: `admin@presensi.test` / `password`
- [ ] Dashboard loads after login
- [ ] Can navigate between pages
- [ ] Sidebar menu appears

### Features Testing
- [ ] Super admin dashboard accessible
- [ ] "Kelola Akun" (Account Management) works
- [ ] Can create new account
- [ ] Can edit account
- [ ] Can reset password
- [ ] Can delete account (except super admin)
- [ ] Student QR scanning works
- [ ] File uploads work
- [ ] Database queries execute correctly

### Performance
- [ ] Page loads reasonably fast (<3 seconds)
- [ ] Database queries performant
- [ ] No N+1 query problems
- [ ] Images load properly
- [ ] CSS/JS minified and loading

### Security
- [ ] HTTPS working (green lock)
- [ ] No mixed content warnings
- [ ] Login page secure
- [ ] Passwords hashed
- [ ] CSRF tokens validated
- [ ] No SQL injection possible
- [ ] XSS protection active

### Errors & Logs
- [ ] No errors in Laravel logs
- [ ] Check: `tail -f storage/logs/laravel.log`
- [ ] No 404 errors (unless intentional)
- [ ] No 500 errors
- [ ] Error log doesn't grow excessively

### Browser Testing
- [ ] Chrome: Works correctly
- [ ] Firefox: Works correctly
- [ ] Safari: Works correctly (if available)
- [ ] Mobile (iPhone): Responsive and functional
- [ ] Mobile (Android): Responsive and functional
- [ ] Tablet: Layout correct

---

## 📧 Email Configuration (Optional)

- [ ] SMTP credentials obtained from Rumahweb
- [ ] Email configured in `.env`:
  - [ ] `MAIL_MAILER=smtp`
  - [ ] `MAIL_HOST=smtp.rumahweb.com`
  - [ ] `MAIL_PORT=465`
  - [ ] `MAIL_USERNAME=your_email`
  - [ ] `MAIL_PASSWORD=your_password`
  - [ ] `MAIL_ENCRYPTION=ssl`
- [ ] Test email sending works
- [ ] Email received successfully

---

## 🔐 Security & Hardening

- [ ] `.env` file permissions: 644 (not readable by web)
- [ ] `storage/` folder not publicly accessible
- [ ] `bootstrap/cache/` not publicly accessible
- [ ] `.git` folder not publicly accessible
- [ ] No debug info in production: `APP_DEBUG=false`
- [ ] No API keys in commits
- [ ] No passwords in comments or code
- [ ] Rate limiting configured (if needed)
- [ ] CORS configured (if needed)

---

## 📊 Monitoring & Maintenance

### Ongoing
- [ ] Error logs monitored: Check `storage/logs/laravel.log`
- [ ] Database backups configured
- [ ] File backups scheduled
- [ ] SSL certificate auto-renewal confirmed
- [ ] Uptime monitoring setup (optional)

### Documentation
- [ ] Database credentials saved securely
- [ ] FTP/SSH credentials saved securely
- [ ] Emergency contacts saved
- [ ] Deployment steps documented
- [ ] Rollback procedure documented

### Escalation
- [ ] Know how to revert if issues occur
- [ ] Have Rumahweb support contact info
- [ ] Have database backup recovery plan
- [ ] Emergency super admin credentials saved

---

## 🎯 Post-Deployment Tasks

### Week 1
- [ ] Monitor error logs daily
- [ ] Test all user roles (siswa, guru, orang_tua)
- [ ] Verify data integrity
- [ ] Check database size
- [ ] Confirm backups working

### Week 2-4
- [ ] Set up automated tasks (if queue jobs exist)
- [ ] Monitor performance
- [ ] Gather user feedback
- [ ] Make adjustments as needed

### Ongoing
- [ ] Keep Laravel updated
- [ ] Update dependencies monthly
- [ ] Monitor security advisories
- [ ] Review logs weekly
- [ ] Backup database regularly

---

## 📞 Emergency Contacts

Keep these saved:
```
Rumahweb Support:
- Website: https://rumahweb.com/
- Email: support@rumahweb.com
- Chat: Via cPanel

Your Credentials (save securely):
- cPanel URL: [your-cpanel-url]
- cPanel User: [your-username]
- FTP Host: presence.solvianova.my.id
- FTP User: [your-ftp-user]
- Database: solvianova_presence
- DB User: solvianova_presnc
- Super Admin Email: admin@presensi.test
```

---

## ❌ Common Issues & Fixes

### Issue: 404 on all routes except home
**Fix**: Check `.htaccess` in public folder, verify mod_rewrite enabled

### Issue: Database connection failed
**Fix**: Verify credentials in `.env`, check MySQL service running

### Issue: Blank white page
**Fix**: Check `storage/logs/laravel.log` for error details

### Issue: Cannot upload files
**Fix**: Check `storage/` permissions (775), verify disk space

### Issue: CSS/JS not loading
**Fix**: Run `php artisan storage:link`, check permissions

### Issue: Email not sending
**Fix**: Verify SMTP credentials, check `storage/logs/laravel.log`

---

## 🎉 Success Indicators

Project is successfully deployed when:

✅ All pages load without errors
✅ Login works with correct credentials
✅ Super admin can manage accounts
✅ File uploads work
✅ Database queries execute
✅ HTTPS certificate valid (green lock)
✅ No 500 errors in logs
✅ Performance is acceptable
✅ Mobile-friendly layout works
✅ All user roles can access their features

---

## 📝 Notes

Use this section to document your specific setup:

```
Subdomain: presence.solvianova.my.id
IP Address: [if known]
Document Root: /home/[username]/public_html/presence/
Database Host: localhost
Database Name: solvianova_presence
FTP Host: [your-ftp-host]
Support Ticket: [if opened]
Deployment Date: [date]
Deployed By: [your-name]
Notes: [any special setup]
```

---

## ✅ Final Sign-Off

- [ ] All checklist items completed
- [ ] Testing successful
- [ ] Ready for production use
- [ ] Team informed
- [ ] Monitoring setup
- [ ] Backups verified

**Date Deployed**: _______________
**Deployed By**: _______________
**Notes**: _________________________________________________________________

---

**Good luck with your deployment! 🚀**

For questions, refer to: DEPLOYMENT_RUMAHWEB_GUIDE.md

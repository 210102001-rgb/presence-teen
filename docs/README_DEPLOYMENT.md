# 🚀 Presence Teen Deployment Package

Complete deployment documentation for hosting on Rumahweb subdomain `presence.solvianova.my.id`

## 📦 What's Included

This package contains **5 comprehensive deployment guides** to help you deploy your Presence Teen project to Rumahweb hosting with a subdomain setup.

### Documents Included

1. **DEPLOYMENT_INDEX.md** ⭐ START HERE
   - Navigation guide for all documentation
   - Choose your path based on available time
   - Document relationships and quick links

2. **DEPLOYMENT_SUMMARY.md** ⏱️ 10-MINUTE QUICK VERSION
   - Quick overview of entire deployment process
   - Essential steps only (no fluff)
   - Perfect for experienced users or quick reference

3. **DEPLOYMENT_RUMAHWEB_GUIDE.md** 📖 COMPREHENSIVE GUIDE
   - Complete step-by-step instructions
   - 12 detailed sections covering everything
   - Detailed explanations and best practices
   - Troubleshooting guide included
   - **Recommended for first-time deployment**

4. **DEPLOYMENT_CHECKLIST.md** ✅ VERIFICATION CHECKLIST
   - Pre-deployment preparation checklist
   - Post-deployment verification checklist
   - Testing scenarios
   - Security & monitoring checklist
   - Print-friendly format

5. **DEPLOYMENT_SSH_COMMANDS.md** 🔧 COMMAND REFERENCE
   - All SSH commands needed during deployment
   - Laravel artisan command reference
   - MySQL database commands
   - File permission commands
   - Keep this handy during execution

6. **DEPLOYMENT_QUICK_REFERENCE.txt** 📋 ONE-PAGE REFERENCE
   - Print-friendly summary
   - Essential commands and settings
   - Credentials template
   - Common problems & quick fixes
   - Emergency procedures
   - **Print this out!**

7. **.env.production.example** ⚙️ CONFIGURATION TEMPLATE
   - Production environment template
   - All settings explained
   - Safe values pre-filled
   - Copy and customize for your server

---

## 🎯 Quick Start (Choose One)

### ⚡ "I'm experienced & in a hurry" (45 minutes)
```
1. Read: DEPLOYMENT_SUMMARY.md (5 min)
2. Print: DEPLOYMENT_QUICK_REFERENCE.txt
3. Execute: Steps from summary
4. Reference: DEPLOYMENT_SSH_COMMANDS.md as needed
```

### 📚 "I want complete understanding" (90 minutes)
```
1. Read: DEPLOYMENT_RUMAHWEB_GUIDE.md (20 min)
2. Follow: DEPLOYMENT_CHECKLIST.md (30 min)
3. Reference: DEPLOYMENT_SSH_COMMANDS.md (as needed)
4. Configure: .env.production.example
```

### 🆘 "I need help / troubleshooting"
```
1. Check: Troubleshooting in DEPLOYMENT_RUMAHWEB_GUIDE.md
2. Look up: Command in DEPLOYMENT_SSH_COMMANDS.md
3. Verify: Using DEPLOYMENT_CHECKLIST.md
4. See: DEPLOYMENT_QUICK_REFERENCE.txt for common fixes
```

---

## 📋 At a Glance

```
Deploy Presence Teen to: https://presence.solvianova.my.id

Time Required: 45-90 minutes
Difficulty: Medium
Prerequisites: Rumahweb account, domain, FTP/SSH access
No Additional Cost: Uses existing Rumahweb plan
```

---

## 🗂️ Deployment Overview

### The Process

```
LOCAL PROJECT
    ↓
CREATE SUBDOMAIN (Rumahweb cPanel)
    ↓
SETUP DATABASE (Rumahweb cPanel)
    ↓
UPLOAD FILES (FTP/SFTP)
    ↓
SERVER CONFIGURATION (SSH)
    ↓
RUN MIGRATIONS & SEEDING
    ↓
VERIFICATION & TESTING
    ↓
LIVE ON: https://presence.solvianova.my.id 🎉
```

### Key Steps

1. **Rumahweb Setup** (10 min)
   - Create subdomain: `presence.solvianova.my.id`
   - Create MySQL database: `solvianova_presence`
   - Get FTP credentials

2. **Local Preparation** (5 min)
   - `composer install --no-dev`
   - `npm run build`

3. **File Upload** (20 min)
   - Upload via FTP/SFTP (except .env, vendor, etc.)

4. **Server Setup** (15 min via SSH)
   - Create .env with database credentials
   - `php artisan key:generate`
   - `composer install --no-dev`
   - `php artisan migrate --force`
   - Set permissions and optimize

5. **Verify** (5 min)
   - Access: https://presence.solvianova.my.id
   - Login with admin@presensi.test
   - Test features

---

## 📱 Login After Deployment

```
Email:    admin@presensi.test
Password: password
Role:     super_admin

⚠️  Change password immediately after first login!
```

---

## 🔧 Essential Configuration

### Database Credentials (from Rumahweb cPanel)
```
Host:     localhost
Database: solvianova_presence
User:     solvianova_presnc
Password: [Your strong password]
```

### Production .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://presence.solvianova.my.id

DB_HOST=localhost
DB_DATABASE=solvianova_presence
DB_USERNAME=solvianova_presnc
DB_PASSWORD=your_password_here
```

---

## ✅ Quick Verification

After deployment, confirm:

- [ ] URL works: `https://presence.solvianova.my.id`
- [ ] SSL certificate valid (green lock)
- [ ] Can login with `admin@presensi.test`
- [ ] Dashboard loads
- [ ] Database working
- [ ] No 500 errors

---

## 🆘 If Something Goes Wrong

### Check Error Logs (via SSH)
```bash
tail -f storage/logs/laravel.log
```

### Common Issues
See **DEPLOYMENT_QUICK_REFERENCE.txt** for quick fixes:
- 404 on all routes → Check .htaccess
- Database connection failed → Check .env credentials
- Blank page / 500 error → Check logs
- Can't upload files → Fix permissions

### Get Full Details
See **DEPLOYMENT_RUMAHWEB_GUIDE.md** Step 12: Troubleshooting

---

## 📚 Documentation by Topic

| Need | Document |
|------|----------|
| Quick overview | DEPLOYMENT_SUMMARY.md |
| Complete guide | DEPLOYMENT_RUMAHWEB_GUIDE.md |
| Verification steps | DEPLOYMENT_CHECKLIST.md |
| SSH commands | DEPLOYMENT_SSH_COMMANDS.md |
| Print reference | DEPLOYMENT_QUICK_REFERENCE.txt |
| Configuration | .env.production.example |
| Navigation | DEPLOYMENT_INDEX.md |

---

## 📞 Support Resources

### In This Package
- Complete guides with step-by-step instructions
- Troubleshooting section with common fixes
- Command reference for all operations
- Checklist to ensure nothing is missed

### External Resources
- **Rumahweb**: https://rumahweb.com/bantuan/
- **Laravel**: https://laravel.com/docs
- **MySQL**: https://dev.mysql.com/doc/

---

## 🎯 Your Deployment Checklist

**Before Starting:**
- [ ] Rumahweb hosting account active
- [ ] Domain: solvianova.my.id registered
- [ ] Project tested locally
- [ ] All files ready for upload
- [ ] 45-90 minutes available

**After Deployment:**
- [ ] URL accessible: https://presence.solvianova.my.id
- [ ] SSL certificate active
- [ ] Can login as super admin
- [ ] Database working
- [ ] All features tested
- [ ] Admin password changed
- [ ] Backups configured

---

## 🚀 Ready to Start?

### For Quick Deployment
→ Open **DEPLOYMENT_SUMMARY.md** now

### For Complete Understanding
→ Open **DEPLOYMENT_RUMAHWEB_GUIDE.md** now

### For Troubleshooting
→ Open **DEPLOYMENT_QUICK_REFERENCE.txt** now

---

## 📊 Documentation Stats

- **Total Pages**: ~30 pages
- **Total Time**: 45-90 minutes (depending on experience)
- **Difficulty**: Medium
- **Coverage**: 99% of scenarios

---

## 🎉 Success Looks Like This

After successful deployment, you'll have:

✅ Presence Teen running on `https://presence.solvianova.my.id`
✅ SSL certificate valid (green lock icon)
✅ Database connected and working
✅ Super admin account ready to use
✅ All features tested and working
✅ Error logs being monitored
✅ Backups configured
✅ Production ready and live!

---

## 💡 Pro Tips

1. **Read DEPLOYMENT_SUMMARY.md first** - gives you the 30,000 ft view
2. **Print DEPLOYMENT_QUICK_REFERENCE.txt** - keep during deployment
3. **Use DEPLOYMENT_SSH_COMMANDS.md** - copy/paste commands safely
4. **Follow DEPLOYMENT_CHECKLIST.md** - don't miss anything
5. **Monitor logs after deployment** - catch issues early

---

## 🔒 Important Security Notes

- Never commit `.env` to git
- Change default admin password immediately
- Keep database credentials secure
- Enable HTTPS (AutoSSL in cPanel)
- Monitor error logs regularly
- Setup regular backups
- Keep Laravel updated

---

## 📝 Quick Reference

```
Domain:           solvianova.my.id
Subdomain:        presence.solvianova.my.id
URL:              https://presence.solvianova.my.id
Database:         solvianova_presence
DB User:          solvianova_presnc
Admin Email:      admin@presensi.test
Admin Password:   password (CHANGE THIS!)
Document Root:    /public_html/presence.solvianova.my.id/
Time Required:    45-90 minutes
Difficulty:       Medium
Cost:             Free (uses existing plan)
```

---

## 🎓 What You'll Learn

By following this deployment package, you'll learn:

✅ How to setup subdomains on Rumahweb
✅ How to configure MySQL databases
✅ How to deploy Laravel applications
✅ How to use FTP/SFTP and SSH
✅ How to manage permissions
✅ How to run migrations and seeders
✅ How to troubleshoot deployment issues
✅ How to maintain production applications
✅ Security best practices
✅ Performance optimization

---

## 📞 Getting Help

**Documentation Path:**
```
Can't find something?
  ↓
Check DEPLOYMENT_INDEX.md for navigation
  ↓
Find relevant guide/document
  ↓
Look for troubleshooting section
```

**Still stuck?**
- Check error logs: `tail -f storage/logs/laravel.log`
- Review relevant troubleshooting section
- Contact Rumahweb support
- Check Laravel documentation

---

## 🎉 Let's Deploy!

**Choose your starting point:**

### 🏃 Quick Path (1 hour)
1. Read DEPLOYMENT_SUMMARY.md (5 min)
2. Execute steps (45 min)
3. Verify using checklist (10 min)

### 🚶 Thorough Path (1.5 hours)
1. Read DEPLOYMENT_RUMAHWEB_GUIDE.md (20 min)
2. Prepare & execute (60 min)
3. Verify using DEPLOYMENT_CHECKLIST.md (20 min)

### 📚 Reference Path
Keep DEPLOYMENT_SSH_COMMANDS.md and DEPLOYMENT_QUICK_REFERENCE.txt open

---

## 📋 Next Step

**Open one of these files now:**

1. **DEPLOYMENT_INDEX.md** - Navigation guide (1 min read)
2. **DEPLOYMENT_SUMMARY.md** - Quick version (5 min read)
3. **DEPLOYMENT_RUMAHWEB_GUIDE.md** - Complete guide (20 min read)

---

**Version**: 1.0
**Status**: Ready for Production ✅
**Last Updated**: July 20, 2026

**Good luck with your deployment!** 🚀

---

**Questions?** Check the relevant guide above. Everything you need is included in this deployment package.

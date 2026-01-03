# 🚀 Ahost/cPanel Deployment Guide for QattaBor

## Problem: Banners Not Showing on Production

### Why This Happens on cPanel:
1. cPanel's document root is usually `public_html/`
2. Laravel's public folder needs to be the web root
3. Storage symlink doesn't exist after deployment
4. File permissions may be incorrect

## ✅ Solution: Proper cPanel Setup

### Method 1: Subdomain Setup (Recommended)

1. **Upload Laravel project to home directory** (NOT public_html)
   ```
   /home/username/qattabor/
   ├── app/
   ├── config/
   ├── public/
   └── storage/
   ```

2. **Create subdomain in cPanel**
   - Go to cPanel → Domains → Create a New Domain
   - Domain: `qattabor.uz`
   - Document Root: `/home/username/qattabor/public`

3. **Create storage symlink via SSH or File Manager**
   ```bash
   cd /home/username/qattabor
   php artisan storage:link
   ```

### Method 2: Main Domain Setup

If you want to use the main domain:

1. **Upload to home directory**
   ```
   /home/username/qattabor/
   ```

2. **Move public contents to public_html**
   ```bash
   # Via SSH:
   cd /home/username
   mv public_html public_html_backup
   ln -s qattabor/public public_html
   ```
   
   OR edit index.php:
   
3. **Edit public_html/index.php**
   ```php
   require __DIR__.'/../qattabor/vendor/autoload.php';
   $app = require_once __DIR__.'/../qattabor/bootstrap/app.php';
   ```

### Method 3: Using File Manager (No SSH Access)

1. Upload project to: `/home/username/qattabor/`

2. Create `.htaccess` in root directory:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```

3. **Create storage symlink manually:**
   - In File Manager, go to: `/home/username/qattabor/public/`
   - Create a folder called `storage` (will replace with symlink)
   - Go to: `/home/username/qattabor/storage/app/public/`
   - Copy all contents
   - Paste into: `/home/username/qattabor/public/storage/`
   
   **OR use cPanel Terminal:**
   ```bash
   cd /home/username/qattabor
   php artisan storage:link
   ```

## 🔧 Essential Commands After Upload

```bash
# Set correct permissions
find /home/username/qattabor -type f -exec chmod 644 {} \;
find /home/username/qattabor -type d -exec chmod 755 {} \;
chmod -R 775 /home/username/qattabor/storage
chmod -R 775 /home/username/qattabor/bootstrap/cache

# Create storage link
php artisan storage:link

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

## 🐛 Debugging on Production

Visit: `https://qattabor.uz/check-banners`

This will show:
- ✅/❌ Storage symlink status
- ✅/❌ Banner files existence
- ✅/❌ Database banner records
- Direct links to test images

## 📝 Common Issues & Fixes

### Issue 1: 500 Internal Server Error
```bash
# Check storage permissions
chmod -R 775 storage bootstrap/cache

# Clear all caches
php artisan optimize:clear
```

### Issue 2: Banners Still Not Showing
```bash
# Verify storage link
ls -la public/storage

# If broken, recreate:
rm -rf public/storage
php artisan storage:link
```

### Issue 3: Images Return 404
- Make sure `.htaccess` exists in public folder
- Check if mod_rewrite is enabled in cPanel

### Issue 4: Using File Manager (No SSH)
1. Go to public/ folder
2. Delete `storage` if it exists
3. Create new folder: `storage`
4. Copy contents from: `../storage/app/public/banners/`
5. Paste into: `public/storage/banners/`

## 📂 Correct File Structure on Server

```
/home/username/
├── public_html/  (or domain root)
│   ├── index.php
│   ├── .htaccess
│   └── storage/  (symlink → ../storage/app/public/)
└── qattabor/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── public/
    │   ├── index.php
    │   ├── .htaccess
    │   └── storage/  (symlink)
    └── storage/
        └── app/
            └── public/
                └── banners/
                    ├── image1.png
                    └── image2.png
```

## 🎯 Quick Test

After deployment, test each URL:

1. Main site: `https://qattabor.uz`
2. Storage check: `https://qattabor.uz/check-banners`
3. Direct banner: `https://qattabor.uz/storage/banners/[filename].png`

If banner URL returns 404, the symlink is broken!

## 📞 Still Having Issues?

Check these files on server:
- `/home/username/qattabor/.env` (correct APP_URL)
- `/home/username/qattabor/public/storage` (must be symlink)
- `/home/username/qattabor/storage/app/public/banners/` (files exist)

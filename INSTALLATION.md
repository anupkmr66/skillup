# INSTALLATION.md

# SkillUp CIMS - Complete Installation Guide

## 📋 Prerequisites

Before installing SkillUp CIMS, ensure you have:

- **XAMPP 8.0+** (or WAMP/LAMP)
  - PHP 7.4 or higher
  - MySQL 5.7 or higher
  - Apache web server
- Modern web browser (Chrome, Firefox, Edge)
- At least 500MB free disk space

---

## 🚀 Quick Installation (5 Minutes)

### Step 1: Download and Extract

1. **Download** the `skillup` folder
2. **Extract** to XAMPP's `htdocs` directory:
   ```
   C:\xampp\htdocs\skillup\
   ```

### Step 2: Start Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Wait for both to show green "Running" status

### Step 3: Create Database

1. Open your browser
2. Go to: `http://localhost/phpmyadmin`
3. Click **"New"** in the left sidebar
4. Enter database name: `skillup`
5. Select collation: `utf8mb4_unicode_ci`
6. Click **"Create"**

### Step 4: Import Database

1. Click on the **`skillup`** database (left sidebar)
2. Click the **"Import"** tab at the top
3. Click **"Choose File"**
4. Navigate to: `C:\xampp\htdocs\skillup\database\migrations.sql`
5. Click **"Go"** at the bottom
6. Wait for the success message: ✅ "Import has been successfully finished"

### Step 5: Import Sample Data

1. Still in the **"Import"** tab
2. Click **"Choose File"** again
3. Navigate to: `C:\xampp\htdocs\skillup\database\seeders.sql`
4. Click **"Go"**
5. Wait for success message

You should see confirmation messages showing default credentials.

### Step 6: Access the System

1. Open browser
2. Go to: `http://localhost/skillup`
3. You should see the purple/blue gradient homepage! 🎉

### Step 7: Login

1. Click **"Login to Dashboard"**
2. Use these credentials:
   - **Username**: `admin`
   - **Password**: `Admin@123`
3. You're in! 🚀

---

## 🔐 All Default Credentials

| Role | Username | Password | Dashboard URL |
|------|----------|----------|---------------|
| **Super Admin** | admin | Admin@123 | /admin/dashboard |
| **Franchise Admin** | franchise_demo | Admin@123 | /franchise/dashboard |
| **Institute Admin** | institute_demo | Admin@123 | /institute/dashboard |
| **Teacher** | teacher_demo | Admin@123 | /teacher/dashboard |
| **Student** | student_demo | Admin@123 | /student/dashboard |

---

## ⚙️ Advanced Configuration

### Change Database Credentials

If your MySQL has a password or different settings:

1. Open: `C:\xampp\htdocs\skillup\config\database.php`
2. Edit:
   ```php
   return [
       'host' => 'localhost',
       'database' => 'skillup',
       'username' => 'root',        // Change if needed
       'password' => '',            // Add password if set
       'charset' => 'utf8mb4',
   ];
   ```
3. Save the file

### Change Application URL

If not using `localhost`:

1. Open: `C:\xampp\htdocs\skillup\config\app.php`
2. Edit:
   ```php
   'url' => 'http://localhost/skillup',  // Change to your URL
   ```
3. Save

### Enable URL Rewriting

The `.htaccess` files are already configured for clean URLs. If they don't work:

1. Open: `C:\xampp\apache\conf\httpd.conf`
2. Find: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Remove the `#` to uncomment it
4. Restart Apache in XAMPP

---

## 📁 Folder Permissions

For Windows (XAMPP), permissions are usually fine. If you encounter upload issues:

1. Right-click on: `C:\xampp\htdocs\skillup\storage`
2. Properties → Security → Edit
3. Give "Full Control" to "Users"
4. Apply to subfolders

---

## 🌐 Deploying to Live Server

### For Shared Hosting (cPanel)

1. **Upload Files:**
   - Compress `skillup` folder to ZIP
   - Upload via cPanel File Manager or FTP
   - Extract in `public_html/` or subdirectory

2. **Create Database:**
   - Go to cPanel → MySQL Databases
   - Create new database: `youruser_skillup`
   - Create MySQL user with password
   - Add user to database with ALL PRIVILEGES

3. **Import SQL:**
   - Go to cPanel → phpMyAdmin
   - Select your database
   - Import → Choose `migrations.sql`
   - Import → Choose `seeders.sql`

4. **Update Config:**
   - Edit `config/database.php`:
   ```php
   'host' => 'localhost',
   'database' => 'youruser_skillup',
   'username' => 'youruser_dbuser',
   'password' => 'your_db_password',
   ```

5. **Set Permissions:**
   - Set `storage/` to 755 or 777
   - Set `public/uploads/` to 755 or 777

6. **Access:**
   - `https://yourdomain.com` (if in root)
   - `https://yourdomain.com/skillup` (if in subdirectory)

### For VPS/Cloud (Linux)

```bash
# Install prerequisites
sudo apt update
sudo apt install apache2 php php-mysql mysql-server

# Clone or upload files
cd /var/www/html
# Upload skillup folder here

# Set ownership
sudo chown -R www-data:www-data skillup/
sudo chmod -R 755 skillup/
sudo chmod -R 777 skillup/storage/
sudo chmod -R 777 skillup/public/uploads/

# Enable Apache modules
sudo a2enmod rewrite
sudo systemctl restart apache2

# Create database
sudo mysql -u root -p
CREATE DATABASE skillup CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'skillup_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON skillup.* TO 'skillup_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Import SQL
mysql -u skillup_user -p skillup < /var/www/html/skillup/database/migrations.sql
mysql -u skillup_user -p skillup < /var/www/html/skillup/database/seeders.sql

# Configure Apache virtual host
sudo nano /etc/apache2/sites-available/skillup.conf
```

Add:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/skillup/public
    
    <Directory /var/www/html/skillup/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/skillup_error.log
    CustomLog ${APACHE_LOG_DIR}/skillup_access.log combined
</VirtualHost>
```

```bash
# Enable site and restart
sudo a2ensite skillup.conf
sudo systemctl restart apache2
```

---

## 🧪 Testing the Installation

### 1. Homepage Test
- Go to: `http://localhost/skillup`
- Should see gradient purple/blue background
- Should see 9 circular feature cards
- Should see "WITH FRANCHISE MANAGEMENT" badge

### 2. Login Test
- Click "Login to Dashboard"
- Enter: admin / Admin@123
- Should redirect to admin dashboard

### 3. Database Test
- Login as admin
- Dashboard should show:
  - Statistics cards (franchises, institutes, students)
  - Recent students table
  - Recent payments table

### 4. Sample Data Test
- Check that demo data exists:
  - 2 franchises
  - 3 institutes
  - 5 students
  - 8 courses
  - Sample payments

---

## 🐛 Troubleshooting

### Problem: "Database connection failed"
**Solution:**
- Check XAMPP MySQL is running
- Verify database name is exactly `skillup`
- Check `config/database.php` credentials
- Try default XAMPP: user=`root`, password=empty

### Problem: "404 Not Found" or white screen
**Solution:**
- Check `.htaccess` files exist in root and `/public`
- Enable mod_rewrite in Apache
- Check folder is in `htdocs/skillup/` not `htdocs/skillup/skillup/`

### Problem: "Table doesn't exist"
**Solution:**
- Re-import `migrations.sql`
- Check import completed without errors
- Verify you're using the correct database

### Problem: "Permission denied" on file upload
**Solution:**
- Set `storage/` and `public/uploads/` to 777 (Windows: Full Control)
- Check PHP `upload_max_filesize` and `post_max_size`

### Problem: Login works but dashboard is blank
**Solution:**
- Check browser console for JavaScript errors
- Verify CDN links are loading (Bootstrap, Font Awesome)
- Import `seeders.sql` for sample data
- Check PHP error logs in XAMPP

### Problem: CSS not loading / No styling
**Solution:**
- Clear browser cache (Ctrl+F5)
- Check `public/assets/css/custom.css` exists
- Verify URL in browser matches `BASE_URL` in config

---

## 📞 Post-Installation

### Change Default Passwords
**Important:** Change all default passwords immediately!

1. Login as each user
2. Go to Profile/Settings
3. Update password
4. Use strong passwords (8+ chars, mixed case, numbers, symbols)

### Configure Settings
1. Login as Super Admin
2. Go to Settings
3. Update:
   - Site name
   - Contact email
   - Contact phone
   - Address
   - Commission rates

### Add Your Data
1. Remove demo data (optional)
2. Add real franchises
3. Add real institutes
4. Add real courses
5. Enroll students

---

## ✅ Installation Checklist

- [ ] XAMPP installed and running
- [ ] Database `skillup` created
- [ ] `migrations.sql` imported successfully
- [ ] `seeders.sql` imported successfully
- [ ] Homepage loads at `http://localhost/skillup`
- [ ] Login page accessible
- [ ] Can login as admin
- [ ] Dashboard shows statistics
- [ ] Sample data visible
- [ ] All 5 user roles can login
- [ ] Default passwords changed

---

## 🎉 Success!

If all checklist items are ✅, your SkillUp CIMS is fully installed and ready!

**Next Steps:**
1. Explore the admin dashboard
2. Test different user roles
3. Add your first real franchise
4. Customize the system for your needs

**Enjoy your Computer Center Management System!** 🚀

---

**Need More Help?**
- Check `README.md` for features and usage
- Review code comments for customization
- Check PHP error logs: `C:\xampp\apache\logs\error.log`

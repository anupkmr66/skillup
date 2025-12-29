# SkillUp - Computer Center Management System

## 🎓 About

**SkillUp CIMS** is a comprehensive Computer Center Management System with Franchise Management capabilities. Built with **Core PHP (OOP + MVC)**, **MySQL**, and **Bootstrap 5**, this system is designed to manage computer training institutes, students, courses, fees, exams, certificates, and franchise operations efficiently.

## ✨ Features

### Core Modules
- ✅ **Unlimited Students** - Manage unlimited student registrations with auto-generated IDs
- ✅ **Unlimited Franchises** - Support multiple franchises with unique codes
- ✅ **Fees Management** - Track fees, payments, installments, and generate receipts
- ✅ **Certificate Verification** - Generate certificates with QR codes for public verification
- ✅ **Franchise Wallet** - Commission tracking, wallet balance, and withdrawal management
- ✅ **Admit Card, Exam & Result** - Complete examination system with result publishing
- ✅ **Courses & Study Material** - Course management with PDF/video uploads
- ✅ **Multiple User Login** - 5 different user roles with separate dashboards
- ✅ **Frontend Website** - Public-facing website with gradient design
- ✅ **And Many More Features** - Attendance, Reports, Analytics, Activity Logs

### User Roles
1. **Super Admin** - Complete system access and control
2. **Franchise Admin** - Manage franchises, institutes, and wallet
3. **Institute Admin** - Manage students, fees, and exams
4. **Teacher/Staff** - Handle batches, attendance, and study materials
5. **Student** - View profile, fees, results, and certificates

## 🛠️ Technology Stack

### Frontend
- HTML5
- CSS3 (Custom + Bootstrap 5)
- JavaScript (ES6)
- AJAX (Fetch API)
- AOS.js (Scroll Animations)
- Font Awesome 6 (Icons)
- DataTables (Data grids)
- SweetAlert2 (Alerts)

### Backend
- Core PHP 7.4+ (OOP + MVC Architecture)
- MySQL 5.7+ / MariaDB
- PDO (Database abstraction)

### Security
- PHP Sessions with timeout
- Password hashing (bcrypt)
- CSRF token protection
- Prepared SQL statements (SQL injection prevention)
- XSS protection (Input sanitization)
- Role-based access control (RBAC)

## 📦 Installation Guide

### Prerequisites
- **XAMPP** / **WAMP** / **LAMP** (PHP 7.4+, MySQL 5.7+)
- Web Browser (Chrome, Firefox, Edge)
- Text Editor (Optional, for customization)

### Step-by-Step Installation

#### 1. Download & Extract
- Download the `skillup` folder
- Place it in your XAMPP's `htdocs` directory
  ```
  C:\xampp\htdocs\skillup\
  ```

#### 2. Start XAMPP
- Open XAMPP Control Panel
- Start **Apache** and **MySQL** services

#### 3. Create Database
- Open browser and go to: `http://localhost/phpmyadmin`
- Click "New" to create a new database
- Database name: `skillup`
- Collation: `utf8mb4_unicode_ci`
- Click "Create"

#### 4. Import Database Schema
- Select the `skillup` database
- Click "Import" tab
- Click "Choose File"
- Navigate to: `C:\xampp\htdocs\skillup\database\migrations.sql`
- Click "Go" to import
- Wait for success message

#### 5. Import Sample Data (Optional but Recommended)
- Still in the "Import" tab
- Click "Choose File" again
- Navigate to: `C:\xampp\htdocs\skillup\database\seeders.sql`
- Click "Go" to import
- This will add demo users, courses, and sample data

#### 6. Configure Database Connection
- Open file: `C:\xampp\htdocs\skillup\config\database.php`
- Update credentials if needed (default works for XAMPP):
  ```php
  'host' => 'localhost',
  'database' => 'skillup',
  'username' => 'root',
  'password' => '',  // Empty for XAMPP
  ```

#### 7. Access the System
- Open browser and go to: `http://localhost/skillup`
- You should see the homepage with gradient purple/blue design

#### 8. Login to Dashboard
- Click "Login to Dashboard" button
- Use one of the demo credentials below

## 🔐 Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| **Super Admin** | `admin` | `Admin@123` |
| **Franchise Admin** | `franchise_demo` | `Admin@123` |
| **Institute Admin** | `institute_demo` | `Admin@123` |
| **Teacher** | `teacher_demo` | `Admin@123` |
| **Student** | `student_demo` | `Admin@123` |

⚠️ **Important**: Change these passwords after first login!

## 📁 Folder Structure

```
skillup/
├── app/
│   ├── Controllers/       # Application controllers
│   ├── Models/           # Database models
│   ├── Middleware/       # Authentication middleware
│   └── Helpers/          # Helper functions
├── config/
│   ├── database.php      # Database configuration
│   ├── app.php          # App settings
│   └── constants.php    # System constants
├── core/
│   ├── Database.php     # PDO connection
│   ├── Model.php        # Base model
│   ├── Controller.php   # Base controller
│   ├── Router.php       # URL routing
│   ├── Session.php      # Session management
│   └── CSRF.php         # CSRF protection
├── database/
│   ├── migrations.sql    # Database schema
│   └── seeders.sql      # Sample data
├── public/
│   ├── index.php        # Entry point
│   ├── assets/
│   │   ├── css/        # Stylesheets
│   │   └── js/         # JavaScript files
│   └── uploads/        # File uploads
├── routes/
│   └── web.php         # Route definitions
├── storage/
│   ├── logs/           # Application logs
│   └── uploads/        # Uploaded files
├── views/
│   ├── layouts/        # Master layouts
│   ├── auth/          # Login views
│   ├── admin/         # Admin dashboard
│   ├── franchise/     # Franchise views
│   ├── institute/     # Institute views
│   ├── teacher/       # Teacher views
│   ├── student/       # Student views
│   └── public/        # Public website
├── .htaccess          # URL rewriting
└── README.md          # This file
```

## 🚀 Quick Start Guide

### For Super Admin
1. Login with admin credentials
2. Add franchises from Admin Dashboard
3. Create institutes under franchises
4. Add courses
5. Enroll students
6. Manage fees and payments

### For Franchise Admin
1. Login with franchise credentials
2. View wallet balance and transactions
3. Manage own institutes
4. Request withdrawals
5. View commission reports

### For Students
1. Login with student credentials
2. View enrolled courses
3. Check fee status
4. View exam results
5. Download certificates

## 🔧 Configuration

### Change Application URL
Edit `config/app.php`:
```php
'url' => 'http://yourdomain.com',
```

### Change Upload Limits
Edit `config/app.php`:
```php
'upload' => [
    'max_size' => 5 * 1024 * 1024, // 5MB
],
```

### Email Configuration
For sending emails (optional), integrate PHPMailer in the system.

## 📊 Database Information

- **Total Tables**: 23
- **Database Engine**: InnoDB
- **Character Set**: utf8mb4
- **Collation**: utf8mb4_unicode_ci
- **Foreign Keys**: Yes (Referential integrity)
- **Indexes**: Optimized for performance

## 🔒 Security Features

- ✅ SQL Injection Protection (Prepared Statements)
- ✅ XSS Protection (Input Sanitization)
- ✅ CSRF Protection (Token Validation)
- ✅ Password Hashing (bcrypt)
- ✅ Session Hijacking Prevention
- ✅ Role-Based Access Control
- ✅ File Upload Validation
- ✅ Activity Logging

## 🌐 Deployment

### Shared Hosting
1. Upload files via FTP/cPanel
2. Create MySQL database via cPanel
3. Import SQL files
4. Update `config/database.php`
5. Access via your domain

### VPS/Cloud
1. Clone repository or upload files
2. Install PHP 7.4+ and MySQL
3. Configure virtual host
4. Import database
5. Set proper permissions (755 for storage/)
6. Configure SSL certificate (recommended)

## 📝 Customization

### Change Theme Colors
Edit `public/assets/css/custom.css`:
```css
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    /* Customize colors here */
}
```

### Add New Module
1. Create model in `app/Models/`
2. Create controller in `app/Controllers/`
3. Add routes in `routes/web.php`
4. Create views in `views/`

## 🐛 Troubleshooting

### Database Connection Error
- Check XAMPP MySQL is running
- Verify database credentials in `config/database.php`
- Ensure database `skillup` exists

### 404 Error / Blank Page
- Check `.htaccess` files exist
- Enable `mod_rewrite` in Apache
- Check file permissions

### Login Not Working
- Clear browser cache and cookies
- Check database has users table with data
- Verify session.save_path is writable

## 📞 Support

For issues or queries:
- Check database import was successful
- Verify all files are uploaded correctly
- Check PHP error logs in XAMPP

## 📄 License

This project is created for educational and commercial use.

## 🎯 Version

**Version**: 1.0.0  
**Release Date**: December 26, 2025  
**PHP Version**: 7.4+  
**MySQL Version**: 5.7+

---

**Developed with ❤️ for Computer Training Institutes**

*SkillUp - Empowering Education Through Technology*

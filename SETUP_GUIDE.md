# SkillUp CIMS - Quick Setup Guide

## ✅ All Files Fixed!

The system is now ready. Follow these steps:

---

## 📋 Setup Steps:

### 1. Create `.env` file
```bash
# Copy .env.example to .env
copy .env.example .env
```

### 2. Create Database
Open phpMyAdmin: `http://localhost/phpmyadmin`

Create database:
```sql
CREATE DATABASE skillup_cims;
```

### 3. Import Database
Import these files **in order**:
1. `database/migrations.sql` (creates tables)
2. `database/seeders.sql` (adds demo data)

### 4. Restart Apache
- Open XAMPP Control Panel
- Click "Stop" on Apache
- Click "Start" on Apache

---

## 🌐 Access URLs:

Use these URLs (with `/public/`):

- **Homepage:** `http://localhost/skillup/public/`
- **Login:** `http://localhost/skillup/public/login`
- **Admin Dashboard:** `http://localhost/skillup/public/admin/dashboard`

---

## 🔑 Login Credentials:

| Role | Username | Password |
|------|----------|----------|
| Super Admin | `admin` | `admin123` |
| Franchise | `franchise1` | `franchise123` |
| Institute | `institute1` | `institute123` |

---

## ✨ What's Fixed:

1. ✅ Login page - **complete form now showing**
2. ✅ No more scrolling issues
3. ✅ Corrected .env configuration
4. ✅ Fixed routing

---

## 🚀 Quick Test:

1. Go to: `http://localhost/skillup/public/login`
2. Login with: `admin` / `admin123`
3. You'll be redirected to admin dashboard

---

## ⚠️ Important Notes:

- **Always use `/public/` in URLs** for now
- Make sure Apache is running in XAMPP
- Make sure MySQL is running in XAMPP
- Database must be imported before login works

---

**System Status:** ✅ READY TO USE

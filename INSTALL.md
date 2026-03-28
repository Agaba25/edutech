# Detailed XAMPP Installation & Configuration Guide

## Step 1: Install XAMPP

### Download XAMPP
1. Visit https://www.apachefriends.org/
2. Download XAMPP for Windows (PHP 7.4 or higher recommended)
3. Choose the latest stable version

### Install XAMPP
1. Run the downloaded installer
2. Choose installation directory (default: `C:\xampp`)
3. Select components to install:
   - Apache
   - MySQL
   - PHP
   - phpMyAdmin
4. Complete the installation

### Verify Installation
1. Open XAMPP Control Panel
2. Click "Start" for Apache and MySQL
3. Both should show green status

## Step 2: Prepare Project Files

### Extract Project
1. Extract the `edutech.zip` file
2. Copy the `edutech` folder to `C:\xampp\htdocs\`
3. Final path should be: `C:\xampp\htdocs\edutech`

### Verify Folder Structure
\`\`\`
C:\xampp\htdocs\edutech\
├── config.php
├── index.php
├── database.sql
├── includes/
├── admin/
├── api/
├── assets/
└── ... (other files)
\`\`\`

## Step 3: Create Database

### Method 1: Using phpMyAdmin (Recommended)

1. **Open phpMyAdmin**
   - Start Apache and MySQL in XAMPP Control Panel
   - Open browser: http://localhost/phpmyadmin
   - You should see the phpMyAdmin interface

2. **Create Database**
   - Click "New" in the left sidebar
   - Database name: `edutech_db`
   - Collation: `utf8mb4_general_ci`
   - Click "Create"

3. **Import Database Schema**
   - Select the newly created `edutech_db` database
   - Click the "Import" tab
   - Click "Choose File"
   - Select `database.sql` from the project root
   - Click "Go"
   - Wait for import to complete (should show success message)

### Method 2: Using MySQL Command Line

1. **Open Command Prompt**
   - Press `Win + R`
   - Type `cmd` and press Enter

2. **Navigate to MySQL**
   \`\`\`
   cd C:\xampp\mysql\bin
   mysql -u root -p
   \`\`\`
   - Press Enter when prompted for password (default is empty)

3. **Create Database**
   \`\`\`sql
   CREATE DATABASE edutech_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   USE edutech_db;
   SOURCE C:/xampp/htdocs/edutech/database.sql;
   EXIT;
   \`\`\`

## Step 4: Configure Application

### Edit config.php

1. **Open File**
   - Navigate to `C:\xampp\htdocs\edutech\`
   - Right-click `config.php`
   - Open with Notepad or your text editor

2. **Update Database Settings**
   \`\`\`php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'edutech_db');
   \`\`\`

3. **Update Application URL** (if needed)
   \`\`\`php
   define('APP_URL', 'http://localhost/edutech');
   \`\`\`

4. **Save File**

## Step 5: Start Services

### Start XAMPP Services

1. **Open XAMPP Control Panel**
   - Click the XAMPP icon on your desktop or Start menu
   - Or navigate to `C:\xampp\xampp-control.exe`

2. **Start Apache**
   - Click "Start" button next to Apache
   - Status should turn green

3. **Start MySQL**
   - Click "Start" button next to MySQL
   - Status should turn green

### Verify Services
- Apache should show port 80 (or 8080 if port 80 is in use)
- MySQL should show port 3306

## Step 6: Test Installation

### Access Application

1. **Home Page**
   - Open browser
   - Go to: http://localhost/edutech/
   - You should see the EduTech home page

2. **Institutions Page**
   - Click "Institutions" in navigation
   - You should see the list of institutions with seed data

3. **Admin Login**
   - Go to: http://localhost/edutech/admin/login.php
   - Use credentials:
     - Email: `admin@edutech.local`
     - Password: `admin123`
   - You should see the admin dashboard

### Verify Database

1. **Check phpMyAdmin**
   - Go to: http://localhost/phpmyadmin
   - Select `edutech_db` database
   - You should see tables: users, institutions, programs, contact_messages
   - Each table should have seed data

## Step 7: Troubleshooting

### Apache Won't Start

**Problem**: Apache shows red status or won't start

**Solutions**:
1. Check if port 80 is in use:
   - Open Command Prompt
   - Type: `netstat -ano | findstr :80`
   - If something is using port 80, either:
     - Stop that service
     - Or configure Apache to use different port (8080)

2. Check Apache error log:
   - Navigate to `C:\xampp\apache\logs\error.log`
   - Look for error messages

3. Reinstall Apache:
   - Uninstall XAMPP
   - Restart computer
   - Reinstall XAMPP

### MySQL Won't Start

**Problem**: MySQL shows red status or won't start

**Solutions**:
1. Check if port 3306 is in use:
   - Open Command Prompt
   - Type: `netstat -ano | findstr :3306`

2. Check MySQL error log:
   - Navigate to `C:\xampp\mysql\data\`
   - Look for `.err` files

3. Reset MySQL:
   - Stop MySQL
   - Delete `C:\xampp\mysql\data\ibdata1`
   - Start MySQL again

### Database Import Failed

**Problem**: Error when importing database.sql

**Solutions**:
1. Check file encoding:
   - Ensure `database.sql` is UTF-8 encoded
   - Open in Notepad++ and check encoding

2. Check file size:
   - If file is very large, increase PHP limits in `php.ini`
   - Set: `upload_max_filesize = 100M`
   - Set: `post_max_size = 100M`

3. Import via command line instead:
   - Use Method 2 from Step 3

### Login Not Working

**Problem**: Admin login fails

**Solutions**:
1. Verify admin user exists:
   - Go to phpMyAdmin
   - Select `edutech_db` > `users` table
   - Check if `admin@edutech.local` exists

2. Reset admin password:
   - In phpMyAdmin, edit the admin user
   - Update password_hash to:
     \`\`\`
     $2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope
     \`\`\`
   - This is the hash for password: `admin123`

3. Clear browser cookies:
   - Clear all cookies for localhost
   - Try login again

### Pages Show Blank or Errors

**Problem**: Pages not loading or showing PHP errors

**Solutions**:
1. Check PHP error log:
   - Navigate to `C:\xampp\php\logs\php_error.log`
   - Look for error messages

2. Enable error display:
   - Open `C:\xampp\php\php.ini`
   - Find: `display_errors = Off`
   - Change to: `display_errors = On`
   - Restart Apache

3. Check file permissions:
   - Right-click `edutech` folder
   - Properties > Security
   - Ensure "Users" have "Read" and "Read & Execute" permissions

### 404 Errors

**Problem**: Getting 404 Not Found errors

**Solutions**:
1. Verify correct URL:
   - Should be: `http://localhost/edutech/`
   - Not: `http://localhost/edutech.php`

2. Check folder location:
   - Verify folder is in: `C:\xampp\htdocs\edutech`
   - Not in subdirectories

3. Check .htaccess:
   - If using URL rewriting, ensure Apache mod_rewrite is enabled
   - In XAMPP Control Panel, click Apache > Config > httpd.conf
   - Search for `mod_rewrite` and ensure it's uncommented

## Step 8: Post-Installation

### Change Admin Password

1. **Login to Admin**
   - Go to: http://localhost/edutech/admin/login.php
   - Use default credentials

2. **Change Password** (if user management page exists)
   - Go to admin dashboard
   - Click "Manage Users"
   - Edit admin user
   - Change password

3. **Or Update via phpMyAdmin**
   - Go to phpMyAdmin
   - Select `edutech_db` > `users` table
   - Edit admin user
   - Update password_hash using PHP:
     \`\`\`php
     password_hash('your_new_password', PASSWORD_BCRYPT)
     \`\`\`

### Customize Application

1. **Update App Name**
   - Edit `config.php`
   - Change: `define('APP_NAME', 'Your App Name');`

2. **Add Logo**
   - Place logo image in `assets/images/`
   - Update header.php to reference logo

3. **Customize Colors**
   - Edit `assets/css/style.css`
   - Update color variables

### Backup Database

1. **Export Database**
   - Go to phpMyAdmin
   - Select `edutech_db`
   - Click "Export"
   - Choose "SQL" format
   - Click "Go"
   - Save the file

2. **Schedule Regular Backups**
   - Create a backup folder
   - Export database weekly
   - Keep multiple versions

## Step 9: Deployment to Production

### Before Going Live

1. **Change Default Credentials**
   - Update admin password
   - Create new admin user

2. **Update Configuration**
   - Set `APP_ENV` to `production` in config.php
   - Disable error display
   - Update `APP_URL` to your domain

3. **Security Checks**
   - Ensure HTTPS is enabled
   - Update database credentials
   - Set proper file permissions
   - Remove test data

4. **Performance**
   - Enable caching
   - Optimize database queries
   - Minify CSS and JavaScript

### Upload to Hosting

1. **Connect via FTP**
   - Use FTP client (FileZilla, WinSCP, etc.)
   - Connect to your hosting server

2. **Upload Files**
   - Upload all files to public_html or www directory
   - Maintain folder structure

3. **Create Database**
   - Use hosting control panel (cPanel, Plesk, etc.)
   - Create MySQL database
   - Import database.sql

4. **Update Configuration**
   - Edit config.php with hosting database credentials
   - Update APP_URL to your domain

5. **Test**
   - Visit your domain
   - Test all functionality
   - Check admin login

## Support & Resources

- XAMPP Documentation: https://www.apachefriends.org/
- PHP Documentation: https://www.php.net/
- MySQL Documentation: https://dev.mysql.com/
- Bootstrap Documentation: https://getbootstrap.com/

## Common Commands

### MySQL Commands
\`\`\`bash
# Connect to MySQL
mysql -u root -p

# Show databases
SHOW DATABASES;

# Use database
USE edutech_db;

# Show tables
SHOW TABLES;

# Describe table
DESCRIBE users;

# Exit MySQL
EXIT;
\`\`\`

### File Permissions (Windows)
\`\`\`bash
# Open Command Prompt as Administrator
# Navigate to folder
cd C:\xampp\htdocs\edutech

# Grant permissions (if needed)
icacls . /grant Users:F /T
\`\`\`

## Final Checklist

- [ ] XAMPP installed and running
- [ ] Apache and MySQL services started
- [ ] Database created and imported
- [ ] config.php updated with correct credentials
- [ ] Project folder in correct location
- [ ] Home page loads at http://localhost/edutech/
- [ ] Admin login works with default credentials
- [ ] Institutions and programs display correctly
- [ ] Contact form works
- [ ] Admin dashboard accessible
- [ ] Database backup created

You're all set! Your EduTech application is ready to use.

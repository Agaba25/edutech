# XAMPP Installation and Setup Guide for EduCareer Project

This guide will walk you through setting up the EduCareer project on XAMPP step by step.

## Prerequisites

- Windows, macOS, or Linux operating system
- At least 2GB of free disk space
- Administrator/root access to your computer

---

## Step 1: Download and Install XAMPP

### 1.1 Download XAMPP

1. Visit the official XAMPP website: [https://www.apachefriends.org](https://www.apachefriends.org)
2. Download the latest version for your operating system (PHP 8.0 or higher recommended)
3. Choose the appropriate installer:
   - **Windows**: `xampp-windows-x64-installer.exe`
   - **macOS**: `xampp-osx-installer.dmg`
   - **Linux**: `xampp-linux-x64-installer.run`

### 1.2 Install XAMPP

**For Windows:**
1. Run the downloaded `.exe` file as Administrator
2. If prompted by Windows Defender or antivirus, allow the installation
3. Select components to install (ensure Apache, MySQL, PHP, and phpMyAdmin are checked)
4. Choose installation directory (default: `C:\xampp`)
5. Click "Next" through the installation wizard
6. Uncheck "Learn more about Bitnami" and finish installation

**For macOS:**
1. Open the downloaded `.dmg` file
2. Drag XAMPP to Applications folder
3. Open Terminal and run: `sudo chmod +x /Applications/XAMPP/xamppfiles/xampp`
4. Follow the installation prompts

**For Linux:**
1. Open Terminal in the download directory
2. Make the installer executable: `chmod +x xampp-linux-x64-installer.run`
3. Run the installer: `sudo ./xampp-linux-x64-installer.run`
4. Follow the installation prompts

---

## Step 2: Start XAMPP Services

### 2.1 Launch XAMPP Control Panel

**Windows:**
- Open XAMPP Control Panel from Start Menu or Desktop shortcut
- You may need to run it as Administrator

**macOS:**
- Open XAMPP from Applications folder
- Click "Manage Servers" tab

**Linux:**
- Open Terminal and run: `sudo /opt/lampp/lampp start`

### 2.2 Start Required Services

1. Start **Apache** web server:
   - Click "Start" button next to Apache
   - Wait for the status to turn green
   - Default port: 80 (if port 80 is busy, change to 8080 in Config)

2. Start **MySQL** database server:
   - Click "Start" button next to MySQL
   - Wait for the status to turn green
   - Default port: 3306

### 2.3 Verify Services are Running

1. Open your web browser
2. Navigate to: `http://localhost`
3. You should see the XAMPP welcome page
4. Navigate to: `http://localhost/phpmyadmin`
5. You should see the phpMyAdmin interface

---

## Step 3: Extract Project Files

### 3.1 Locate XAMPP htdocs Folder

The `htdocs` folder is where all web projects are stored:

- **Windows**: `C:\xampp\htdocs\`
- **macOS**: `/Applications/XAMPP/xamppfiles/htdocs/`
- **Linux**: `/opt/lampp/htdocs/`

### 3.2 Extract Project

1. Extract the EduCareer project ZIP file
2. Rename the extracted folder to `edutech` (or your preferred name)
3. Copy/Move the `edutech` folder into the `htdocs` directory
4. Your project path should be: `htdocs/edutech/`

### 3.3 Verify File Structure

Your `htdocs/edutech/` folder should contain:
\`\`\`
edutech/
├── admin/
├── api/
├── assets/
├── includes/
├── config.php
├── index.php
├── course-finder.php
├── database.sql
├── database_courses_enhanced.sql
└── ... (other files)
\`\`\`

---

## Step 4: Create Database

### 4.1 Access phpMyAdmin

1. Open your web browser
2. Navigate to: `http://localhost/phpmyadmin`
3. You should see the phpMyAdmin dashboard

### 4.2 Import Database Schema

**Method 1: Using SQL Import (Recommended)**

1. In phpMyAdmin, click on the "SQL" tab at the top
2. Open the `database.sql` file from your project folder in a text editor
3. Copy all the SQL code
4. Paste it into the SQL query box in phpMyAdmin
5. Click "Go" button at the bottom
6. Wait for success message: "Database educareer_db created successfully"

7. Repeat for additional tables:
   - Click "SQL" tab again
   - Open `database_courses_enhanced.sql`
   - Copy and paste the SQL code
   - Click "Go"

**Method 2: Using Import Feature**

1. Click on "Import" tab in phpMyAdmin
2. Click "Choose File" button
3. Select `database.sql` from your project folder
4. Scroll down and click "Go"
5. Wait for import to complete
6. Repeat for `database_courses_enhanced.sql`

### 4.3 Verify Database Creation

1. In phpMyAdmin left sidebar, you should see `educareer_db`
2. Click on `educareer_db` to expand it
3. You should see tables like:
   - users
   - institutions
   - programs
   - courses
   - contact_messages
   - scholarships
   - careers
   - etc.

---

## Step 5: Configure Project Settings

### 5.1 Verify Database Configuration

1. Open `includes/Config.php` in a text editor
2. Verify the database settings:
   \`\`\`php
   'DB_HOST' => 'localhost',
   'DB_USER' => 'root',
   'DB_PASS' => '',
   'DB_NAME' => 'educareer_db',
   \`\`\`

3. **If you set a MySQL password during XAMPP installation:**
   - Change `'DB_PASS' => ''` to `'DB_PASS' => 'your_password'`

### 5.2 Update Application URL (if needed)

If you renamed the project folder to something other than `edutech`:

1. Open `includes/Config.php`
2. Update the APP_URL:
   \`\`\`php
   'APP_URL' => 'http://localhost/your_folder_name',
   \`\`\`

---

## Step 6: Test the Application

### 6.1 Access the Homepage

1. Open your web browser
2. Navigate to: `http://localhost/edutech`
3. You should see the EduCareer homepage

### 6.2 Test Key Features

**Test Course Finder:**
1. Navigate to: `http://localhost/edutech/course-finder.php`
2. Fill in A-Level results
3. Select interests
4. Click "Find My Courses"
5. Verify course recommendations appear

**Test Admin Panel:**
1. Navigate to: `http://localhost/edutech/admin/login.php`
2. Login credentials:
   - Email: `admin@edutech.local`
   - Password: `admin123`
3. You should access the admin dashboard

**Test Other Pages:**
- Institutions: `http://localhost/edutech/institutions.php`
- Programs: `http://localhost/edutech/programs.php`
- Scholarship Hub: `http://localhost/edutech/scholarship-hub.php`
- Career Guidance: `http://localhost/edutech/career-guidance.php`
- Contact: `http://localhost/edutech/contact.php`

---

## Step 7: Troubleshooting Common Issues

### Issue 1: Apache Won't Start

**Cause**: Port 80 is already in use (often by Skype, IIS, or other services)

**Solution:**
1. Open XAMPP Control Panel
2. Click "Config" button next to Apache
3. Select "httpd.conf"
4. Find line: `Listen 80`
5. Change to: `Listen 8080`
6. Save and restart Apache
7. Access site at: `http://localhost:8080/edutech`

### Issue 2: MySQL Won't Start

**Cause**: Port 3306 is already in use

**Solution:**
1. Open XAMPP Control Panel
2. Click "Config" button next to MySQL
3. Select "my.ini"
4. Find line: `port=3306`
5. Change to: `port=3307`
6. Save and restart MySQL
7. Update `includes/Config.php`: `'DB_HOST' => 'localhost:3307'`

### Issue 3: "Access Denied" Database Error

**Cause**: Incorrect database credentials

**Solution:**
1. Open phpMyAdmin
2. Click "User accounts" tab
3. Check if 'root' user exists with no password
4. If password is set, update `includes/Config.php` with correct password

### Issue 4: Blank White Page

**Cause**: PHP errors not displaying

**Solution:**
1. Open `config.php`
2. Verify error reporting is enabled:
   \`\`\`php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   \`\`\`
3. Check Apache error logs:
   - Windows: `C:\xampp\apache\logs\error.log`
   - macOS/Linux: `/opt/lampp/logs/error_log`

### Issue 5: Database Not Found

**Cause**: Database not created or wrong name

**Solution:**
1. Open phpMyAdmin
2. Verify `educareer_db` exists in left sidebar
3. If not, re-import `database.sql`
4. Verify database name in `includes/Config.php` matches

### Issue 6: Course Finder Not Working

**Cause**: Courses table not created

**Solution:**
1. Open phpMyAdmin
2. Select `educareer_db`
3. Check if `courses` table exists
4. If not, import `database_courses_enhanced.sql`

---

## Step 8: File Permissions (macOS/Linux Only)

If you encounter permission errors:

\`\`\`bash
# Navigate to project directory
cd /Applications/XAMPP/xamppfiles/htdocs/edutech
# or for Linux: cd /opt/lampp/htdocs/edutech

# Set proper permissions
sudo chmod -R 755 .
sudo chown -R daemon:daemon .
\`\`\`

---

## Step 9: Security Recommendations

### For Development:

1. **Keep default settings** - Easy testing and development

### For Production (if deploying online):

1. **Change Admin Password:**
   - Login to admin panel
   - Navigate to user management
   - Change default password

2. **Set MySQL Root Password:**
   - Open phpMyAdmin
   - Go to User accounts
   - Edit 'root' user
   - Set a strong password
   - Update `includes/Config.php` with new password

3. **Disable Error Display:**
   - Open `includes/Config.php`
   - Change `'APP_ENV' => 'production'`

4. **Enable HTTPS:**
   - Configure SSL certificate in Apache
   - Update `'APP_URL'` to use `https://`

---

## Step 10: Stopping XAMPP

When you're done working:

**Windows:**
1. Open XAMPP Control Panel
2. Click "Stop" for Apache and MySQL

**macOS:**
1. Open XAMPP Manager
2. Click "Stop All"

**Linux:**
\`\`\`bash
sudo /opt/lampp/lampp stop
\`\`\`

---

## Quick Reference

### Important URLs:
- **Homepage**: `http://localhost/edutech`
- **Admin Login**: `http://localhost/edutech/admin/login.php`
- **phpMyAdmin**: `http://localhost/phpmyadmin`
- **Course Finder**: `http://localhost/edutech/course-finder.php`

### Default Credentials:
- **Admin Panel**:
  - Email: `admin@edutech.local`
  - Password: `admin123`
  
- **MySQL (phpMyAdmin)**:
  - Username: `root`
  - Password: (empty by default)

### Important Files:
- **Database Config**: `includes/Config.php`
- **Database Schema**: `database.sql`, `database_courses_enhanced.sql`
- **Main Config**: `config.php`

### XAMPP Directories:
- **Windows**: `C:\xampp\htdocs\edutech`
- **macOS**: `/Applications/XAMPP/xamppfiles/htdocs/edutech`
- **Linux**: `/opt/lampp/htdocs/edutech`

---

## Getting Help

If you encounter issues not covered in this guide:

1. Check Apache error logs (see Issue 4 above)
2. Check PHP error logs in XAMPP control panel
3. Verify all XAMPP services are running (green status)
4. Ensure database tables are created correctly
5. Clear browser cache and try again

---

## Next Steps

Once everything is working:

1. Explore the admin panel to add institutions and programs
2. Test the course finder with different A-Level combinations
3. Customize the design in `assets/css/style.css`
4. Add more courses in the database for better recommendations
5. Test all features thoroughly before deployment

---

**Congratulations!** Your EduCareer project should now be running successfully on XAMPP.

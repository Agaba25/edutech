# XAMPP Setup Guide for Enhanced Course Finder

## Step-by-Step Installation and Setup

### Prerequisites
- XAMPP installed on your Windows system
- A web browser (Chrome, Firefox, Edge, etc.)

---

## STEP 1: Start XAMPP Services

1. **Open XAMPP Control Panel**
   - Search for "XAMPP Control Panel" in Windows Start Menu
   - Right-click and select "Run as administrator"

2. **Start Apache and MySQL**
   - Click the "Start" button next to **Apache**
   - Click the "Start" button next to **MySQL**
   - Both should show green "Running" status

---

## STEP 2: Locate Your Project Directory

1. **Navigate to XAMPP htdocs folder**
   - Default location: `C:\xampp\htdocs\`
   - If your project is in a different location, note the full path

2. **Verify your project folder exists**
   - Your project should be at: `C:\xampp\htdocs\edutech\`
   - If not, copy your project to this location

---

## STEP 3: Import Database

### Option A: Using phpMyAdmin (Recommended)

1. **Open phpMyAdmin**
   - Open your browser
   - Go to: `http://localhost/phpmyadmin`
   - You should see the phpMyAdmin interface

2. **Create Database**
   - Click on "New" in the left sidebar
   - Enter database name: `edutech_db`
   - Click "Create"

3. **Import Main Database**
   - Click on `edutech_db` in the left sidebar
   - Click the "Import" tab at the top
   - Click "Choose File" button
   - Navigate to: `C:\xampp\htdocs\edutech\database_enhanced.sql`
   - Click "Go" button
   - Wait for success message

4. **Import Courses Database**
   - Stay in the `edutech_db` database
   - Click "Import" tab again
   - Choose file: `database_courses_enhanced.sql`
   - Click "Go" button
   - Wait for success message

### Option B: Using Command Line (Alternative)

1. **Open Command Prompt**
   - Press `Win + R`
   - Type `cmd` and press Enter

2. **Navigate to project directory**
   \`\`\`bash
   cd C:\xampp\htdocs\edutech
   \`\`\`

3. **Import databases**
   \`\`\`bash
   C:\xampp\mysql\bin\mysql.exe -u root -p -e "CREATE DATABASE IF NOT EXISTS edutech_db;"
   C:\xampp\mysql\bin\mysql.exe -u root edutech_db < database_enhanced.sql
   C:\xampp\mysql\bin\mysql.exe -u root edutech_db < database_courses_enhanced.sql
   \`\`\`

---

## STEP 4: Verify Database Configuration

1. **Check config file**
   - Open: `C:\xampp\htdocs\edutech\includes\Config.php`
   - Verify database settings:
   \`\`\`php
   'host' => 'localhost',
   'user' => 'root',
   'password' => '',  // Leave empty for XAMPP default
   'database' => 'edutech_db'
   \`\`\`

2. **Or check config.php directly**
   - Open: `C:\xampp\htdocs\edutech\config.php`
   - Ensure it's loading the Config class properly

---

## STEP 5: Test Your Installation

1. **Open the Application**
   - Open your browser
   - Go to: `http://localhost/edutech/`
   - You should see the home page

2. **Test Course Finder**
   - Click on "Course Finder" in the navigation menu
   - Or go directly to: `http://localhost/edutech/course-finder.php`
   - You should see the enhanced course finder form

3. **Test the Matching System**
   - Fill in the form with sample data:
     - **Principal 1**: Biology, Grade A
     - **Principal 2**: Chemistry, Grade A
     - **Principal 3**: Physics, Grade B
     - **General Paper**: Pass
     - **Subsidiary**: Pass
     - **Interests**: Medicine & Health Sciences, Science & Technology
   - Click "Find My Courses"
   - You should see course recommendations

---

## STEP 6: Troubleshooting Common Issues

### Issue: "Connection refused" or "Can't connect to MySQL"

**Solution:**
1. Open XAMPP Control Panel
2. Make sure MySQL is running (green status)
3. If not, click "Start" next to MySQL
4. If it fails to start, click "Stop" and then "Start" again
5. Check if port 3306 is available

### Issue: "Database not found"

**Solution:**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Check if `edutech_db` exists in the database list
3. If not, re-import the SQL files following Step 3

### Issue: "Access denied for user 'root'@'localhost'"

**Solution:**
1. Check your `Config.php` file
2. For XAMPP default setup, password should be empty: `'password' => ''`
3. If you set a password for root, update it in Config.php

### Issue: Page shows but course finder form doesn't work

**Solution:**
1. Open browser developer tools (F12)
2. Go to "Console" tab
3. Look for JavaScript errors
4. Check "Network" tab for failed requests
5. Verify that `api/course-matching.php` is accessible

### Issue: "No courses found"

**Solution:**
1. Verify course data was imported:
   - Go to phpMyAdmin
   - Select `edutech_db` database
   - Check if `courses` table has data
   - Should see at least 8 courses
2. If empty, re-import `database_courses_enhanced.sql`

### Issue: Port conflicts

**Solution:**
1. If Apache won't start on port 80:
   - Open `C:\xampp\apache\conf\httpd.conf`
   - Find `Listen 80`
   - Change to `Listen 8080`
   - Restart Apache
   - Access via: `http://localhost:8080/edutech/`

---

## STEP 7: Verify All Files Are Present

Check these files exist in `C:\xampp\htdocs\edutech\`:

\`\`\`
✅ course-finder.php (enhanced version)
✅ api/course-matching.php (new file)
✅ database_enhanced.sql
✅ database_courses_enhanced.sql
✅ includes/Config.php
✅ includes/Database.php
✅ includes/header.php
✅ includes/footer.php
✅ config.php
✅ index.php (homepage)
✅ assets/css/style.css (with hero styling)
\`\`\`

## IMPORTANT: A-Level Weighting System

The course matching system uses the official Uganda Public Universities weighting:

- **Essential Subjects**: Multiplied by **x3** (must pass)
- **Relevant Subjects**: Multiplied by **x2** (preferred)
- **Desirable Subjects**: Multiplied by **x1** (bonus)

Example: Biology (A=6) as Essential = 6 x 3 = 18 points

## Course Finder Features

✅ A-Level Results Input (3 Principal subjects + grades)  
✅ General Paper (Pass/Fail)  
✅ Subsidiary Subject (Pass/Fail)  
✅ Interest Selection (max 3 choices)  
✅ Sophisticated Matching Algorithm  
✅ University & Scholarship Recommendations  
✅ Match Percentage Display  
✅ Form Data Persistence (localStorage)

---

## Quick Start Commands

Once everything is set up, you only need to:

1. **Start XAMPP** (if not running)
2. **Open browser** → `http://localhost/edutech/`
3. **Navigate to Course Finder** and test

---

## Testing Checklist

- [ ] XAMPP Apache is running (green status)
- [ ] XAMPP MySQL is running (green status)
- [ ] Database `edutech_db` exists in phpMyAdmin
- [ ] `courses` table has at least 8 records
- [ ] Homepage loads without errors
- [ ] Course Finder page loads with form
- [ ] Form validation works (prevents submission without data)
- [ ] Interest selection limits to 3 choices
- [ ] Course matching returns results
- [ ] Results display with match percentage
- [ ] University links are clickable

---

## Support

If you encounter issues:
1. Check the browser console (F12) for errors
2. Check XAMPP error logs:
   - Apache logs: `C:\xampp\apache\logs\error.log`
   - MySQL logs: `C:\xampp\mysql\data\mysql_error.log`
3. Verify all files are in the correct directories
4. Ensure file permissions allow reading

---

## Success Indicators

✅ XAMPP services running (green)
✅ No errors in browser console
✅ Database imported successfully
✅ Course Finder form displays correctly
✅ Course matching returns results
✅ Match percentages show correctly
✅ All navigation links work

---

**You're all set! Enjoy your enhanced Course Finder!** 🎓

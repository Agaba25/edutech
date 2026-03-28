# MyCareer Link - Installation Guide for XAMPP

This guide will help you set up the MyCareer Link educational platform on your local XAMPP server.

## Prerequisites

- XAMPP (Apache, MySQL, PHP) installed on your system
- Web browser (Chrome, Firefox, Safari, etc.)
- Text editor (optional, for code modifications)

## Step-by-Step Installation

### Step 1: Download and Install XAMPP

1. **Download XAMPP**
   - Visit [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
   - Download the latest version for your operating system (Windows, macOS, or Linux)
   - Run the installer and follow the installation wizard

2. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL** services
   - Ensure both services are running (green status)

### Step 2: Set Up the Project

1. **Navigate to XAMPP Directory**
   - Open your XAMPP installation folder
   - Navigate to `htdocs` folder
   - This is typically located at:
     - Windows: `C:\xampp\htdocs\`
     - macOS: `/Applications/XAMPP/htdocs/`
     - Linux: `/opt/lampp/htdocs/`

2. **Create Project Folder**
   - Create a new folder named `edutech1` in the `htdocs` directory
   - Copy all project files into this folder
   - Your project structure should look like:
   \`\`\`
   htdocs/
   └── edutech1/
       ├── admin/
       ├── api/
       ├── assets/
       ├── includes/
       ├── public/
       ├── index.php
       ├── config.php
       ├── database.sql
       └── ... (other files)
   \`\`\`

### Step 3: Database Setup

1. **Access phpMyAdmin**
   - Open your web browser
   - Navigate to `http://localhost/phpmyadmin`
   - You should see the phpMyAdmin interface

2. **Create Database**
   - Click on "New" in the left sidebar
   - Enter database name: `edutech_db`
   - Select collation: `utf8mb4_general_ci`
   - Click "Create"

3. **Import Database Schema**
   - Select the `edutech_db` database
   - Click on "Import" tab
   - Click "Choose File" and select `database.sql` from your project folder
   - Click "Go" to import the database structure and sample data

### Step 4: Configure the Application

1. **Update Configuration (if needed)**
   - Open `includes/Config.php` in a text editor
   - Verify the database settings:
     \`\`\`php
     'DB_HOST' => 'localhost',
     'DB_USER' => 'root',
     'DB_PASS' => '',
     'DB_NAME' => 'edutech_db',
     \`\`\`
   - Update `APP_URL` if needed:
     \`\`\`php
     'APP_URL' => 'http://localhost/edutech1',
     \`\`\`

### Step 5: Test the Installation

1. **Access the Application**
   - Open your web browser
   - Navigate to `http://localhost/edutech1`
   - You should see the MyCareer Link homepage

2. **Test Key Features**
   - **Homepage**: Should display the main page with statistics
   - **Institutions**: Click "Institutions" to browse educational institutions
   - **Programs**: Click "Programs" to view available programs
   - **Course Finder**: Click "Course Finder" to test the quiz functionality
   - **Scholarship Hub**: Click "Scholarship Hub" to view scholarships
   - **Career Guidance**: Click "Career Guidance" to explore career paths

3. **Test Admin Panel**
   - Navigate to `http://localhost/edutech1/admin/login.php`
   - Use the demo credentials:
     - **Email**: `admin@edutech.local`
     - **Password**: `admin123`
   - You should be able to access the admin dashboard

### Step 6: Troubleshooting

#### Common Issues and Solutions

1. **"Database connection failed" error**
   - Ensure MySQL service is running in XAMPP
   - Check database credentials in `includes/Config.php`
   - Verify database `edutech_db` exists in phpMyAdmin

2. **"Page not found" or 404 errors**
   - Ensure Apache service is running
   - Check that files are in the correct `htdocs/edutech1` folder
   - Verify the URL: `http://localhost/edutech1`

3. **CSS/JavaScript not loading**
   - Check browser console for errors
   - Ensure all files are properly uploaded
   - Clear browser cache and refresh

4. **Permission errors**
   - Ensure XAMPP has proper permissions to read files
   - On Windows, run XAMPP as administrator if needed

#### File Permissions (Linux/macOS)
\`\`\`bash
chmod -R 755 /path/to/edutech1/
chmod -R 644 /path/to/edutech1/*.php
\`\`\`

### Step 7: Development Tips

1. **Enable Error Reporting**
   - The application is configured to show errors in development mode
   - Check `includes/Config.php` for error reporting settings

2. **Database Management**
   - Use phpMyAdmin for database management
   - Backup your database regularly
   - Export/import data as needed

3. **File Editing**
   - Use a code editor like VS Code, Sublime Text, or Notepad++
   - Enable syntax highlighting for PHP files
   - Use version control (Git) for code management

### Step 8: Production Deployment

When ready to deploy to a live server:

1. **Update Configuration**
   - Change `APP_ENV` to `'production'` in `includes/Config.php`
   - Update database credentials for production
   - Set proper `APP_URL` for your domain

2. **Security Considerations**
   - Change default admin password
   - Enable HTTPS
   - Set proper file permissions
   - Regular security updates

## Default Login Credentials

- **Admin Email**: `admin@edutech.local`
- **Admin Password**: `admin123`

**Important**: Change these credentials after installation for security.

## Project Structure

\`\`\`
edutech1/
├── admin/              # Admin panel files
├── api/               # API endpoints
├── assets/            # CSS, JS, images
├── includes/          # PHP classes and functions
├── public/            # Public pages (Course Finder, etc.)
├── index.php          # Homepage
├── config.php         # Main configuration
├── database.sql       # Database schema
└── INSTALLATION_GUIDE.md
\`\`\`

## Support

If you encounter any issues:

1. Check the error logs in XAMPP
2. Verify all services are running
3. Ensure all files are properly uploaded
4. Check database connection settings

## Features Overview

- **Homepage**: Modern landing page with statistics and features
- **Institutions**: Browse educational institutions with filtering
- **Programs**: View certificate and diploma programs
- **Course Finder**: Interactive quiz for course recommendations
- **Scholarship Hub**: Browse available scholarships
- **Career Guidance**: Explore career paths and job market info
- **Admin Panel**: Manage institutions, programs, and content

## Next Steps

After successful installation:

1. Explore all features of the platform
2. Add your own institutions and programs
3. Customize the design and content
4. Set up proper admin credentials
5. Consider adding more advanced features

---

**Congratulations!** You have successfully installed MyCareer Link on your local XAMPP server. The platform is now ready for development and testing.

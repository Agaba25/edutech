<!DOCTYPE html>
<html>
<head>
    <title>Fix Login Issue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Fix Login Issue</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Script to fix login issues by ensuring the database and admin user exist

                        require_once 'config.php';
                        require_once 'includes/Database.php';

                        echo "<h4>Fixing Login Issue</h4>\n";

                        try {
                            // Load configuration
                            Config::load();
                            
                            echo "<p class='text-success'>Configuration loaded successfully</p>\n";
                            echo "<p>Attempting to connect to database: " . Config::get('DB_NAME') . "</p>\n";
                            
                            // Get database instance
                            $db = Database::getInstance();
                            echo "<p class='text-success'>Database connection successful!</p>\n";
                            
                            // Check if database exists, if not create it
                            echo "<p>Checking if database exists...</p>\n";
                            $databases = $db->fetchAll("SHOW DATABASES LIKE '" . Config::get('DB_NAME') . "'");
                            
                            if (empty($databases)) {
                                echo "<p class='text-warning'>Database does not exist. Creating it...</p>\n";
                                $db->execute("CREATE DATABASE `" . Config::get('DB_NAME') . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
                                echo "<p class='text-success'>Database created successfully!</p>\n";
                            } else {
                                echo "<p class='text-success'>Database exists.</p>\n";
                            }
                            
                            // Select the database
                            $db->execute("USE `" . Config::get('DB_NAME') . "`");
                            
                            // Check if users table exists
                            echo "<p>Checking if users table exists...</p>\n";
                            $tables = $db->fetchAll("SHOW TABLES LIKE 'users'");
                            
                            if (empty($tables)) {
                                echo "<p class='text-warning'>Users table does not exist. Creating it...</p>\n";
                                $db->execute("
                                    CREATE TABLE `users` (
                                      `id` INT AUTO_INCREMENT PRIMARY KEY,
                                      `name` VARCHAR(100) NOT NULL,
                                      `email` VARCHAR(100) UNIQUE NOT NULL,
                                      `password_hash` VARCHAR(255) NOT NULL,
                                      `role` ENUM('admin', 'user') DEFAULT 'user',
                                      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                      INDEX `idx_email` (`email`),
                                      INDEX `idx_role` (`role`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
                                ");
                                echo "<p class='text-success'>Users table created successfully!</p>\n";
                            } else {
                                echo "<p class='text-success'>Users table exists.</p>\n";
                            }
                            
                            // Check if admin user exists
                            echo "<p>Checking if admin user exists...</p>\n";
                            $adminUser = $db->fetchOne("SELECT * FROM users WHERE email = ?", ['admin@edutech.local']);
                            
                            if (!$adminUser) {
                                echo "<p class='text-warning'>Admin user does not exist. Creating it...</p>\n";
                                // Hash for password "admin123"
                                $passwordHash = '$2y$10$YIjlrPNoS0E9IeaVrcemCOYvxijrQWXVVmMvqIYeNLsN8/LewKope';
                                $db->execute(
                                    "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)",
                                    ['Admin User', 'admin@edutech.local', $passwordHash, 'admin']
                                );
                                echo "<p class='text-success'>Admin user created successfully!</p>\n";
                            } else {
                                echo "<p class='text-success'>Admin user already exists.</p>\n";
                                echo "<p><strong>User ID:</strong> " . $adminUser['id'] . "</p>\n";
                                echo "<p><strong>Email:</strong> " . $adminUser['email'] . "</p>\n";
                                echo "<p><strong>Role:</strong> " . $adminUser['role'] . "</p>\n";
                            }
                            
                            echo "<div class='alert alert-success mt-4'>\n";
                            echo "<h5>Fix completed!</h5>\n";
                            echo "<p>You should now be able to login with:</p>\n";
                            echo "<p><strong>Email:</strong> admin@edutech.local</p>\n";
                            echo "<p><strong>Password:</strong> admin123</p>\n";
                            echo "<a href='admin/login.php' class='btn btn-primary'>Go to Admin Login</a>\n";
                            echo "</div>\n";
                            
                        } catch (Exception $e) {
                            echo "<div class='alert alert-danger'>\n";
                            echo "<h5>Error:</h5>\n";
                            echo "<p>" . $e->getMessage() . "</p>\n";
                            echo "<pre>" . $e->getTraceAsString() . "</pre>\n";
                            echo "</div>\n";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
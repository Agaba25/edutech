<?php
// Script to change the admin password

require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';

// Load configuration
Config::load();

echo "<h1>Change Admin Password</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($newPassword)) {
        echo "<p style='color: red;'>Password cannot be empty!</p>";
    } elseif ($newPassword !== $confirmPassword) {
        echo "<p style='color: red;'>Passwords do not match!</p>";
    } elseif (strlen($newPassword) < 6) {
        echo "<p style='color: red;'>Password must be at least 6 characters long!</p>";
    } else {
        try {
            // Get database instance
            $db = Database::getInstance();
            
            // Select the database
            $db->execute("USE `" . Config::get('DB_NAME') . "`");
            
            // Hash the new password
            $hashedPassword = Auth::hashPassword($newPassword);
            
            // Update the admin user's password
            $stmt = $db->execute(
                "UPDATE users SET password_hash = ? WHERE email = ?",
                [$hashedPassword, 'admin@edutech.local']
            );
            
            if ($stmt) {
                echo "<p style='color: green;'>Password changed successfully!</p>";
                echo "<p>New credentials:</p>";
                echo "<p><strong>Email:</strong> admin@edutech.local</p>";
                echo "<p><strong>Password:</strong> " . htmlspecialchars($newPassword) . "</p>";
            } else {
                echo "<p style='color: red;'>Failed to change password!</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<form method="POST">
    <div>
        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required minlength="6">
    </div>
    <br>
    <div>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
    </div>
    <br>
    <div>
        <input type="submit" value="Change Password" class="btn btn-primary">
    </div>
</form>

<p><a href="admin/login.php">Go to Admin Login</a></p>
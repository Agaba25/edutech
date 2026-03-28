<?php
require_once '../config.php';
require_once '../includes/Auth.php';

Auth::logout();
header('Location: ' . APP_URL . '/');
exit;
?>

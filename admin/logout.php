<?php
session_start();

// Unset all session variables related to admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_role']);

// Or, you can destroy the entire session
// session_destroy();

// Redirect to admin login page
header('Location: ../admin/login.php');
exit;
?>
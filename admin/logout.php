<?php
session_start();

<<<<<<< HEAD
// Unset all session variables related to admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_role']);

// Or, you can destroy the entire session
// session_destroy();

// Redirect to admin login page
header('Location: ../admin/login.php');
=======
// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to admin login page
header('Location: login.php');
>>>>>>> 33f144d34ed0cf67388d6eab671e9e1472a1795d
exit;
?>
<?php
// Redirect to the proper orders route in the \
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/orders');
exit;
?>
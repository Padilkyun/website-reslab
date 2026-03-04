<?php
setcookie('auth_token', '', time() - 3600, '/');
setcookie('admin_token', '', time() - 3600, '/');

header('Location: ' . (defined('BASE_URL') ? BASE_URL : 'http://localhost/reslab') . '/index.php');
exit;
?>

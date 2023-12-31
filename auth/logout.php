<?php
// Logout logic (destroy session, redirect to login page, etc.)
session_start();
session_destroy();
header("Location: login.php");
exit();
?>

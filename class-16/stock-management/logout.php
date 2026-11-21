<?php
include "header.php";
unset($_SESSION['user_id']);
unset($_SESSION['name']);
unset($_SESSION['email']);
$_SESSION['success'] = "You have logged out successfully.";
header('location: '.BASE_URL.'/login.php');
exit;


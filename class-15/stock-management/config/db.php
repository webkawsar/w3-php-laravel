<?php

// Database Connection
$dbhost = 'localhost';
$dbname = 'stock_management';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://localhost/w3-php-laravel/class-15/stock-management");
define("ADMIN_URL", BASE_URL."admin/");


// smtp configuration
define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_USERNAME", "46a417f4ccdbb6"); // your email address
define("SMTP_PASSWORD", "8b186804c90216"); // your email password
define("SMTP_ENCRYPTION", "tls");
define("SMTP_PORT", 587);  
define("SMTP_FROM", "hello.kawsar@gmail.com"); // your email address







?>
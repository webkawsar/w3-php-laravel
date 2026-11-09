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
define("BASE_URL", "http://localhost/stock-management");
define("ADMIN_URL", BASE_URL."admin/");










?>
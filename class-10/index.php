<?php

// Index 
// Date & Time Functions, Database, MySQL, Query, Prepared Statement


// date_default_timezone_set('UTC');

$date = date("l"); // Friday
$date = date("F"); // August
$date = date("d"); // 28
$date = date("D"); // Fri
$date = date("m"); // 08
$date = date("M"); // Aug
$date = date("y"); // 26
$date = date("Y"); // 2026
$date = date("H:i:s"); // 19:49:10
// echo $date;

$time = time(); // return current timestamp
// echo $time;


$past_time = 1787975510;
$ts = strtotime("2023-08-29");
// echo date("d-M-Y", $ts);
echo date("d-M-Y", $past_time);








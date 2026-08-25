<?php

// array utility functions



// $info = [
//     "name" => "Kawsar Ahmed",
//     "age" => 30,
//     "profession" => "Web Developer"
// ];
// $students = ["Samim", "Kawsar", "Imran"];
// array_walk($students, function($value) {
//     echo $value . PHP_EOL;
// });


// $prices = [101, 103, 105];
// modify the main array
// array_walk($prices, function(&$value) {
//     $value *= 5;
// });
// print_r($prices);


// accessing key & value
// array_walk($info, function($value, $key) {
//     echo "Key = " . $key . " & value = " . $value . PHP_EOL;
// });


// $prices = [101, 103, 105];
// injecting extra value
// array_walk($prices, function(&$value, $index, $extra) {
//     $value += $extra;
// }, 1);
// print_r($prices);



// $prices = [101, 103, 105];
// $new_array = array_walk($prices, function(&$value) {
//     $value *= 5;
// });

// return new array
// $new_array = array_map(function($price) {
//     return $price * $price;
// }, $prices);
// print_r($prices);
// print_r($new_array);



// $first_names = ["Mohammad", "Kawsar", "Imran"];
// $last_names = ["Samim", "Ahmed", "Ahmed"];
// loop multiple array parallel
// $new_array = array_map(function($first_name, $last_name) {
//     return $first_name . " " . $last_name;
// }, $first_names, $last_names);
// print_r($new_array);



// basic filtering
// preserved index
// $numbers  = [1, 3, 2, 4, 6, 5];
// $clean_data = array_filter($numbers, function($number) {
//     return $number % 2 === 0;
// });

// re arranged index number
// $re_filtered_data = array_values($clean_data);
// print_r($re_filtered_data);



// removing falsy value
// falsy values => "", false, null, [], 0, -0, "0", 0.0, 
// if("0.0") {
//     echo "falsy";
// }

// $numbers  = [1, null, 2, 4, [], 5, false, 0];
// $clean_data = array_filter($numbers);
// print_r($clean_data);





// filter by key and value
// $infos = [
//     "name" => "Kawsar Ahmed",
//     "age" => 30,
//     "profession" => "Web Developer"
// ];

// by default array filter value dey shudu callback function e.
// $clean_data = array_filter($infos, function($value, $key) {
//     echo $key;
//     return $value;
// }, ARRAY_FILTER_USE_BOTH);
// print_r($clean_data);



// $numbers  = [1, 3, 2, 4, 6, 5];
// $total = array_reduce($numbers, function($carry, $item) {
//     echo $carry." - carry".PHP_EOL;
//     echo $item.PHP_EOL;

//     return $carry + $item;
// }, 100);
// echo $total;



// array merge
// $a = [1, 2];
// $b = [3, 4];
// $flatt = array_merge($a, $b);
// print_r($flatt);


// flattening array
// $matrix = [
//     [1, 2],
//     [3, 4],
//     [5, 6]
// ];

// $flatten_array = array_reduce($matrix, function($carry, $item) {
//     return array_merge($carry, $item);
// }, []);
// print_r($flatten_array);













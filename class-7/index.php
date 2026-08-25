<?php

// Index
// Serialize, Unserialize, JSON Encode & Decode, Array Utility Functions


$info = [
    "name" => "Kawsar Ahmed",
    "age" => 30,
    "profession" => "Web Developer"
];

// $serialized_data = serialize($info);

// print_r($info);
// print_r(unserialize($serialized_data));


$json_data = json_encode($info);
// echo $json_data;
print_r(json_decode($json_data));
print_r(json_decode($json_data, true));



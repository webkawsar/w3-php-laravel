<?php

$text = "This is bangladesh. I have a dream. Bangladesh has a many loss projects with USA.";

// //gi ==> g mane global, i mane case incentive
// /Bangladesh/ ==> eta dara bujay text er majhe ei exact string thaklei holo
// /^Bangladesh/ ==> eta dara text ei string diye suru hoyese kina bujay
// /Bangladesh$/ ==> eta dara bujay last e string ase kina
// /Bangladesh|USA/ ==> eta dara or bujay
// /^[0-9]{3}-[0-9]{3}-[0-9]{4}/  ==> 123-456-5667s
// eta dara bujay first 3 char number hote hobe then - then abar 3 char then - abar 4 char diye ses hote hobe


if (preg_match("/Bangladesh/", $text)) {
    echo "Found";
} else {
    echo "Not Found";
}


// LWS JS Regex
// exact match 
// grouping kora
// character classes
// \w dile sokol word match korbe. ar \W dile word character sara baki sokol kichu
// \d mane digit match kora ar \D mane digit sara baki sokol kichu
// \s diye any kind of space ar \S mane space sara baki sobkichu match korb
// \t mane tab select kora
// \n mane new line
// . char mane new line sara anything
// [abc] = ja pabe match korbe
// /[^abc]  mane abc sara baki sob kichu
// /colou?r/ = mane ? mark er aager char 0 or 1 times thakbe.
// /colou?r*/ = mane * mark er aager char 0 or multiple times thakbe.
// /colou?r+/ = mane * mark er aager char 1 or multiple times thakbe.
// /colou?r{2}/ = mane r koybar thakbe seta bole deya jay
// /colou?r{\1, 4}/ = mane r minimum 1 bar thakbe max 4 bar thakbe
// escape char \
// /^$/ start and end bujay
// /^JS$/gim = m mane multiline

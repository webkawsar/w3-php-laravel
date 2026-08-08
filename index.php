<?php

// Index


// variable


// scope

// local scope
// function printName() {
//     $name = "Kawsar";
//     echo $name; // this can show
// }

// echo $name; // show an error
// printName();
// echo $name; // show an error



// global scope
// $name = "Ahmed";
// function printName2() {
//     global $name;
//     echo $name; // cannot access here without use global keyword
// }

// // echo $name; // show
// printName2();
// // echo $name; // show


// function printName3() {
//     global $name;
//     $name = "Ahmed";
// }

// // echo $name; // show an error
// printName3();
// echo $name; // show


// $name = "Ahmed";
// function printName4() {
//     echo $GLOBALS['name'];
// }

// printName4();


// static scope
// normally, when a function finished execution, all its local variables are destroyed.
// function counter() {
//     $count = 0;
//     $count++;
//     echo $count;
// }

// counter();
// counter();
// counter();

// if we use static keyword then it can remember variable value
function counter() {
    static $count = 0;
    $count++;
    echo $count;
}

counter();
counter();
counter();







?>

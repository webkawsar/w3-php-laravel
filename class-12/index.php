<?php

// Index 
// Normalization, Primary & Foreign Keys, Relationships, Join


// Create Database by SQL
/*
CREATE DATABASE school;
DROP DATABASE school;
/*

// utf8mb4_general_ci


// USE school;
// SHOW DATABASES;
// SHOW TABLES;


// Create Table by SQL Command
/*
CREATE TABLE students (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100),
email VARCHAR(100),
age TINYINT UNSIGNED
);
*/


// Update table by SQL
/*
ALTER TABLE students
ADD COLUMN phone VARCHAR(20) AFTER status;

MySQL-এ নতুন column নির্দিষ্ট জায়গায় বসাতে সাধারণত FIRST অথবা AFTER ব্যবহার করা হয়।
ALTER TABLE students
ADD COLUMN phone VARCHAR(20) AFTER email,
ADD COLUMN address VARCHAR(255);

ALTER TABLE students
ADD COLUMN roll_no VARCHAR(20) FIRST;
*/

// Delete table by SQL
/*
DROP TABLE students; // সম্পূর্ণ table মুছে ফেলে
TRUNCATE TABLE students; // table-এর সব row সরিয়ে দেয়, কিন্তু structure রাখে
*/





// Data Insert to Table
/*
INSERT INTO students (`name`, `email`, `age`)
VALUES
("Kawsar Ahmed", "kawsar@gmail.com", 30),
("Samim Ahmed", "samim@gmail.com", 30);
*/

// Get data
/*
SELECT * FROM students;

SELECT * FROM students
ORDER BY age ASC, name ASC;

SELECT * FROM students
LIMIT 2 OFFSET 1;

SELECT *
FROM students
WHERE age IN (20, 25, 30); // age = 20 OR age = 25 OR age = 30;

SELECT *
FROM students
WHERE name LIKE 'K%'; // mane K diye suru, '%Ahmed' mane Ahmed diye ses, '%ah%' mane jekuno jaygay ah.


SELECT COUNT(*) FROM students; // students table-এ মোট কতটি row আছে তা দেখাবে।

SELECT AVG(age) FROM students;

*/

// Update data
/*
UPDATE students
SET age = 31
WHERE id = 1;
*/


// Delete data
/*
DELETE FROM students
WHERE id = 3;
*/




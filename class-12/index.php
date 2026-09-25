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
// DESCRIBE students;

// Create Table by SQL Command
/*
CREATE TABLE students (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
age TINYINT UNSIGNED
status VARCHAR(20) DEFAULT 'active'
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

// Aggregate Functions
SELECT COUNT(*) FROM students; // students table-এ মোট কতটি row আছে তা দেখাবে।
SELECT AVG(age) FROM students; // student-দের বয়সের গড় বের করবে। যেসব row-তে age-এর value NULL, সেগুলো গণনা করবে না

SUM() — মোট যোগফল।
MIN() — সর্বনিম্ন value।
MAX()

SELECT
    COUNT(*) AS total_students,
    SUM(age) AS total_age,
    AVG(age) AS average_age,
    MIN(age) AS minimum_age,
    MAX(age) AS maximum_age
FROM students;


// GROUP BY
SELECT age, COUNT(*) AS total_students
FROM students
GROUP BY age;

SELECT department, SUM(salary) AS total_salary
FROM employees
GROUP BY department;

SELECT department, gender, COUNT(*) AS total
FROM employees
GROUP BY department, gender;

// HAVING
SELECT age, COUNT(*) AS total_students
FROM students
GROUP BY age
HAVING COUNT(*) >= 2; // HAVING group হওয়ার পরের result filter করছে।

WHERE Grouping-এর আগে individual row filter করে।
HAVING Grouping-এর পরে group filter করে।

এখন থেকে এই order-টা মাথায় রাখবে:
SELECT
FROM
WHERE
GROUP BY
HAVING
ORDER BY
LIMIT

IS NULL // NULL আছে কিনা check করা
IS NOT NULL // NULL নেই এমন Data
DEFAULT

// Constraints
PRIMARY KEY
NOT NULL
UNIQUE
DEFAULT
CHECK
FOREIGN KEY


CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    age TINYINT UNSIGNED CHECK (age <= 99),
    status VARCHAR(20) DEFAULT 'active'
);


// Existing Table-এ Constraint যোগ করা
ALTER TABLE students
ADD UNIQUE (email);




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




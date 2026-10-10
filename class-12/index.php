<?php

// Index 
// Normalization, Primary & Foreign Keys, Relationships, Join

/*==============================Database===================================*/
/*
// Create Database
CREATE DATABASE school;

// Database data type
utf8mb4_general_ci

// Show All Databases
SHOW DATABASES;

// Select a Database
USE school;

// Delete Database
DROP DATABASE school;
/*



/*===============================Table===================================*/
/*
// Show All Tables from Database
SHOW TABLES;

// Show Table Structure
DESCRIBE students;

// Create Table by SQL Command
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    age TINYINT UNSIGNED
    status VARCHAR(20) DEFAULT 'active'
);

// Update Table
ALTER TABLE students
ADD COLUMN phone VARCHAR(20) AFTER email;

// MySQL-এ নতুন column নির্দিষ্ট জায়গায় বসাতে সাধারণত FIRST অথবা AFTER ব্যবহার করা হয়।
ALTER TABLE students
ADD COLUMN phone VARCHAR(20) AFTER email,
ADD COLUMN address VARCHAR(255);

ALTER TABLE students
ADD COLUMN roll_no VARCHAR(20) FIRST;

// Data Insert to Table
INSERT INTO students (`name`, `email`, `age`)
VALUES
("Kawsar Ahmed", "kawsar@gmail.com", 30),
("Samim Ahmed", "samim@gmail.com", 30);

// Delete Table all Row only
TRUNCATE TABLE students; 

// Delete Table
DROP TABLE students;
*/


/*============================Data Related SQL===================================*/
/*
// Get data
SELECT * FROM students;

// ORDER BY
SELECT * FROM students
ORDER BY age ASC, name ASC;

// LIMIT & OFFSET
SELECT * FROM students
LIMIT 2 OFFSET 1;

// IN
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



// Foreign Key
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_name VARCHAR(100),

    FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE CASCADE
);




// Subquery
SELECT *
FROM students
WHERE age = (
    SELECT MAX(age)
    FROM students
);

SELECT *
FROM students
WHERE id IN (
    SELECT student_id
    FROM courses
    WHERE course_name = 'MySQL'
);

SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2;


// EXISTS
SELECT *
FROM students s
WHERE EXISTS (
    SELECT 1
    FROM courses c
    WHERE c.student_id = s.id
);


// NOT EXISTS
SELECT *
FROM students s
WHERE NOT EXISTS (
    SELECT 1
    FROM courses c
    WHERE c.student_id = s.id
);


// CASE WHEN
SELECT
    name,
    age,
    CASE
        WHEN age < 18 THEN 'Minor'
        WHEN age BETWEEN 18 AND 25 THEN 'Young'
        ELSE 'Adult'
    END AS age_group
FROM students;

*/





/*===============================MySQL Lesson 13 — JOIN=========================*/
/*
// 1. INNER JOIN

// Alias ব্যবহার করা
SELECT s.name, c.course_name
FROM students AS s
INNER JOIN courses AS c
ON s.id = c.student_id;

SELECT s.name, c.course_name
FROM students s
INNER JOIN courses c
ON s.id = c.student_id
WHERE s.id >= 1
ORDER BY s.name ASC;


// 2. LEFT JOIN
SELECT s.name, c.course_name
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id;


// 3. Right Join
SELECT s.name, c.course_name
FROM students s
RIGHT JOIN courses c
ON s.id = c.student_id;


// JOIN + COUNT()
SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name;


SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2;


// Multiple JOIN
SELECT
    s.name AS student_name,
    c.course_name,
    t.name AS teacher_name
FROM students s
INNER JOIN courses c
    ON s.id = c.student_id
INNER JOIN teachers t
    ON c.teacher_id = t.id;


// JOIN + WHERE + GROUP BY + HAVING + ORDER BY
SELECT
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
    ON s.id = c.student_id
WHERE s.age >= 18
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2
ORDER BY total_courses DESC;
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




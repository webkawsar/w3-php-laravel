# MySQL Roadmap — Phase 11: SQL JOINs

**ভাষা:** বাংলা | **লেভেল:** Beginner

এই Phase-এ শিখবে কেন একাধিক table-এর data একসঙ্গে দেখাতে `JOIN` লাগে, `INNER JOIN`, `LEFT JOIN`, `RIGHT JOIN`, `CROSS JOIN`, Self Join-এর পরিচিতি, table alias, `ON`, `WHERE`, `ORDER BY`, `COUNT()`-এর সঙ্গে JOIN এবং সাধারণ ভুলগুলো।

Roadmap অনুযায়ী Subquery পরের Phase 12-এ থাকবে।

## 1. JOIN কেন দরকার?

ধরো, database-এ 2টি table আছে।

**students**

| student_id | student_name | department_id |
|---:|---|---:|
| 1 | Ayesha | 2 |
| 2 | Rahim | 1 |
| 3 | Karim | 2 |
| 4 | Nadia | 3 |
| 5 | Sakib | 1 |
| 6 | Mim | NULL |

**departments**

| department_id | department_name |
|---:|---|
| 1 | Computer Science |
| 2 | Business |
| 3 | English |
| 4 | History |

`students` table-এ department ID আছে, কিন্তু department name নেই। `departments` table-এ ID-এর সঙ্গে নাম আছে। `JOIN` দিয়ে দুই table-এর সম্পর্কিত data একসঙ্গে দেখানো যায়।

## 2. Practice Database তৈরি

> **সতর্কতা:** এই script `students` ও `departments` table থাকলে drop করে নতুন করে তৈরি করবে। গুরুত্বপূর্ণ data থাকলে চালিও না; আলাদা practice database ব্যবহার করো।

```sql
CREATE DATABASE IF NOT EXISTS mysql_practice;
USE mysql_practice;

DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS departments;

CREATE TABLE departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    department_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    age INT,
    city VARCHAR(50),
    department_id INT,
    CONSTRAINT fk_students_department
        FOREIGN KEY (department_id)
        REFERENCES departments(department_id)
);

INSERT INTO departments (department_name)
VALUES
('Computer Science'),
('Business'),
('English'),
('History');

INSERT INTO students (student_name, age, city, department_id)
VALUES
('Ayesha', 20, 'Dhaka', 2),
('Rahim', 22, 'Khulna', 1),
('Karim', 21, 'Dhaka', 2),
('Nadia', 19, 'Chattogram', 3),
('Sakib', 23, 'Khulna', 1),
('Mim', 20, 'Dhaka', NULL);
```

Data যাচাই:

```sql
SELECT * FROM students;
SELECT * FROM departments;
```

এই data-তে Mim-এর department নির্ধারিত নয় (`NULL`) এবং History department-এ কোনো student নেই। `LEFT JOIN` ও `RIGHT JOIN` বোঝার জন্য এই 2টি উদাহরণ কাজে লাগবে।

## 3. JOIN-এর Basic Syntax

```sql
SELECT column_name
FROM table1
JOIN table2
    ON table1.common_column = table2.common_column;
```

- `SELECT`: কোন column দেখাবে।
- `FROM`: মূল table।
- `JOIN`: অন্য table যুক্ত করে।
- `ON`: কোন condition-এ row match হবে তা বলে।

আমাদের উদাহরণ:

```sql
SELECT students.student_name, departments.department_name
FROM students
INNER JOIN departments
    ON students.department_id = departments.department_id;
```

এখানে `students.department_id` এবং `departments.department_id` match করা হচ্ছে।

## 4. `INNER JOIN`

`INNER JOIN` শুধু সেই row-গুলো দেখায় যেগুলোর জন্য দুই table-এ matching row আছে।

```sql
SELECT
    s.student_name,
    d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

Expected result:

| student_name | department_name |
|---|---|
| Ayesha | Business |
| Rahim | Computer Science |
| Karim | Business |
| Nadia | English |
| Sakib | Computer Science |

Mim নেই, কারণ তার `department_id` হলো `NULL`, তাই কোনো department-এর সঙ্গে match হয়নি। History-ও নেই, কারণ তার কোনো matching student নেই।

MySQL-এ `JOIN` লিখলে সাধারণত `INNER JOIN`-এর মতোই কাজ করে:

```sql
SELECT s.student_name, d.department_name
FROM students AS s
JOIN departments AS d
    ON s.department_id = d.department_id;
```

**মনে রাখবে:** `INNER JOIN` = matching row-গুলো।

## 5. `ON` Condition-এর গুরুত্ব

সঠিক condition:

```sql
ON s.department_id = d.department_id
```

ভুল column match করলে query চললেও result ভুল হতে পারে। যেমন `student_id` ও `department_id` উভয়ই integer হলেও তাদের অর্থ আলাদা। তাই column বাছাই করতে table-এর relationship বুঝতে হবে।

## 6. `LEFT JOIN`

`LEFT JOIN` left table-এর সব row রাখে। Right table-এ match না থাকলে right-side column-এ `NULL` দেখায়।

```sql
SELECT
    s.student_name,
    d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id;
```

এখানে সব 6 জন student থাকবে। Mim-এর `department_name` হবে `NULL`।

কখন কাজে লাগে?
- সব customer দেখতে, এমনকি order না থাকলেও।
- সব student দেখতে, department নির্ধারিত না থাকলেও।
- সব product দেখতে, sales না থাকলেও।

`FROM students LEFT JOIN departments`-এ `students` হলো left table। তাই students-এর সব row থাকবে।

## 7. `RIGHT JOIN`

`RIGHT JOIN` right table-এর সব row রাখে। Left table-এ match না থাকলে left-side column-এ `NULL` দেখায়।

```sql
SELECT
    s.student_name,
    d.department_name
FROM students AS s
RIGHT JOIN departments AS d
    ON s.department_id = d.department_id;
```

এখানে সব department থাকবে। History-র কোনো student নেই, তাই তার row-তে `student_name` হবে `NULL`।

| বিষয় | `LEFT JOIN` | `RIGHT JOIN` |
|---|---|---|
| সব row রাখে | Left table | Right table |
| Match না পেলে | Right-side value `NULL` | Left-side value `NULL` |

`RIGHT JOIN`-এর equivalent অনেক সময় table-এর order বদলে `LEFT JOIN` দিয়ে লেখা যায়। Beginner হিসেবে `LEFT JOIN` ভালোভাবে বুঝে নেওয়া জরুরি।

## 8. Table Alias

Table-এর নাম ছোট করে লেখার জন্য alias ব্যবহার করা হয়।

```sql
SELECT
    s.student_name,
    d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

এখানে `s` হলো `students` এবং `d` হলো `departments`-এর alias। Alias table-এর আসল নাম বদলায় না; শুধু query-তে সংক্ষিপ্ত নাম।

একই নামের column একাধিক table-এ থাকলে table/alias দিয়ে নির্দিষ্ট করো:

```sql
SELECT s.department_id, d.department_id
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

`department_id` একা লিখলে ambiguous column error হতে পারে।

## 9. JOIN-এর সঙ্গে `WHERE`

`ON` বলে কোন row match হবে। `WHERE` JOIN result থেকে কোন row রাখা হবে তা filter করে।

### শুধু Business department-এর students

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'Business';
```

Result: Ayesha ও Karim।

### বয়স 21 বা তার বেশি

```sql
SELECT s.student_name, s.age, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE s.age >= 21;
```

### Dhaka-র students

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE s.city = 'Dhaka';
```

## 10. JOIN-এর সঙ্গে `ORDER BY`

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
ORDER BY s.student_name ASC;
```

Student name A–Z সাজাবে। Department name আগে, তারপর student name অনুযায়ী সাজাতে:

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
ORDER BY d.department_name ASC, s.student_name ASC;
```

`ASC` ascending; `DESC` descending order।

## 11. JOIN-এর সঙ্গে `COUNT()`

Matching department-সহ student-এর সংখ্যা:

```sql
SELECT COUNT(*) AS students_with_department
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

Expected result: `5`।

প্রতি department-এ কতজন student আছে, তা দেখাতে `LEFT JOIN` ও `COUNT()` একসঙ্গে ব্যবহার করা যায়:

```sql
SELECT
    d.department_name,
    COUNT(s.student_id) AS total_students
FROM departments AS d
LEFT JOIN students AS s
    ON s.department_id = d.department_id
GROUP BY d.department_id, d.department_name
ORDER BY d.department_name;
```

Expected counts:
- Business: 2
- Computer Science: 2
- English: 1
- History: 0

এখানে `COUNT(s.student_id)` ব্যবহার করা হয়েছে, কারণ unmatched History row-তে student ID `NULL`; তাই count হবে 0। `COUNT(*)` দিলে ওই unmatched department row-টিও count হয়ে 1 দেখাতে পারে।

`GROUP BY` পরের Phase-এ বিস্তারিতভাবে শেখা হবে; এখানে JOIN-এর সঙ্গে ব্যবহারটি দেখানো হয়েছে।

## 12. One-to-Many JOIN result-এ repeated value

```sql
SELECT d.department_name, s.student_name
FROM departments AS d
INNER JOIN students AS s
    ON d.department_id = s.department_id
ORDER BY d.department_name, s.student_name;
```

Business department-এর জন্য Ayesha ও Karim—দুটি row আসবে। এটি ভুল duplicate নয়; একই department-এ 2 জন আলাদা student আছে।

## 13. `CROSS JOIN`

`CROSS JOIN` দুই table-এর সব possible combination তৈরি করে (Cartesian product)।

ধরো, `colors`-এ 2টি row আর `sizes`-এ 3টি row আছে:

```sql
SELECT c.color, s.size
FROM colors AS c
CROSS JOIN sizes AS s;
```

Result হবে 2 × 3 = 6টি combination। বড় table-এ অনেক row তৈরি হতে পারে, তাই শুধু সব combination দরকার হলেই ব্যবহার করবে।

## 14. Self Join-এর পরিচিতি

Self Join হলো একই table-কে alias দিয়ে নিজ table-এর সঙ্গে join করা। উদাহরণ: employee table-এ `manager_id` দিয়ে manager-এর নাম বের করা।

```sql
SELECT
    e.employee_name AS employee,
    m.employee_name AS manager
FROM employees AS e
LEFT JOIN employees AS m
    ON e.manager_id = m.employee_id;
```

এখানে `employees`-কে `e` ও `m` নামে 2টি role-এ ব্যবহার করা হয়েছে। এটি ধারণাগত উদাহরণ; এই Phase-এর practice setup-এ `employees` table তৈরি করা হয়নি।

## 15. Common JOIN Mistakes

1. **ভুল column match করা:** column-এর data type একই হলেই তারা সম্পর্কিত নয়।
2. **`INNER JOIN` দিয়ে unmatched row পাওয়ার আশা:** `INNER JOIN` unmatched row বাদ দেয়।
3. **`NULL = NULL` match করবে ভাবা:** সাধারণ equality comparison-এ `NULL` অন্য `NULL`-এর সঙ্গে match করে না।
4. **Ambiguous column:** একই নামের column হলে `s.department_id` বা `d.department_id` লেখো।
5. **Repeated department name-কে ভুল duplicate ভাবা:** One-to-Many relationship-এ এটি স্বাভাবিক।
6. **`LEFT JOIN`-এর পরে right-side column-এ `WHERE` filter দেওয়া:** এতে unmatched row বাদ পড়ে যেতে পারে।

উদাহরণ:

```sql
SELECT s.student_name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'Business';
```

এখানে `department_name` `NULL` এমন row `WHERE` condition পূরণ করে না। তাই result শুধু Business match-এ সীমিত হয়।

## 16. Practice Tasks — আগে নিজে করো

1. `INNER JOIN` দিয়ে student name ও department name দেখাও।
2. `LEFT JOIN` দিয়ে সব student দেখাও।
3. `RIGHT JOIN` দিয়ে সব department দেখাও।
4. শুধু Business department-এর student দেখাও।
5. Age 21 বা তার বেশি student-এর নাম, age ও department name দেখাও।
6. Dhaka-র student-এর নাম ও department name দেখাও।
7. Student name অনুযায়ী result A–Z সাজাও।
8. `COUNT(*)` দিয়ে matching department-সহ student-এর সংখ্যা বের করো।
9. প্রতিটি department-এর student count বের করো।
10. এমন query লেখো যাতে History result-এ থাকে, যদিও সেখানে student নেই।
11. JOIN-এ alias ব্যবহার করো।
12. `CROSS JOIN` কী করে ব্যাখ্যা করো।
13. Self Join কী তা ব্যাখ্যা করো।
14. `INNER JOIN` ও `LEFT JOIN`-এর পার্থক্য practice data দিয়ে ব্যাখ্যা করো।
15. Mim কেন `INNER JOIN`-এ নেই, কিন্তু `LEFT JOIN`-এ আছে তা ব্যাখ্যা করো।

## 17. Practice Tasks — Answer Key

### 1. Student ও department

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

### 2. সব student

```sql
SELECT s.student_name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id;
```

### 3. সব department

```sql
SELECT s.student_name, d.department_name
FROM students AS s
RIGHT JOIN departments AS d
    ON s.department_id = d.department_id;
```

### 4. Business department

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'Business';
```

### 5. Age 21 বা তার বেশি

```sql
SELECT s.student_name, s.age, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE s.age >= 21;
```

### 6. Dhaka students

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE s.city = 'Dhaka';
```

### 7. A–Z সাজানো

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
ORDER BY s.student_name ASC;
```

### 8. Matching student count

```sql
SELECT COUNT(*) AS students_with_department
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

Expected: `5`।

### 9. Department-wise count

```sql
SELECT d.department_name, COUNT(s.student_id) AS total_students
FROM departments AS d
LEFT JOIN students AS s
    ON s.department_id = d.department_id
GROUP BY d.department_id, d.department_name
ORDER BY d.department_name;
```

### 10. Student না থাকলেও History দেখানো

```sql
SELECT d.department_name, s.student_name
FROM departments AS d
LEFT JOIN students AS s
    ON d.department_id = s.department_id;
```

এখানে departments left table, তাই সব department থাকবে।

### 11. Alias ব্যবহার

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

### 12–13. ধারণা

- `CROSS JOIN`: সব possible row combination তৈরি করে।
- Self Join: একই table-কে 2টি alias/role দিয়ে join করে, যেমন employee ও manager।

### 14–15. পার্থক্য

`INNER JOIN` শুধু matching row দেখায়। `LEFT JOIN` left table-এর সব row রাখে। Mim-এর department ID `NULL`, তাই `INNER JOIN`-এ নেই; `LEFT JOIN`-এ আছে, department name `NULL`।

## 18. ছোট Quiz

**1.** শুধু matching row কোন JOIN দেখায়?  
A. `INNER JOIN`  B. `LEFT JOIN`  C. `CROSS JOIN`

**2.** `LEFT JOIN` কোন table-এর সব row রাখে?  
A. Right table  B. Left table  C. সবসময় দুই table

**3.** `RIGHT JOIN`-এ unmatched department-এর student name কী হবে?  
A. `0`  B. Empty string  C. `NULL`

**4.** `ON` clause-এর কাজ কী?  
A. Sort করা  B. Matching condition দেওয়া  C. Table delete করা

**5.** একই department-এ 3 student থাকলে department name 3 বার আসতে পারে?  
A. হ্যাঁ  B. না

**6.** `CROSS JOIN` কী তৈরি করে?  
A. Matching row  B. সব possible combination  C. Unmatched row

**7.** `WHERE` কী করে?  
A. Result filter  B. Table rename  C. Foreign Key তৈরি

### Answer Key

1. A — `INNER JOIN`
2. B — Left table
3. C — `NULL`
4. B — Matching condition
5. A — প্রতি student-এর জন্য আলাদা row হতে পারে
6. B — সব combination
7. A — Result filter

## 19. Completion Checklist

- [ ] JOIN কেন দরকার বুঝি।
- [ ] `ON` condition বুঝি।
- [ ] `INNER JOIN` লিখতে পারি।
- [ ] `LEFT JOIN` ও `RIGHT JOIN`-এর পার্থক্য বুঝি।
- [ ] JOIN result-এ `NULL` কেন আসে বুঝি।
- [ ] Alias ব্যবহার করতে পারি।
- [ ] `WHERE` ও `ORDER BY`-এর সঙ্গে JOIN ব্যবহার করতে পারি।
- [ ] JOIN-এর সঙ্গে `COUNT()` বুঝি।
- [ ] One-to-Many result-এ repeated parent value কেন আসে বুঝি।
- [ ] `CROSS JOIN` ও Self Join-এর basic ধারণা বুঝি।
- [ ] Answer Key না দেখে অন্তত 10টি task সমাধান করতে পারি।

## 20. Quick Reference

| প্রয়োজন | Pattern |
|---|---|
| Matching row | `INNER JOIN ... ON ...` |
| সব left table row | `LEFT JOIN ... ON ...` |
| সব right table row | `RIGHT JOIN ... ON ...` |
| Result filter | `WHERE d.department_name = 'Business'` |
| Result sort | `ORDER BY s.student_name ASC` |
| Alias | `FROM students AS s` |
| Matching row count | `SELECT COUNT(*) ... INNER JOIN ...` |

## 21. Phase 11 Summary

- `JOIN` সম্পর্কিত table-এর data একসঙ্গে দেখায়।
- `ON` matching condition নির্ধারণ করে।
- `INNER JOIN` শুধু match দেখায়।
- `LEFT JOIN` left table-এর সব row রাখে; unmatched right-side value `NULL` হয়।
- `RIGHT JOIN` right table-এর সব row রাখে; unmatched left-side value `NULL` হয়।
- Alias query ছোট করে।
- `WHERE` filter করে, `ORDER BY` sort করে।
- One-to-Many relationship-এ parent value বারবার আসা স্বাভাবিক।
- `CROSS JOIN` সব combination তৈরি করে; Self Join একই table-কে 2 role-এ ব্যবহার করে।

### পরবর্তী Phase

**Phase 12 — Subqueries:** query-এর ভিতরে query, scalar ও multi-row subquery, `IN`, এবং `EXISTS`-এর beginner-friendly use।

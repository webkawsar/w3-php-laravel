# MySQL Learning Roadmap
## Beginner → Advanced

এই roadmap একেবারে beginner level থেকে MySQL শেখার জন্য সাজানো। প্রতিটি topic practice করে তারপর পরের topic-এ যাওয়া হবে।

---

## 🟢 Phase 1 — Database Basics

1. Database কী?
2. DBMS কী?
3. RDBMS কী?
4. MySQL কী?
5. SQL কী?
6. SQL বনাম MySQL
7. Database, Table, Row, Column
8. Primary Key
9. Data Types
   - `INT`
   - `VARCHAR`
   - `TEXT`
   - `DATE`
   - `DATETIME`
   - `DECIMAL`
   - `BOOLEAN`
10. Database তৈরি করা
11. Database select করা
12. Table তৈরি করা
13. Table structure দেখা
14. Table delete করা

### Practice
- `students` database তৈরি
- `students` table তৈরি
- বিভিন্ন data type ব্যবহার

---

## 🟢 Phase 2 — INSERT / SELECT

### INSERT

- Single row insert
- Multiple row insert
- নির্দিষ্ট column-এ data insert

```sql
INSERT INTO students (name, age, email)
VALUES ('Rahim', 20, 'rahim@gmail.com');
```

### SELECT

- `SELECT *`
- Specific columns
- Column alias `AS`

```sql
SELECT * FROM students;

SELECT name, age
FROM students;
```

---

## 🟢 Phase 3 — WHERE Conditions

### Comparison Operators

```text
=
!=
<>
>
<
>=
<=
```

### Logical Operators

```text
AND
OR
NOT
```

### Other Conditions

```text
BETWEEN
IN
NOT IN
LIKE
NOT LIKE
IS NULL
IS NOT NULL
```

### Example

```sql
SELECT *
FROM students
WHERE age >= 18;
```

```sql
SELECT *
FROM students
WHERE age >= 18
AND city = 'Dhaka';
```

---

## 🟢 Phase 4 — Sorting & Limiting

### ORDER BY

```sql
SELECT *
FROM students
ORDER BY age ASC;
```

```sql
SELECT *
FROM students
ORDER BY age DESC;
```

### LIMIT

```sql
SELECT *
FROM students
LIMIT 5;
```

### OFFSET

```sql
SELECT *
FROM students
LIMIT 5 OFFSET 10;
```

### Learn

- ASC
- DESC
- LIMIT
- OFFSET
- Basic pagination

---

## 🟢 Phase 5 — UPDATE & DELETE

### UPDATE

```sql
UPDATE students
SET age = 25
WHERE id = 5;
```

### DELETE

```sql
DELETE FROM students
WHERE id = 5;
```

### Important

- `WHERE` ছাড়া `UPDATE` কী করতে পারে
- `WHERE` ছাড়া `DELETE` কী করতে পারে
- Safe update practices

---

## 🟡 Phase 6 — SQL Functions

### String Functions

```text
CONCAT()
UPPER()
LOWER()
LENGTH()
TRIM()
SUBSTRING()
```

### Numeric Functions

```text
ROUND()
CEIL()
FLOOR()
ABS()
MOD()
```

### Date Functions

```text
CURDATE()
NOW()
YEAR()
MONTH()
DAY()
DATEDIFF()
```

### NULL Functions

```text
COALESCE()
IFNULL()
```

---

## 🟡 Phase 7 — Aggregate Functions

শিখবে:

```text
COUNT()
SUM()
AVG()
MIN()
MAX()
```

### Example

```sql
SELECT COUNT(*)
FROM students;
```

```sql
SELECT AVG(age)
FROM students;
```

---

## 🟡 Phase 8 — GROUP BY & HAVING

### GROUP BY

```sql
SELECT city, COUNT(*)
FROM students
GROUP BY city;
```

### HAVING

```sql
SELECT city, COUNT(*)
FROM students
GROUP BY city
HAVING COUNT(*) > 5;
```

### Important Comparison

```text
WHERE vs HAVING
```

---

## 🟡 Phase 9 — DISTINCT

```sql
SELECT DISTINCT city
FROM students;
```

### Understand

```text
DISTINCT vs GROUP BY
```

---

## 🟠 Phase 10 — Database Relationships

### Keys

- Primary Key
- Foreign Key

### Relationships

```text
One-to-One
One-to-Many
Many-to-Many
```

### Example Tables

```text
students
courses
enrollments
```

---

## 🟠 Phase 11 — JOIN

JOIN MySQL-এর সবচেয়ে গুরুত্বপূর্ণ topics-এর একটি।

### INNER JOIN

```sql
SELECT *
FROM students
INNER JOIN courses
ON students.course_id = courses.id;
```

### LEFT JOIN

```sql
SELECT *
FROM students
LEFT JOIN courses
ON students.course_id = courses.id;
```

### Other JOINs

- RIGHT JOIN
- CROSS JOIN
- SELF JOIN

### Important Comparison

```text
INNER JOIN
vs
LEFT JOIN
vs
RIGHT JOIN
```

---

## 🟠 Phase 12 — Subquery

একটি query-এর ভিতরে আরেকটি query।

### Example

```sql
SELECT *
FROM students
WHERE age > (
    SELECT AVG(age)
    FROM students
);
```

### Learn

- Scalar subquery
- Subquery with `IN`
- Subquery with `EXISTS`
- Correlated subquery

---

## 🟠 Phase 13 — CASE

Conditional logic।

```sql
SELECT
    name,
    age,
    CASE
        WHEN age < 18 THEN 'Minor'
        WHEN age >= 18 THEN 'Adult'
        ELSE 'Unknown'
    END AS category
FROM students;
```

---

## 🟠 Phase 14 — Constraints

Database data validation-এর জন্য:

```text
PRIMARY KEY
FOREIGN KEY
NOT NULL
UNIQUE
DEFAULT
CHECK
```

### Example

```sql
email VARCHAR(100) UNIQUE
```

---

## 🔵 Phase 15 — Database Design & Normalization

### Learn

- Data redundancy
- Data consistency
- Referential integrity
- Primary key selection
- Foreign key design

### Normalization

```text
1NF
2NF
3NF
```

---

## 🔵 Phase 16 — Views

Repeated query-এর জন্য virtual table তৈরি করা।

```sql
CREATE VIEW adult_students AS
SELECT *
FROM students
WHERE age >= 18;
```

তারপর:

```sql
SELECT *
FROM adult_students;
```

### Learn

- `CREATE VIEW`
- `ALTER VIEW`
- `DROP VIEW`

---

## 🔵 Phase 17 — Index

Database performance-এর জন্য অত্যন্ত গুরুত্বপূর্ণ।

### Learn

```text
Index কী?
কেন দরকার?
কখন ব্যবহার করা উচিত?
কখন index ক্ষতি করতে পারে?
```

### Commands

```sql
CREATE INDEX
DROP INDEX
```

### Query Analysis

```sql
EXPLAIN
```

---

## 🔵 Phase 18 — Transactions

Real-world database operations-এর জন্য গুরুত্বপূর্ণ।

```sql
START TRANSACTION;

COMMIT;

ROLLBACK;
```

### ACID

```text
Atomicity
Consistency
Isolation
Durability
```

---

## 🔵 Phase 19 — Stored Procedures

```sql
CREATE PROCEDURE
```

### Learn

- Parameters
- Variables
- IF
- CASE
- Loops
- Procedure call

---

## 🔵 Phase 20 — Stored Functions

নিজের custom SQL function তৈরি করা।

```sql
CREATE FUNCTION
```

---

## 🔵 Phase 21 — Triggers

Database event ঘটলে automatically কিছু কাজ করানো।

### Trigger Types

```text
BEFORE INSERT
AFTER INSERT
BEFORE UPDATE
AFTER UPDATE
BEFORE DELETE
AFTER DELETE
```

### Example Concept

```text
New order inserted
        ↓
Automatically create log
```

---

## 🔵 Phase 22 — CTE

Modern SQL-এর গুরুত্বপূর্ণ topic।

```sql
WITH student_data AS (
    SELECT *
    FROM students
)
SELECT *
FROM student_data;
```

### Learn

- Basic CTE
- Multiple CTE
- Recursive CTE

---

## 🔵 Phase 23 — Window Functions

Data Analytics-এর জন্য অত্যন্ত গুরুত্বপূর্ণ।

### Functions

```text
ROW_NUMBER()
RANK()
DENSE_RANK()
LAG()
LEAD()
```

### Concepts

```text
OVER()
PARTITION BY
ORDER BY
```

### Example

```sql
SELECT
    name,
    age,
    RANK() OVER (
        ORDER BY age DESC
    ) AS age_rank
FROM students;
```

---

## 🔴 Phase 24 — Advanced Query Techniques

শিখবে:

- Complex JOIN
- Nested subqueries
- CTE + JOIN
- CTE + Window Function
- Conditional aggregation
- Dynamic filtering
- Date analysis
- Running total
- Ranking
- Top-N problems
- Duplicate detection
- Missing records
- Gap analysis

---

## 🔴 Phase 25 — Query Performance Optimization

### Learn

```text
EXPLAIN
EXPLAIN ANALYZE
```

### Topics

- Query optimization
- Index optimization
- Composite index
- Covering index
- Query execution plan
- Full table scan
- Index scan
- Slow queries

---

## 🔴 Phase 26 — MySQL Administration Basics

Developer হিসেবে basic administration জানা ভালো।

### Learn

- Users
- Roles
- Privileges
- `GRANT`
- `REVOKE`
- Backup
- Restore
- Import
- Export
- Database security

---

# 🔴 Phase 27 — Real-World Projects

শুধু query practice না করে project করতে হবে।

## Project 1 — Student Management System

```text
students
courses
teachers
enrollments
```

## Project 2 — E-commerce Database

```text
customers
products
categories
orders
order_items
payments
```

## Project 3 — Employee Management System

```text
employees
departments
salaries
attendance
```

## Project 4 — Music Royalty Database

```text
artists
labels
albums
tracks
aggregators
royalty_reports
royalty_transactions
```

---

# 🎯 Complete Learning Sequence

```text
01. Database Basics
        ↓
02. CREATE DATABASE
        ↓
03. CREATE TABLE
        ↓
04. Data Types
        ↓
05. INSERT
        ↓
06. SELECT
        ↓
07. WHERE
        ↓
08. AND / OR / NOT
        ↓
09. IN / BETWEEN / LIKE
        ↓
10. NULL
        ↓
11. ORDER BY
        ↓
12. LIMIT / OFFSET
        ↓
13. UPDATE
        ↓
14. DELETE
        ↓
15. DISTINCT
        ↓
16. SQL Functions
        ↓
17. Aggregate Functions
        ↓
18. GROUP BY
        ↓
19. HAVING
        ↓
20. Primary Key / Foreign Key
        ↓
21. Relationships
        ↓
22. JOIN
        ↓
23. Subquery
        ↓
24. CASE
        ↓
25. Constraints
        ↓
26. Normalization
        ↓
27. Views
        ↓
28. Index
        ↓
29. Transactions
        ↓
30. CTE
        ↓
31. Window Functions
        ↓
32. Stored Procedures
        ↓
33. Functions
        ↓
34. Triggers
        ↓
35. Query Optimization
        ↓
36. Advanced SQL
        ↓
37. Real Projects
```

---

# 🧑‍💻 Recommended Learning Method

প্রতিটি Lesson এই pattern-এ করা হবে:

```text
Lesson
  ↓
Concept Explanation
  ↓
Syntax
  ↓
Examples
  ↓
Dummy Practice Data
  ↓
Practice Questions
  ↓
Student Writes Queries
  ↓
Query Checking
  ↓
Mistake Explanation
  ↓
Correct Query
  ↓
Next Lesson
```

---

# 📌 Current Progress

তুমি ইতোমধ্যে:

- Database basics
- Basic SQL queries
- `SELECT`
- `INSERT`
- `WHERE`
- WHERE conditions practice

করেছো।

তাই roadmap-এর শুরু থেকে আবার না গিয়ে current level থেকে পরের lesson-এ এগিয়ে যাওয়া যাবে।

## Goal

শেষে তুমি যেন:

- Beginner SQL queries লিখতে পারো
- Complex SQL queries লিখতে পারো
- Multiple tables JOIN করতে পারো
- Database design করতে পারো
- Query performance বুঝতে পারো
- Data analysis-এর জন্য SQL ব্যবহার করতে পারো
- Real-world MySQL project তৈরি করতে পারো

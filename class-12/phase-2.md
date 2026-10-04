# MySQL Phase 2 — INSERT & SELECT

> **Level:** Beginner  
> **Prerequisite:** Phase 1 — Database Fundamentals  
> **Goal:** Table-এর মধ্যে data insert করা এবং database থেকে data বের করে দেখা শেখা।

---

# 📚 Phase 2 Overview

এই Phase শেষ করার পর তুমি:

- `INSERT INTO` বুঝতে পারবে
- একটি row insert করতে পারবে
- একসাথে multiple rows insert করতে পারবে
- নির্দিষ্ট columns-এ data insert করতে পারবে
- `SELECT` দিয়ে data দেখতে পারবে
- সব columns select করতে পারবে
- নির্দিষ্ট columns select করতে পারবে
- Column alias ব্যবহার করতে পারবে
- Query-এর output কীভাবে পড়তে হয় বুঝতে পারবে
- Basic INSERT এবং SELECT practice করতে পারবে

---

# 1. INSERT কী?

`INSERT` ব্যবহার করে Table-এর মধ্যে নতুন data যোগ করা হয়।

সহজভাবে:

```text
INSERT = নতুন data যোগ করা
```

### Basic Syntax

```sql
INSERT INTO table_name
(column1, column2, column3)
VALUES
(value1, value2, value3);
```

---

# 2. Practice Database তৈরি করা

এই Phase-এর practice-এর জন্য `school` database এবং `students` table ব্যবহার করব।

## Database

```sql
CREATE DATABASE school;
```

## Database select

```sql
USE school;
```

## Table

```sql
CREATE TABLE students (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(150),
    phone VARCHAR(20),
    birth_date DATE
);
```

---

# 3. একটি Row Insert করা

একজন student-এর information insert করি।

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date)
VALUES
(1, 'Rahim', 20, 'rahim@gmail.com', '01711111111', '2006-05-15');
```

এখানে:

```text
id          → 1
name        → Rahim
age         → 20
email       → rahim@gmail.com
phone       → 01711111111
birth_date  → 2006-05-15
```

---

# 4. INSERT Query কীভাবে কাজ করে?

এই query:

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date)
VALUES
(1, 'Rahim', 20, 'rahim@gmail.com', '01711111111', '2006-05-15');
```

এখানে:

### `INSERT INTO`

কোন Table-এ data যাবে সেটা বলে।

```sql
INSERT INTO students
```

### Column List

কোন columns-এ data যাবে সেটা বলে।

```sql
(id, name, age, email, phone, birth_date)
```

### `VALUES`

কোন values insert হবে সেটা বলে।

```sql
VALUES
(1, 'Rahim', 20, 'rahim@gmail.com', '01711111111', '2006-05-15');
```

---

# 5. Data Type অনুযায়ী Value লেখা

প্রতিটি Data Type-এর value একইভাবে লেখা হয় না।

## INT

Number সাধারণত quote ছাড়া:

```sql
20
```

## VARCHAR

Text single quote-এর মধ্যে:

```sql
'Rahim'
```

## DATE

Date single quote-এর মধ্যে:

```sql
'2006-05-15'
```

## Example

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date)
VALUES
(2, 'Karim', 22, 'karim@gmail.com', '01722222222', '2004-08-10');
```

---

# 6. INSERT করার পর Data কীভাবে দেখব?

এখন `SELECT` ব্যবহার করব।

```sql
SELECT * FROM students;
```

এখানে `*` মানে:

> সব columns দেখাও।

Expected result:

| id | name | age | email | phone | birth_date |
|---:|---|---:|---|---|---|
| 1 | Rahim | 20 | rahim@gmail.com | 01711111111 | 2006-05-15 |
| 2 | Karim | 22 | karim@gmail.com | 01722222222 | 2004-08-10 |

---

# 7. SELECT কী?

`SELECT` ব্যবহার করে Database থেকে data দেখা বা retrieve করা হয়।

সহজভাবে:

```text
SELECT = data দেখাও
```

### Basic Syntax

```sql
SELECT column_name
FROM table_name;
```

---

# 8. সব Columns SELECT করা

সব columns দেখতে:

```sql
SELECT *
FROM students;
```

অথবা এক লাইনে:

```sql
SELECT * FROM students;
```

দুটিই একই কাজ করে।

---

# 9. নির্দিষ্ট Columns SELECT করা

ধরো শুধু `name` এবং `age` দেখতে চাও।

```sql
SELECT name, age
FROM students;
```

Result:

| name | age |
|---|---:|
| Rahim | 20 |
| Karim | 22 |

এখানে:

```text
id
email
phone
birth_date
```

দেখানো হবে না।

---

# 10. একাধিক Column SELECT করা

একাধিক column comma দিয়ে লিখতে হয়।

```sql
SELECT name, age, email
FROM students;
```

আরেকটি example:

```sql
SELECT id, name, phone
FROM students;
```

---

# 11. Column-এর Order পরিবর্তন করা

SELECT করার সময় column-এর order নিজের মতো করে দেওয়া যায়।

Table structure:

```text
id
name
age
email
phone
birth_date
```

কিন্তু query:

```sql
SELECT email, name, age
FROM students;
```

Result:

| email | name | age |
|---|---|---:|
| rahim@gmail.com | Rahim | 20 |
| karim@gmail.com | Karim | 22 |

Database-এর actual column order পরিবর্তন হয়নি।

শুধু result-এর order পরিবর্তন হয়েছে।

---

# 12. Column Alias কী?

Column-এর output name পরিবর্তন করে দেখানোর জন্য `AS` ব্যবহার করা যায়।

### Example

```sql
SELECT name AS student_name
FROM students;
```

Result:

| student_name |
|---|
| Rahim |
| Karim |

এখানে Database-এর actual column:

```text
name
```

কিন্তু output-এ দেখা যাচ্ছে:

```text
student_name
```

---

# 13. Multiple Column Alias

```sql
SELECT
    name AS student_name,
    age AS student_age,
    email AS student_email
FROM students;
```

Result:

| student_name | student_age | student_email |
|---|---:|---|
| Rahim | 20 | rahim@gmail.com |
| Karim | 22 | karim@gmail.com |

---

# 14. Alias-এর `AS` Optional

MySQL-এ সাধারণত `AS` না লিখেও alias করা যায়।

```sql
SELECT name student_name
FROM students;
```

এটিও কাজ করবে।

তবে beginner হিসেবে readability-এর জন্য:

```sql
SELECT name AS student_name
FROM students;
```

এই format ব্যবহার করা ভালো।

---

# 15. Multiple Rows একসাথে INSERT করা

একটি একটি করে row insert করার পাশাপাশি এক query-তে multiple rows insert করা যায়।

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date)
VALUES
(3, 'Hasan', 21, 'hasan@gmail.com', '01733333333', '2005-03-20'),
(4, 'Nadia', 19, 'nadia@gmail.com', '01744444444', '2007-01-12'),
(5, 'Sakib', 23, 'sakib@gmail.com', '01755555555', '2003-11-08');
```

এখানে একসাথে 3টি row insert হয়েছে।

---

# 16. Complete Practice Data

এখন আমরা আরও কিছু student insert করব।

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date)
VALUES
(6, 'Arafat', 24, 'arafat@gmail.com', '01766666666', '2002-06-18'),
(7, 'Sumaiya', 20, 'sumaiya@gmail.com', '01777777777', '2006-02-25'),
(8, 'Jannat', 22, 'jannat@gmail.com', '01788888888', '2004-09-14'),
(9, 'Fahim', 21, 'fahim@gmail.com', '01799999999', '2005-12-05'),
(10, 'Mim', 19, 'mim@gmail.com', '01811111111', '2007-04-22');
```

এখন মোট 10টি student record থাকবে।

---

# 17. সব Data দেখা

```sql
SELECT *
FROM students;
```

---

# 18. শুধু Student Name দেখা

```sql
SELECT name
FROM students;
```

---

# 19. Student Name এবং Email দেখা

```sql
SELECT name, email
FROM students;
```

---

# 20. Student ID, Name এবং Age দেখা

```sql
SELECT id, name, age
FROM students;
```

---

# 21. Alias ব্যবহার করে সুন্দর Output

```sql
SELECT
    id AS student_id,
    name AS student_name,
    age AS student_age
FROM students;
```

---

# 22. INSERT করার সময় Column List কেন লিখব?

এই দুইটি query compare করো।

### Recommended

```sql
INSERT INTO students
(id, name, age, email)
VALUES
(11, 'Rafi', 20, 'rafi@gmail.com');
```

### Column list ছাড়া

```sql
INSERT INTO students
VALUES
(11, 'Rafi', 20, 'rafi@gmail.com', '01822222222', '2006-10-10');
```

Column list ছাড়া query লিখলে Table-এর column order এবং সব required column সম্পর্কে ভালোভাবে জানা থাকতে হয়।

Beginner এবং professional code-এর ক্ষেত্রে explicit column list ব্যবহার করা বেশি readable এবং safer।

---

# 23. নির্দিষ্ট কিছু Column-এ INSERT

যদি কিছু column optional হয়, তাহলে শুধু প্রয়োজনীয় columns-এ data insert করা যায়।

ধরো:

```sql
id
name
age
email
phone
birth_date
```

এখন শুধু:

```text
id
name
email
```

insert করতে চাই।

```sql
INSERT INTO students
(id, name, email)
VALUES
(12, 'Nabil', 'nabil@gmail.com');
```

তবে অন্য columns-এর জন্য appropriate default বা `NULL` allowed থাকতে হবে।

---

# 24. NULL-এর Basic ধারণা

`NULL` মানে value জানা নেই বা value দেওয়া হয়নি।

উদাহরণ:

```text
phone = NULL
```

এটা:

```text
phone = 0
```

এর সমান নয়।

এবং:

```text
phone = ''
```

এর সমানও নয়।

```text
NULL ≠ 0
NULL ≠ ''
```

`NULL` নিয়ে বিস্তারিত আমরা পরের phases-এ শিখব।

---

# 25. String-এর ক্ষেত্রে Single Quote

Text value লিখতে সাধারণত single quote ব্যবহার করবে।

Correct:

```sql
'Rahim'
```

Correct:

```sql
'rahim@gmail.com'
```

Incorrect:

```sql
Rahim
```

কারণ MySQL এটিকে column বা identifier হিসেবে interpret করতে পারে।

---

# 26. Number-এর ক্ষেত্রে Quote প্রয়োজন নেই

Correct:

```sql
20
```

সাধারণ numeric value-এর জন্য:

```sql
age = 20
```

ব্যবহার করবে।

---

# 27. SELECT Query-এর Basic Structure

মনে রাখো:

```sql
SELECT columns
FROM table;
```

Example:

```sql
SELECT name, age
FROM students;
```

এখানে:

```text
SELECT → কী দেখাব?
FROM   → কোথা থেকে দেখাব?
```

---

# 28. INSERT Query-এর Basic Structure

মনে রাখো:

```sql
INSERT INTO table
(columns)
VALUES
(values);
```

Example:

```sql
INSERT INTO students
(name, age)
VALUES
('Rahim', 20);
```

এখানে:

```text
INSERT INTO → কোন Table?
(columns)    → কোন columns?
VALUES       → কী data?
```

---

# 29. INSERT বনাম SELECT

| Command | কাজ |
|---|---|
| `INSERT` | নতুন data যোগ করে |
| `SELECT` | data দেখায় |

### Example

```sql
INSERT INTO students
(id, name, age)
VALUES
(13, 'Tania', 21);
```

তারপর:

```sql
SELECT *
FROM students;
```

প্রথম query data যোগ করে।

দ্বিতীয় query data দেখায়।

---

# 30. Common Beginner Mistakes

## Mistake 1 — Column এবং Value-এর সংখ্যা mismatch

ভুল:

```sql
INSERT INTO students
(id, name, age)
VALUES
(14, 'Rony');
```

এখানে 3টি column কিন্তু 2টি value।

---

## Mistake 2 — Column order ভুল বোঝা

```sql
INSERT INTO students
(id, name, age)
VALUES
('Rony', 20, 15);
```

এখানে `id`-এর জায়গায় text দেওয়া হয়েছে।

---

## Mistake 3 — Text quote না দেওয়া

ভুল:

```sql
INSERT INTO students
(name)
VALUES
(Rahim);
```

সঠিক:

```sql
INSERT INTO students
(name)
VALUES
('Rahim');
```

---

## Mistake 4 — Duplicate Primary Key

যদি:

```text
id = 1
```

আগেই থাকে, আবার:

```sql
INSERT INTO students
(id, name)
VALUES
(1, 'Karim');
```

করলে Primary Key conflict হবে।

---

# 31. Practice Set — Basic INSERT

## Task 1

`students` table-এ নিচের student insert করো:

```text
ID: 14
Name: Rashed
Age: 22
Email: rashed@gmail.com
Phone: 01833333333
Birth Date: 2004-01-15
```

---

## Task 2

নিচের student insert করো:

```text
ID: 15
Name: Priya
Age: 20
Email: priya@gmail.com
Phone: 01844444444
Birth Date: 2006-07-20
```

---

## Task 3

এক query-তে 3 জন student insert করো।

নিজে data তৈরি করবে।

---

# 32. Practice Set — SELECT

## Task 4

সব student-এর সব information দেখাও।

---

## Task 5

শুধু:

```text
name
```

দেখাও।

---

## Task 6

শুধু:

```text
name
age
```

দেখাও।

---

## Task 7

শুধু:

```text
name
email
phone
```

দেখাও।

---

## Task 8

নিচের order-এ result দেখাও:

```text
email
name
age
```

---

# 33. Practice Set — Alias

## Task 9

`name` column-এর output name করো:

```text
student_name
```

---

## Task 10

নিচের alias ব্যবহার করো:

```text
id    → student_id
name  → student_name
age   → student_age
email → student_email
```

---

# 34. Practice Set — Mixed

## Task 11

একজন নতুন student insert করো।

তারপর `SELECT` দিয়ে verify করো।

---

## Task 12

5 জন নতুন student insert করো।

তারপর শুধু তাদের:

```text
name
email
```

দেখাও।

---

## Task 13

`students` table-এর সব columns দেখাও।

---

## Task 14

`students` table-এর শুধু:

```text
id
name
birth_date
```

দেখাও।

---

# 🧠 Phase 2 Quiz

নিজে answer করার চেষ্টা করো।

### Question 1

`INSERT` কী কাজে ব্যবহার করা হয়?

### Question 2

`SELECT` কী কাজে ব্যবহার করা হয়?

### Question 3

`INSERT INTO` কী নির্দেশ করে?

### Question 4

`VALUES` কী নির্দেশ করে?

### Question 5

`SELECT *`-এর অর্থ কী?

### Question 6

কীভাবে শুধু `name` এবং `email` select করবে?

### Question 7

Column alias কী?

### Question 8

`AS` কী কাজে ব্যবহার করা হয়?

### Question 9

এক query-তে multiple rows কীভাবে insert করবে?

### Question 10

Text value-এর জন্য সাধারণত কোন ধরনের quote ব্যবহার করা হয়?

### Question 11

`NULL`, `0` এবং empty string-এর মধ্যে পার্থক্য কী?

### Question 12

Primary Key duplicate হলে কী হতে পারে?

---

# 🔍 Query Reading Practice

নিচের query-টি line by line বোঝার চেষ্টা করো:

```sql
INSERT INTO students
(id, name, age, email)
VALUES
(16, 'Sabbir', 23, 'sabbir@gmail.com');
```

নিজেকে প্রশ্ন করো:

```text
কোন Table?
কোন Columns?
কতটি Value?
প্রথম Value কোন Column-এর?
দ্বিতীয় Value কোন Column-এর?
```

---

আরেকটি query:

```sql
SELECT
    id AS student_id,
    name AS student_name,
    email AS student_email
FROM students;
```

নিজেকে প্রশ্ন করো:

```text
কোন Table থেকে data আসছে?
কোন Columns select হচ্ছে?
Output-এর column names কী?
```

---

# ✅ Phase 2 Completion Checklist

Phase 3-এ যাওয়ার আগে নিশ্চিত হও যে তুমি এগুলো পারো:

- [ ] `INSERT INTO` বুঝি
- [ ] Single row insert করতে পারি
- [ ] Multiple rows insert করতে পারি
- [ ] Column list ব্যবহার করে insert করতে পারি
- [ ] Different Data Type-এর value সঠিকভাবে লিখতে পারি
- [ ] `SELECT *` ব্যবহার করতে পারি
- [ ] Specific columns select করতে পারি
- [ ] Multiple columns select করতে পারি
- [ ] Column order পরিবর্তন করে output দিতে পারি
- [ ] `AS` দিয়ে alias করতে পারি
- [ ] `NULL` সম্পর্কে basic ধারণা আছে
- [ ] INSERT-এর পরে SELECT দিয়ে data verify করতে পারি
- [ ] Basic INSERT/SELECT errors identify করতে পারি

---

# 🎯 Phase 2 Core Concepts

এই 2টি pattern ভালোভাবে মনে রাখো।

## INSERT

```sql
INSERT INTO table_name
(column1, column2, column3)
VALUES
(value1, value2, value3);
```

## SELECT

```sql
SELECT column1, column2, column3
FROM table_name;
```

সব columns:

```sql
SELECT *
FROM table_name;
```

Alias:

```sql
SELECT column_name AS alias_name
FROM table_name;
```

---

# 🚀 Next Phase

## Phase 3 — WHERE Conditions

পরবর্তী Phase-এ আমরা শিখব কীভাবে Table-এর সব data না দেখিয়ে **নির্দিষ্ট condition অনুযায়ী data খুঁজে বের করতে হয়**।

Topics:

```text
WHERE
=
!=
<>
>
<
>=
<=
AND
OR
NOT
BETWEEN
IN
NOT IN
LIKE
NOT LIKE
IS NULL
IS NOT NULL
```

তারপর বাস্তব data দিয়ে অনেকগুলো query practice করা হবে।

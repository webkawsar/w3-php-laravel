# MySQL Phase 1 — Database Fundamentals

> **Level:** Absolute Beginner  
> **Goal:** MySQL শেখার আগে Database, DBMS, RDBMS, SQL, Table, Row, Column, Key এবং Data Type-এর basic ধারণা পরিষ্কার করা।

---

# 📚 Phase 1 Overview

এই Phase শেষ করার পর তুমি:

- Database কী বুঝতে পারবে
- DBMS এবং RDBMS-এর পার্থক্য বুঝতে পারবে
- MySQL কী এবং কেন ব্যবহার করা হয় তা বুঝতে পারবে
- SQL কী বুঝতে পারবে
- Database, Table, Row এবং Column-এর relationship বুঝতে পারবে
- Primary Key সম্পর্কে basic ধারণা পাবে
- প্রয়োজন অনুযায়ী Data Type নির্বাচন করতে পারবে
- Database তৈরি করতে পারবে
- Database select করতে পারবে
- Table তৈরি করতে পারবে
- Table-এর structure দেখতে পারবে
- Table delete করতে পারবে

---

# 1. Database কী?

সহজ ভাষায়:

> **Database হলো এমন একটি organized জায়গা যেখানে তথ্য সংরক্ষণ করা, খুঁজে বের করা, পরিবর্তন করা এবং পরিচালনা করা যায়।**

ধরো, একটি স্কুলে 1,000 জন student আছে।

প্রতিটি student-এর:

- ID
- Name
- Email
- Phone
- Age
- Address

সংরক্ষণ করতে হবে।

এই তথ্যগুলো একটি structured system-এর মধ্যে রাখার জন্য Database ব্যবহার করা হয়।

### Real-Life Example

একটি Student Database:

| ID | Name | Age | Email |
|---:|---|---:|---|
| 1 | Rahim | 20 | rahim@gmail.com |
| 2 | Karim | 22 | karim@gmail.com |
| 3 | Hasan | 21 | hasan@gmail.com |

এখানে এই student information একটি Database-এর মধ্যে সংরক্ষণ করা যেতে পারে।

---

# 2. DBMS কী?

**DBMS = Database Management System**

DBMS হলো এমন একটি software/system যার মাধ্যমে Database তৈরি, সংরক্ষণ, update, delete এবং manage করা যায়।

### কিছু জনপ্রিয় DBMS

- MySQL
- PostgreSQL
- Microsoft SQL Server
- Oracle Database
- SQLite
- MariaDB

### সহজভাবে

```text
Database
   ↑
DBMS দিয়ে Database manage করা হয়
```

---

# 3. RDBMS কী?

**RDBMS = Relational Database Management System**

RDBMS এমন Database Management System যেখানে data সাধারণত **related tables** আকারে সংরক্ষণ করা হয়।

উদাহরণ:

```text
Students
    ↓
Courses
    ↓
Enrollments
```

এই table-গুলোর মধ্যে relationship তৈরি করা যায়।

### MySQL কী?

MySQL একটি **Relational Database Management System (RDBMS)**।

অর্থাৎ MySQL ব্যবহার করে আমরা:

- Database তৈরি করতে পারি
- Table তৈরি করতে পারি
- Data insert করতে পারি
- Data search করতে পারি
- Data update করতে পারি
- Data delete করতে পারি
- Multiple table-এর মধ্যে relationship তৈরি করতে পারি

---

# 4. SQL কী?

**SQL = Structured Query Language**

SQL হলো Database-এর সাথে কাজ করার জন্য ব্যবহৃত একটি language।

SQL দিয়ে আমরা Database-কে instruction দিতে পারি।

উদাহরণ:

```sql
SELECT * FROM students;
```

এর অর্থ:

> `students` table-এর সব data দেখাও।

আরেকটি example:

```sql
INSERT INTO students (name, age)
VALUES ('Rahim', 20);
```

এর অর্থ:

> students table-এ একজন নতুন student-এর information যোগ করো।

---

# 5. SQL বনাম MySQL

এই বিষয়টি beginner হিসেবে পরিষ্কারভাবে বুঝতে হবে।

| SQL | MySQL |
|---|---|
| একটি language | একটি RDBMS |
| Database-এর সাথে কথা বলার language | Database manage করার software/system |
| Query লেখার জন্য ব্যবহার হয় | SQL query execute করে |
| `SELECT`, `INSERT`, `UPDATE` ইত্যাদি SQL-এর অংশ | MySQL এই SQL commands ব্যবহার করে |

### সহজ উদাহরণ

```text
SQL = ভাষা
MySQL = সেই ভাষা ব্যবহার করে Database পরিচালনার system
```

---

# 6. Database, Table, Row এবং Column

এগুলো MySQL শেখার সবচেয়ে basic concepts।

## Database

একটি Database-এর মধ্যে একাধিক Table থাকতে পারে।

```text
school_database
│
├── students
├── teachers
├── courses
└── enrollments
```

---

## Table

Table হলো Database-এর মধ্যে data রাখার একটি structured container।

উদাহরণ:

```text
students
```

---

## Column

Column হলো কোন ধরনের information রাখা হবে সেটা নির্ধারণ করে।

উদাহরণ:

```text
id
name
email
age
phone
```

---

## Row

একটি Row হলো একটি complete record।

উদাহরণ:

```text
1 | Rahim | rahim@gmail.com | 20
```

এটি একজন student-এর একটি complete record।

---

# 7. একটি Table কীভাবে কাজ করে?

ধরো:

```text
students
```

Table:

| id | name | age | email |
|---:|---|---:|---|
| 1 | Rahim | 20 | rahim@gmail.com |
| 2 | Karim | 22 | karim@gmail.com |
| 3 | Hasan | 21 | hasan@gmail.com |

এখানে:

### Database

```text
school_database
```

### Table

```text
students
```

### Columns

```text
id
name
age
email
```

### Rows

```text
1 | Rahim | 20 | rahim@gmail.com
2 | Karim | 22 | karim@gmail.com
3 | Hasan | 21 | hasan@gmail.com
```

---

# 8. Primary Key কী?

**Primary Key** হলো এমন একটি column যার value প্রতিটি record-কে uniquely identify করে।

সাধারণত `id` column Primary Key হিসেবে ব্যবহার করা হয়।

Example:

| id | name | age |
|---:|---|---:|
| 1 | Rahim | 20 |
| 2 | Karim | 22 |
| 3 | Hasan | 21 |

এখানে:

```text
id = Primary Key
```

কারণ প্রতিটি student-এর `id` আলাদা।

### Primary Key-এর বৈশিষ্ট্য

Primary Key:

- Unique হতে হবে
- `NULL` হতে পারে না
- প্রতিটি record uniquely identify করবে

### Example

```sql
id INT PRIMARY KEY
```

---

# 9. Data Type কী?

Data Type বলে দেয় একটি column-এ কী ধরনের data রাখা যাবে।

উদাহরণ:

```text
name → VARCHAR
age → INT
price → DECIMAL
birth_date → DATE
```

---

# 10. গুরুত্বপূর্ণ MySQL Data Types

## 10.1 INT

পূর্ণ সংখ্যা রাখার জন্য।

```sql
age INT
```

Examples:

```text
18
20
25
100
```

---

## 10.2 VARCHAR

ছোট/মাঝারি text রাখার জন্য।

```sql
name VARCHAR(100)
```

Examples:

```text
Rahim
Kawsar Ahmed
Dhaka
```

`VARCHAR(100)` মানে সর্বোচ্চ 100 character পর্যন্ত রাখা যাবে।

---

## 10.3 TEXT

বড় text রাখার জন্য।

```sql
description TEXT
```

Example:

```text
This is a long description...
```

---

## 10.4 DATE

শুধু date রাখার জন্য।

```sql
birth_date DATE
```

Example:

```text
2000-05-20
```

Format:

```text
YYYY-MM-DD
```

---

## 10.5 DATETIME

Date এবং time একসাথে রাখার জন্য।

```sql
created_at DATETIME
```

Example:

```text
2026-10-04 10:30:00
```

---

## 10.6 DECIMAL

Money বা precise decimal value রাখার জন্য।

```sql
salary DECIMAL(10,2)
```

Examples:

```text
50000.00
1250.50
99.99
```

---

## 10.7 BOOLEAN

True/False ধরনের value-এর জন্য ব্যবহার করা যায়।

```sql
is_active BOOLEAN
```

Example:

```text
TRUE
FALSE
```

---

# 11. Data Type নির্বাচন করার Basic Rule

| Data | Recommended Type |
|---|---|
| ID | `INT` |
| Age | `INT` |
| Name | `VARCHAR` |
| Email | `VARCHAR` |
| Phone | `VARCHAR` |
| Description | `TEXT` |
| Birth Date | `DATE` |
| Created Date & Time | `DATETIME` |
| Price | `DECIMAL` |
| Active/Inactive | `BOOLEAN` |

### গুরুত্বপূর্ণ

Phone number-এর জন্য সাধারণত `INT` ব্যবহার না করে `VARCHAR` ব্যবহার করা ভালো।

কারণ:

```text
+8801712345678
```

এখানে `+` থাকতে পারে এবং leading zero-ও থাকতে পারে।

---

# 12. Database তৈরি করা

Database তৈরি করতে:

```sql
CREATE DATABASE school;
```

এখন:

```text
school
```

নামে একটি Database তৈরি হবে।

---

# 13. Database দেখার জন্য

MySQL-এর Database list দেখতে:

```sql
SHOW DATABASES;
```

---

# 14. Database Select করা

কোন Database-এর মধ্যে কাজ করব সেটা select করতে:

```sql
USE school;
```

এরপর আমরা `school` Database-এর ভিতরে Table তৈরি করতে পারব।

---

# 15. Table তৈরি করা

এখন `students` নামে একটি Table তৈরি করি।

```sql
CREATE TABLE students (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(150),
    birth_date DATE
);
```

### এখানে কী হলো?

```text
students
   │
   ├── id
   ├── name
   ├── age
   ├── email
   └── birth_date
```

---

# 16. Table List দেখা

Database-এর ভিতরের সব Table দেখতে:

```sql
SHOW TABLES;
```

Expected result:

```text
students
```

---

# 17. Table Structure দেখা

Table-এর structure দেখতে:

```sql
DESCRIBE students;
```

অথবা:

```sql
DESC students;
```

এখানে সাধারণত দেখা যাবে:

- Field
- Type
- Null
- Key
- Default
- Extra

---

# 18. Table Delete করা

কোনো Table পুরোপুরি delete করতে:

```sql
DROP TABLE students;
```

> ⚠️ **সতর্কতা:** `DROP TABLE` করলে Table এবং এর ভিতরের data মুছে যাবে।

---

# 19. Database Delete করা

Database পুরোপুরি delete করতে:

```sql
DROP DATABASE school;
```

> ⚠️ **সতর্কতা:** Database delete করলে তার ভিতরের Table এবং data-ও মুছে যাবে।

---

# 20. Complete Practice Example

এখন Phase 1-এর সব গুরুত্বপূর্ণ concept একসাথে practice করি।

## Step 1 — Database তৈরি

```sql
CREATE DATABASE school;
```

---

## Step 2 — Database select

```sql
USE school;
```

---

## Step 3 — Table তৈরি

```sql
CREATE TABLE students (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(150),
    birth_date DATE
);
```

---

## Step 4 — Table list দেখো

```sql
SHOW TABLES;
```

---

## Step 5 — Table structure দেখো

```sql
DESC students;
```

---

# 21. Mini Project — Student Database

Phase 1 শেষে তোমার একটি basic Student Database তৈরি করতে হবে।

### Database

```text
school
```

### Table

```text
students
```

### Columns

```text
id
name
age
email
phone
birth_date
```

### Suggested Structure

```sql
CREATE DATABASE school;

USE school;

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

# 📝 Phase 1 Practice Tasks

## Task 1

`company` নামে একটি Database তৈরি করো।

---

## Task 2

`employees` নামে একটি Table তৈরি করো।

Columns:

```text
id
name
email
age
salary
joining_date
```

---

## Task 3

প্রতিটি column-এর জন্য appropriate Data Type নির্বাচন করো।

---

## Task 4

`id`-কে Primary Key বানাও।

---

## Task 5

Database-এর সব Table দেখাও।

```sql
SHOW TABLES;
```

---

## Task 6

`employees` Table-এর structure দেখাও।

```sql
DESC employees;
```

---

## Task 7

`employees` Table delete করার query লেখো।

---

# 🧠 Phase 1 Quiz

নিজে answer করার চেষ্টা করো।

### Question 1

Database কী?

### Question 2

DBMS-এর full form কী?

### Question 3

RDBMS-এর full form কী?

### Question 4

MySQL কী?

### Question 5

SQL কী?

### Question 6

SQL এবং MySQL-এর মধ্যে পার্থক্য কী?

### Question 7

Table কী?

### Question 8

Row এবং Column-এর মধ্যে পার্থক্য কী?

### Question 9

Primary Key কী?

### Question 10

`age` রাখার জন্য কোন Data Type ব্যবহার করবে?

### Question 11

`name` রাখার জন্য কোন Data Type ব্যবহার করবে?

### Question 12

`salary` রাখার জন্য `DECIMAL` কেন ব্যবহার করা ভালো?

### Question 13

Database তৈরি করার command কী?

### Question 14

Database select করার command কী?

### Question 15

Table-এর structure দেখার command কী?

---

# ✅ Phase 1 Completion Checklist

Phase 2-এ যাওয়ার আগে নিশ্চিত হও যে তুমি এগুলো পারো:

- [ ] Database কী explain করতে পারি
- [ ] DBMS explain করতে পারি
- [ ] RDBMS explain করতে পারি
- [ ] MySQL কী explain করতে পারি
- [ ] SQL কী explain করতে পারি
- [ ] SQL vs MySQL বুঝি
- [ ] Database ও Table-এর পার্থক্য জানি
- [ ] Row ও Column বুঝি
- [ ] Primary Key বুঝি
- [ ] Basic Data Types জানি
- [ ] Database তৈরি করতে পারি
- [ ] Database select করতে পারি
- [ ] Table তৈরি করতে পারি
- [ ] Table list দেখতে পারি
- [ ] Table structure দেখতে পারি
- [ ] Table delete করতে পারি
- [ ] Database delete করতে পারি

---

# 🎯 Phase 1 Goal

Phase 1-এর মূল লক্ষ্য হলো **query মুখস্থ করা নয়**, বরং Database-এর structure মাথায় পরিষ্কার করা।

শেষে তোমার মাথায় এই structure পরিষ্কার থাকা উচিত:

```text
Database
   │
   ├── Table
   │     │
   │     ├── Column
   │     ├── Column
   │     └── Column
   │
   ├── Table
   │
   └── Table
```

এবং প্রতিটি Table-এর মধ্যে:

```text
Table
  │
  ├── Row = একটি Record
  │
  ├── Row = একটি Record
  │
  └── Row = একটি Record
```

---

# 🚀 Next Phase

Phase 1 শেষ হলে পরবর্তী ধাপ:

## Phase 2 — INSERT & SELECT

এখানে শেখা হবে:

```text
INSERT INTO
SELECT
SELECT *
Specific Columns
Column Alias
Multiple Row Insert
```

এরপর আমরা বাস্তব data দিয়ে query practice করব।

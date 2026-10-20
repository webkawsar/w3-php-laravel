# MySQL Learning Roadmap — Phase 10: Primary Key, Foreign Key & Relationships

**ভাষা:** বাংলা | **লেভেল:** একদম Beginner

এই Phase-এ শিখবে `PRIMARY KEY`, `FOREIGN KEY`, parent ও child table, `AUTO_INCREMENT`, relationship-এর ধরন, Foreign Key error, এবং `ON DELETE`/`ON UPDATE`-এর প্রাথমিক ধারণা। Roadmap অনুযায়ী `JOIN` বিস্তারিতভাবে Phase 11-এ থাকবে।

## 1. Table, Row, Column ও Record

ধরো, `students` table-এ এমন data আছে:

| student_id | student_name | city |
|---:|---|---|
| 1 | Rahim | Dhaka |
| 2 | Rahim | Khulna |
| 3 | Ayesha | Dhaka |

- **Table:** `students`—তথ্য রাখার জায়গা।
- **Column:** `student_name`, `city`—তথ্যের field।
- **Row/Record:** একজন শিক্ষার্থীর সম্পূর্ণ তথ্য।
- **ID:** প্রতিটি record-কে আলাদাভাবে চেনার জন্য value।

একই নামের একাধিক শিক্ষার্থী থাকতে পারে। তাই শুধু নাম দিয়ে নির্দিষ্ট শিক্ষার্থীকে চেনা কঠিন। এই সমস্যার সমাধানে Primary Key ব্যবহার করা হয়।

## 2. `PRIMARY KEY` কী?

`PRIMARY KEY` হলো একটি column বা একাধিক column-এর combination, যা table-এর প্রতিটি row-কে uniquely identify করে।

### মূল নিয়ম

1. Primary Key value duplicate হতে পারে না।
2. Primary Key-তে `NULL` থাকতে পারে না।
3. একটি table-এ একটি Primary Key constraint থাকে; তবে এটি একাধিক column নিয়ে গঠিত হতে পারে (Composite Primary Key)।
4. সাধারণত ID column-কে Primary Key করা হয়।
5. অন্য table Primary Key reference করতে পারে, তাই key পরিবর্তন করার আগে সতর্ক থাকা দরকার।

### Table তৈরি

```sql
CREATE TABLE students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    city VARCHAR(50)
);
```

Data insert করো:

```sql
INSERT INTO students (student_id, student_name, city)
VALUES
(1, 'Ayesha', 'Dhaka'),
(2, 'Rahim', 'Khulna');

SELECT * FROM students;
```

একই ID আবার insert করার চেষ্টা করো:

```sql
INSERT INTO students (student_id, student_name, city)
VALUES (1, 'Karim', 'Rajshahi');
```

`student_id = 1` আগে থেকেই আছে, তাই MySQL duplicate Primary Key value গ্রহণ করবে না। Primary Key-তে `NULL` দিলেও গ্রহণ করবে না।

## 3. `AUTO_INCREMENT` কী?

`AUTO_INCREMENT` নতুন row insert করার সময় integer ID স্বয়ংক্রিয়ভাবে তৈরি করে।

```sql
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    city VARCHAR(50)
);
```

এখন ID না দিয়েও insert করা যাবে:

```sql
INSERT INTO students (student_name, city)
VALUES
('Ayesha', 'Dhaka'),
('Rahim', 'Khulna'),
('Karim', 'Rajshahi');

SELECT * FROM students;
```

MySQL সাধারণত `1`, `2`, `3`-এর মতো ID দেবে। তবে ID সবসময় gap ছাড়া ধারাবাহিক হবে, এমন নিশ্চয়তা নেই।

**মনে রাখবে:** `AUTO_INCREMENT` ID তৈরি করে; `PRIMARY KEY` uniqueness enforce করে। দুটো সম্পর্কিত, কিন্তু একই জিনিস নয়।

## 4. `FOREIGN KEY` কী?

`FOREIGN KEY` হলো এমন column বা column combination, যা অন্য table-এর Primary Key বা উপযুক্ত unique key-কে reference করে। এটি table-গুলোর মধ্যে relationship বজায় রাখতে সাহায্য করে।

উদাহরণ:

**Parent table: `departments`**

| department_id | department_name |
|---:|---|
| 1 | Computer Science |
| 2 | Business |
| 3 | English |

**Child table: `students`**

| student_id | student_name | department_id |
|---:|---|---:|
| 1 | Ayesha | 2 |
| 2 | Rahim | 1 |
| 3 | Karim | 2 |

এখানে:
- `departments` হলো parent table।
- `students` হলো child table।
- `departments.department_id` হলো Primary Key।
- `students.department_id` হলো Foreign Key।
- `department_id = 2` বোঝায় শিক্ষার্থীটি department ID 2-এর সঙ্গে যুক্ত।

যদি parent table-এ ID `99` না থাকে, তাহলে Foreign Key constraint থাকা অবস্থায় `students.department_id = 99` insert করা যাবে না।

## 5. Parent ও Child Table তৈরি

> **সতর্কতা:** নিচের script একই নামে table থাকলে drop করে আবার তৈরি করবে। গুরুত্বপূর্ণ data থাকলে এই script সেখানে চালাবে না; আলাদা practice database ব্যবহার করো।

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
    department_id INT,
    CONSTRAINT fk_students_department
        FOREIGN KEY (department_id)
        REFERENCES departments(department_id)
);
```

ব্যাখ্যা:
- `department_id` হলো department-এর Primary Key।
- `AUTO_INCREMENT` নতুন ID তৈরি করে।
- `department_name`-এ `NOT NULL` দেওয়া হয়েছে।
- `UNIQUE` একই department name দ্বিতীয়বার insert হওয়া আটকায়।
- `students.department_id` হলো Foreign Key।
- `REFERENCES departments(department_id)` parent table-এর referenced column নির্দেশ করে।
- `fk_students_department` হলো constraint-এর নাম।

MySQL-এ Foreign Key-এর জন্য সাধারণত InnoDB engine ব্যবহার করা হয়।

## 6. আগে Parent, পরে Child Data Insert

Foreign Key থাকলে parent record আগে insert করা সুবিধাজনক ও সাধারণ নিয়ম, কারণ child row-তে এমন ID দিতে হবে যা parent table-এ আছে।

### Step 1: Department insert

```sql
INSERT INTO departments (department_name)
VALUES
('Computer Science'),
('Business'),
('English');

SELECT * FROM departments;
```

Table নতুন করে তৈরি হলে ID সাধারণত `1`, `2`, `3` হবে।

### Step 2: Student insert

```sql
INSERT INTO students (student_name, age, department_id)
VALUES
('Ayesha', 20, 2),
('Rahim', 22, 1),
('Karim', 21, 2),
('Nadia', 19, 3),
('Sakib', 23, 1);

SELECT * FROM students;
```

- Ayesha-এর department ID `2`।
- Rahim-এর department ID `1`।
- Karim-এর department ID `2`।
- Nadia-এর department ID `3`।
- Sakib-এর department ID `1`।

এখন students table-এ department ID দেখা যাবে। Department name পাশাপাশি দেখতে `JOIN` দরকার হবে, যা Phase 11-এ শেখানো হবে।

## 7. Foreign Key Constraint পরীক্ষা

### বৈধ ID

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Mim', 20, 2);
```

Department ID `2` parent table-এ থাকলে insert সফল হবে।

### অবৈধ ID

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Tanvir', 20, 999);
```

Parent table-এ ID `999` না থাকলে Foreign Key error হবে।

### `NULL` Foreign Key

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Rupa', 22, NULL);
```

আমাদের table-এ `department_id` nullable, তাই এটি গ্রহণযোগ্য হতে পারে। যদি প্রত্যেক student-এর department বাধ্যতামূলক হয়, column-এ `NOT NULL` দিতে হবে। `NULL` কোনো non-existent ID-এর সমান নয়; এটি অনির্ধারিত value বোঝায়।

## 8. Primary Key বনাম Foreign Key

| বিষয় | Primary Key | Foreign Key |
|---|---|---|
| উদ্দেশ্য | Row uniquely identify করা | অন্য table-এর record reference করা |
| Duplicate | অনুমোদিত নয় | একাধিক child row একই parent-কে reference করতে পারে |
| `NULL` | অনুমোদিত নয় | Column nullable হলে হতে পারে |
| উদাহরণ | `departments.department_id` | `students.department_id` |

Foreign Key column-এ duplicate value থাকা স্বাভাবিক। একই department-এ অনেক শিক্ষার্থী থাকতে পারে।

## 9. Relationship-এর ধরন

### One-to-One (1:1)

একটি record-এর সঙ্গে অন্য table-এর সর্বোচ্চ একটি record যুক্ত হয়।

উদাহরণ: একজন user-এর একটি profile record। সঠিকভাবে enforce করতে Foreign Key-এর সঙ্গে `UNIQUE` constraint প্রয়োজন হতে পারে।

### One-to-Many (1:N)

একটি parent record-এর সঙ্গে অনেক child record যুক্ত হতে পারে।

উদাহরণ:
- একটি department-এ অনেক student।
- একজন customer-এর অনেক order।
- একটি category-তে অনেক product।

আমাদের `departments` ও `students` উদাহরণটি One-to-Many।

### Many-to-Many (M:N)

একটি student অনেক course নিতে পারে, আবার একটি course-এ অনেক student থাকতে পারে। সাধারণত junction/bridge table দিয়ে এই সম্পর্ক তৈরি করা হয়।

উদাহরণ:

`students`

| student_id | student_name |
|---:|---|
| 1 | Ayesha |
| 2 | Rahim |

`courses`

| course_id | course_name |
|---:|---|
| 10 | MySQL |
| 20 | PHP |

`student_courses`

| student_id | course_id |
|---:|---:|
| 1 | 10 |
| 1 | 20 |
| 2 | 10 |

এখানে `student_courses` প্রতিটি student-course connection ধরে রাখে। সাধারণত `student_id` ও `course_id` একসঙ্গে Composite Primary Key হতে পারে এবং দুটিই Foreign Key হয়।

## 10. Composite Primary Key

যখন একটি column একা record-কে uniquely identify করতে পারে না, তখন একাধিক column একসঙ্গে Primary Key হতে পারে।

```sql
CREATE TABLE student_courses (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);
```

এই query চালাতে আগে `courses` table তৈরি করতে হবে, যেখানে `course_id` Primary Key। এখানে `(student_id, course_id)` pair unique, তাই একই student একই course-এ duplicate enrollment row হিসেবে যোগ করা যাবে না।

## 11. `ON DELETE` ও `ON UPDATE`

Parent row delete বা key update করলে child row-এর কী হবে, তা Foreign Key action দিয়ে নির্ধারণ করা যায়।

- `RESTRICT` / `NO ACTION`: referenced parent row delete/update আটকাতে পারে।
- `CASCADE`: parent delete/update হলে matching child row-তেও cascade action হয়।
- `SET NULL`: matching child Foreign Key `NULL` করে; column nullable হতে হবে।
- MySQL InnoDB Foreign Key-এ `SET DEFAULT` সমর্থিত option নয়।

### `RESTRICT` example

```sql
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    department_id INT,
    CONSTRAINT fk_students_department
        FOREIGN KEY (department_id)
        REFERENCES departments(department_id)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
);
```

যে department-কে student reference করছে, সেটি delete করতে গেলে MySQL বাধা দিতে পারে।

### `CASCADE` সম্পর্কে সতর্কতা

```sql
FOREIGN KEY (department_id)
REFERENCES departments(department_id)
ON DELETE CASCADE
ON UPDATE CASCADE
```

এই action parent department delete হলে matching child student row-গুলোও delete করতে পারে। এটি শক্তিশালী behavior—production database-এ ব্যবহারের আগে নিশ্চিত হও যে child data delete হওয়া সত্যিই উদ্দেশ্য।

## 12. Foreign Key Error হলে কী করবে?

1. Parent table-এ referenced ID আছে কি না দেখো:

```sql
SELECT * FROM departments;
```

2. Table-এর Foreign Key definition দেখো:

```sql
SHOW CREATE TABLE students;
```

3. Child row-তে সঠিক ID ব্যবহার করেছ কি না যাচাই করো।
4. Parent record আগে insert হয়েছে কি না দেখো।
5. Parent row delete করার আগে কোনো child row সেটিকে reference করছে কি না পরীক্ষা করো।

ভুল ID-এর উদাহরণ:

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Jamal', 22, 500);
```

Parent table-এ ID `500` না থাকলে insert fail করবে। সঠিক ID দেখতে `SELECT department_id, department_name FROM departments;` চালাও।

## 13. Table Structure যাচাই

```sql
DESCRIBE departments;
DESCRIBE students;
SHOW CREATE TABLE students;
```

- `DESCRIBE` column ও key সম্পর্কিত সংক্ষিপ্ত structure দেখায়।
- `SHOW CREATE TABLE` table-এর পূর্ণ SQL definition ও constraint দেখায়।
- `SELECT * FROM students;` stored data দেখায়, structure নয়।

## 14. Practice Tasks — নিজে করো

উপরের table তৈরি করে এই কাজগুলো করো:

1. `departments.department_id`-কে Primary Key করো।
2. `students.student_id`-কে Primary Key ও `AUTO_INCREMENT` দাও।
3. `students.department_id`-কে Foreign Key বানাও।
4. 3টি department insert করো।
5. 5 জন student insert করো, যাদের department ID parent table-এ আছে।
6. `department_id = 999` দিয়ে student insert করার চেষ্টা করো এবং ফলাফল লিখে রাখো।
7. একই `student_id` দিয়ে দ্বিতীয় row insert করার চেষ্টা করো।
8. `department_id = NULL` দিয়ে student insert করে দেখো।
9. `SHOW CREATE TABLE students;` চালিয়ে Foreign Key definition খুঁজে বের করো।
10. One-to-One, One-to-Many ও Many-to-Many-এর একটি করে বাস্তব উদাহরণ লেখো।
11. Primary Key ও Foreign Key-এর অন্তত 3টি পার্থক্য লেখো।
12. যে department-কে student reference করছে, সেটি delete করার চেষ্টা করো।
13. `DESCRIBE students;` ও `SHOW CREATE TABLE students;`-এর পার্থক্য লেখো।

## 15. Practice Tasks — Sample Solutions

### Department insert

```sql
INSERT INTO departments (department_name)
VALUES ('Computer Science'), ('Business'), ('English');
```

### Student insert

```sql
INSERT INTO students (student_name, age, department_id)
VALUES
('Ayesha', 20, 2),
('Rahim', 22, 1),
('Karim', 21, 2),
('Nadia', 19, 3),
('Sakib', 23, 1);
```

### Invalid Foreign Key পরীক্ষা

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Test Student', 20, 999);
```

Parent ID `999` না থাকলে Foreign Key error প্রত্যাশিত।

### Duplicate Primary Key পরীক্ষা

```sql
INSERT INTO students (student_id, student_name, age, department_id)
VALUES (1, 'Duplicate ID', 20, 2);
```

যদি ID `1` আগে থেকে থাকে, duplicate Primary Key-এর কারণে query fail করবে।

### `NULL` Foreign Key পরীক্ষা

```sql
INSERT INTO students (student_name, age, department_id)
VALUES ('Unassigned Student', 20, NULL);
```

Column nullable হলে এটি গ্রহণযোগ্য; `NOT NULL` হলে fail করবে।

## 16. ছোট Quiz

**1.** প্রতিটি row uniquely identify করতে কোন constraint লাগে?  
A. `FOREIGN KEY`  B. `PRIMARY KEY`  C. `ORDER BY`

**2.** `students.department_id` যদি `departments.department_id` reference করে, `students` কী?  
A. Parent table  B. Child table  C. Temporary table

**3.** Foreign Key-এর উদ্দেশ্য কী?  
A. Data sort করা  B. Relationship/reference বজায় রাখা  C. Duplicate result বাদ দেওয়া

**4.** Foreign Key column-এ duplicate value থাকতে পারে?  
A. হ্যাঁ  B. না

**5.** `AUTO_INCREMENT` কী করে?  
A. Integer ID তৈরি করে  B. Duplicate row delete করে  C. Table join করে

**6.** Parent table-এ ID `999` নেই। Child row-তে `department_id = 999` insert করলে কী হবে?  
A. সফল হবে  B. Foreign Key constraint-এর কারণে fail হবে  C. MySQL parent record নিজে বানাবে

### Quiz Answer Key

1. B — `PRIMARY KEY`
2. B — Child table
3. B — Relationship/reference বজায় রাখা
4. A — একাধিক child row একই parent-কে reference করতে পারে
5. A — Integer ID তৈরি করে
6. B — Parent ID না থাকায় insert আটকাবে

## 17. Completion Checklist

- [ ] Table, row, column ও record বুঝি।
- [ ] `PRIMARY KEY` কেন দরকার তা ব্যাখ্যা করতে পারি।
- [ ] `AUTO_INCREMENT` বুঝি।
- [ ] `FOREIGN KEY` কীভাবে relationship তৈরি করে বুঝি।
- [ ] Parent ও child table চিনতে পারি।
- [ ] Valid ও invalid Foreign Key value-এর পার্থক্য বুঝি।
- [ ] Nullable Foreign Key বুঝি।
- [ ] One-to-One, One-to-Many ও Many-to-Many বুঝি।
- [ ] Composite Primary Key-এর ধারণা বুঝি।
- [ ] `ON DELETE` ও `ON UPDATE`-এর basic behavior বুঝি।
- [ ] `DESCRIBE` ও `SHOW CREATE TABLE` ব্যবহার করতে পারি।
- [ ] Answer Key না দেখে অন্তত 10টি practice task করতে পারি।

## 18. Quick Reference

| কাজ | SQL pattern |
|---|---|
| Primary Key | `student_id INT PRIMARY KEY` |
| Auto ID | `student_id INT PRIMARY KEY AUTO_INCREMENT` |
| Foreign Key | `FOREIGN KEY (department_id) REFERENCES departments(department_id)` |
| Structure | `DESCRIBE students;` |
| Full definition | `SHOW CREATE TABLE students;` |
| Parent data | `SELECT * FROM departments;` |
| Child data | `SELECT * FROM students;` |

## 19. Phase 10 Summary

- `PRIMARY KEY` প্রতিটি row-কে uniquely identify করে।
- `AUTO_INCREMENT` ID স্বয়ংক্রিয়ভাবে তৈরি করতে সাহায্য করে।
- `FOREIGN KEY` অন্য table-এর referenced key-এর সঙ্গে relationship বজায় রাখে।
- Parent table-এ referenced ID না থাকলে Foreign Key child insert আটকে দিতে পারে।
- One-to-Many-তে অনেক child row একই parent ID reference করতে পারে।
- Many-to-Many সাধারণত junction table দিয়ে তৈরি হয়।
- `ON DELETE`/`ON UPDATE` parent change-এর সময় child data-এর আচরণ নির্ধারণ করতে পারে।

### পরবর্তী Phase: Phase 11 — SQL JOINs

পরবর্তী Phase-এ `INNER JOIN`, `LEFT JOIN`, `RIGHT JOIN` এবং একাধিক table থেকে সম্পর্কিত data এক query-তে বের করা শিখবে।

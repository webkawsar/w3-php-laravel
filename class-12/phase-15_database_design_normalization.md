# MySQL শেখার Roadmap — Phase 15
# Database Design & Normalization (ডেটাবেস ডিজাইন ও নরমালাইজেশন)

**লেভেল:** Beginner থেকে Intermediate  
**ডেটাবেস:** MySQL 8.0+  
**এই Phase-এর লক্ষ্য:** কীভাবে database table পরিকল্পনা করতে হয়, duplicate data কমাতে হয়, এবং 1NF, 2NF ও 3NF ব্যবহার করে data সঠিকভাবে সাজাতে হয় তা শেখা।

## 1. এই Phase-এ কী শিখবে?

এই Phase শেষ করলে তুমি পারবে:

- Database design, entity, attribute, row ও relationship বুঝতে।
- খারাপ table design-এর সমস্যা চিহ্নিত করতে।
- Data redundancy এবং insert, update, delete anomaly ব্যাখ্যা করতে।
- Functional dependency-এর প্রাথমিক ধারণা বুঝতে।
- 1NF, 2NF ও 3NF-এর নিয়ম উদাহরণসহ ব্যাখ্যা করতে।
- একটি বড় table-কে কয়েকটি সম্পর্কযুক্ত table-এ ভাগ করতে।
- Primary key, foreign key এবং composite primary key ব্যবহার করতে।
- Normalization-এর সুবিধা ও trade-off বুঝতে।

## 2. Database Design কী?

Database design হলো data সংরক্ষণের আগে পরিকল্পনা করা—কোন তথ্য কোন table-এ থাকবে, table-গুলোর মধ্যে সম্পর্ক কী হবে, কোন column একটি record-কে uniquely শনাক্ত করবে, এবং কোন নিয়মে data valid থাকবে।

ধরো, একটি কলেজের database-এ রাখতে হবে Student, Department, Course এবং কোন student কোন course-এ ভর্তি হয়েছে তার তথ্য। সব তথ্য এক table-এ রাখলে একই student, department ও course-এর নাম বারবার লিখতে হতে পারে। এতে data update করা কঠিন হয় এবং ভুলের সম্ভাবনা বাড়ে। ভালো design-এ তথ্যকে উপযুক্ত table-এ ভাগ করা হয় এবং key দিয়ে table-গুলোকে সম্পর্কযুক্ত করা হয়।

### প্রয়োজনীয় শব্দ

| শব্দ | অর্থ | উদাহরণ |
|---|---|---|
| Table | নির্দিষ্ট ধরনের data রাখার কাঠামো | `students` |
| Row / Record | একটি নির্দিষ্ট entry | একজন student-এর record |
| Column / Attribute | প্রতিটি record-এর একটি বৈশিষ্ট্য | `student_name` |
| Entity | যে ব্যক্তি/বস্তু/ধারণার data রাখি | Student, Department |
| Primary Key | প্রতিটি row-কে uniquely শনাক্ত করে | `student_id` |
| Foreign Key | অন্য table-এর key-কে reference করে | `students.department_id` |
| Relationship | table বা entity-গুলোর পারস্পরিক সম্পর্ক | একটি department-এ অনেক student |

## 3. খারাপ design কেন সমস্যা তৈরি করে?

ধরো, শুরুতে সব তথ্য এক table-এ রাখা হলো:

```sql
CREATE TABLE normalization_demo_bad_enrollments (
    student_id INT,
    student_name VARCHAR(100),
    department_name VARCHAR(100),
    course_id INT,
    course_name VARCHAR(100),
    instructor_name VARCHAR(100),
    grade VARCHAR(2)
);
```

Sample data:

| student_id | student_name | department_name | course_id | course_name | instructor_name | grade |
|---:|---|---|---:|---|---|---|
| 1 | Rahim | Computer Science | 101 | SQL Basics | Karim Sir | A |
| 1 | Rahim | Computer Science | 102 | Web Basics | Nila Ma'am | B |
| 2 | Salma | Business | 101 | SQL Basics | Karim Sir | A- |

একই student, department, course ও instructor-এর তথ্য বারবার সংরক্ষিত হচ্ছে। এটিকে **data redundancy** বলা হয়।

### 3.1 Update anomaly

`Computer Science` department-এর নাম `Computing` করতে হলে Rahim-এর সব সংশ্লিষ্ট row update করতে হবে। একটি row বাদ পড়লে একই database-এ department-এর 2টি নাম দেখা যাবে।

### 3.2 Insert anomaly

কোনো student এখনও course-এ enroll করেনি। কিন্তু এই table-এ course-সংক্রান্ত column পূরণ না করে student-এর তথ্য সংরক্ষণ করা অসুবিধাজনক হতে পারে। Student ছাড়াই নতুন course যোগ করাও design অনুযায়ী কঠিন হতে পারে।

### 3.3 Delete anomaly

কোনো course-এর একমাত্র enrollment row delete করলে course-এর নাম বা instructor-এর তথ্যও হারিয়ে যেতে পারে—যদি সেই তথ্য অন্য কোথাও সংরক্ষিত না থাকে।

Normalization-এর একটি গুরুত্বপূর্ণ উদ্দেশ্য হলো এই ধরনের anomaly এবং অপ্রয়োজনীয় duplication কমানো।

## 4. Functional Dependency কী?

Functional dependency বোঝায়—একটি column বা column-এর group-এর value জানা থাকলে অন্য একটি column-এর value নির্ধারণ করা যায় কি না।

এভাবে লেখা হয়:

```text
A → B
```

এর অর্থ: `A`-এর value নির্দিষ্ট হলে `B`-এর value নির্দিষ্ট হয়।

উদাহরণ:

```text
student_id → student_name
department_id → department_name
course_id → course_name
```

এগুলো তখনই সঠিক, যখন প্রতিটি ID একটি নির্দিষ্ট record-কে uniquely চিহ্নিত করে।

Enrollment table-এ একজন student অনেক course নিতে পারে এবং একটি course-এ অনেক student থাকতে পারে। তাই `student_id` একা বা `course_id` একা enrollment-কে uniquely শনাক্ত করে না। দুটো একসঙ্গে ব্যবহার করা যায়:

```text
(student_id, course_id) → grade
```

অর্থাৎ নির্দিষ্ট student ও course-এর combination থেকে সেই enrollment-এর grade নির্ধারিত হয়।

## 5. Normalization কী?

Normalization হলো database table-গুলোকে এমনভাবে সাজানোর প্রক্রিয়া, যাতে data duplication ও modification anomaly কমে এবং consistency বজায় থাকে।

এই Phase-এ মূলত 3টি normal form শিখব:

1. **1NF — First Normal Form**
2. **2NF — Second Normal Form**
3. **3NF — Third Normal Form**

সাধারণভাবে 2NF-এর আগে 1NF-এর শর্ত এবং 3NF-এর আগে 2NF-এর শর্ত পূরণ করতে হয়।

## 6. First Normal Form (1NF)

### 6.1 1NF-এর মূল নিয়ম

একটি table 1NF-এ থাকতে হলে:

- প্রতিটি cell-এ একটি atomic value থাকতে হবে।
- একই cell-এ একাধিক value বা comma-separated list রাখা যাবে না।
- একই ধরনের তথ্যের জন্য repeating columns তৈরি করা যাবে না, যেমন `course1`, `course2`, `course3`।
- প্রতিটি row-কে শনাক্ত করার জন্য উপযুক্ত key থাকা উচিত।

### 6.2 1NF নয় — এক cell-এ একাধিক value

| student_id | student_name | phone_numbers |
|---:|---|---|
| 1 | Rahim | 01711111111, 01822222222 |
| 2 | Salma | 01933333333 |

Rahim-এর 2টি phone number একই cell-এ আছে। আলাদা number খোঁজা, update করা বা validate করা কঠিন হতে পারে।

### 6.3 1NF-এর উপযোগী design

একাধিক phone number রাখার জন্য আলাদা table করা যায়:

```sql
CREATE TABLE normalization_demo_students_1nf (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);

CREATE TABLE normalization_demo_student_phones_1nf (
    student_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    PRIMARY KEY (student_id, phone_number),
    FOREIGN KEY (student_id)
        REFERENCES normalization_demo_students_1nf(student_id)
);
```

Sample data:

```sql
INSERT INTO normalization_demo_students_1nf
    (student_id, student_name)
VALUES
    (1, 'Rahim'),
    (2, 'Salma');

INSERT INTO normalization_demo_student_phones_1nf
    (student_id, phone_number)
VALUES
    (1, '01711111111'),
    (1, '01822222222'),
    (2, '01933333333');
```

এখন প্রতিটি phone number আলাদা row-তে আছে। Rahim-এর 2টি number থাকলেও student-এর নাম আলাদা করে বারবার সংরক্ষণ করতে হচ্ছে না।

### 6.4 Repeating columns এড়িয়ে চলা

এ ধরনের design এড়িয়ে চলো:

```text
student_id | student_name | course1 | course2 | course3
```

কারণ:

- কোনো student 4টি course নিলে নতুন column যোগ করতে হবে।
- কেউ 1টি course নিলে অন্য column-গুলো খালি থাকবে।
- সব course-এর ওপর query লেখা জটিল হবে।

এর বদলে `students`, `courses` এবং `enrollments`-এর মতো table ব্যবহার করো।

## 7. Second Normal Form (2NF)

### 7.1 2NF-এর মূল নিয়ম

একটি table 2NF-এ থাকতে হলে:

1. Table-টি 1NF-এ থাকতে হবে।
2. কোনো non-key column যেন composite candidate key-এর **শুধু একটি অংশের ওপর** নির্ভর না করে।

এটিকে **partial dependency** বলা হয়।

Composite key না থাকলে এবং primary key একটি single column হলে সাধারণ beginner উদাহরণে partial dependency-এর সমস্যা থাকে না। 2NF শেখার জন্য composite key-এর উদাহরণ উপযোগী।

### 7.2 সমস্যা বোঝার উদাহরণ

| student_id | course_id | student_name | course_name | grade |
|---:|---:|---|---|---|
| 1 | 101 | Rahim | SQL Basics | A |
| 1 | 102 | Rahim | Web Basics | B |
| 2 | 101 | Salma | SQL Basics | A- |

ধরি, primary key হলো `(student_id, course_id)`।

```text
student_id → student_name
course_id → course_name
(student_id, course_id) → grade
```

`student_name` শুধু `student_id`-এর ওপর নির্ভর করছে; পুরো composite key-এর ওপর নয়। `course_name` শুধু `course_id`-এর ওপর নির্ভর করছে। তাই partial dependency তৈরি হয়েছে।

### 7.3 2NF-এর জন্য table ভাগ করা

```sql
CREATE TABLE normalization_demo_students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT
);

CREATE TABLE normalization_demo_courses (
    course_id INT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL
);

CREATE TABLE normalization_demo_enrollments (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    grade VARCHAR(2),
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id)
        REFERENCES normalization_demo_students(student_id),
    FOREIGN KEY (course_id)
        REFERENCES normalization_demo_courses(course_id)
);
```

এখন `student_name` শুধু `students` table-এ, `course_name` শুধু `courses` table-এ, এবং `grade` enrollment-এর ওপর নির্ভর করে বলে `enrollments` table-এ আছে।

**সহজে মনে রাখো:** 2NF-এ composite key-এর একটি অংশের ওপর নির্ভরশীল তথ্যকে উপযুক্ত আলাদা table-এ সরানো হয়।

## 8. Third Normal Form (3NF)

### 8.1 3NF-এর মূল নিয়ম

একটি table 3NF-এ থাকতে হলে:

1. Table-টি 2NF-এ থাকতে হবে।
2. সাধারণভাবে, non-key column যেন অন্য non-key column-এর মাধ্যমে পরোক্ষভাবে নির্ভরশীল না হয়। এটিকে **transitive dependency** বলা হয়।

### 8.2 Transitive dependency-এর উদাহরণ

| student_id | student_name | department_id | department_name |
|---:|---|---:|---|
| 1 | Rahim | 10 | Computer Science |
| 2 | Salma | 20 | Business |
| 3 | Karim | 10 | Computer Science |

Dependency:

```text
student_id → department_id
department_id → department_name
```

ফলে `student_id` থেকে `department_name` পরোক্ষভাবে নির্ধারিত হচ্ছে। Department-এর নাম আসলে department-এর বৈশিষ্ট্য, student-এর নিজস্ব বৈশিষ্ট্য নয়।

### 8.3 Department table তৈরি

```sql
CREATE TABLE normalization_demo_departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL UNIQUE
);
```

Student table-এ শুধু `department_id` রাখো:

```sql
CREATE TABLE normalization_demo_students_3nf (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id)
        REFERENCES normalization_demo_departments(department_id)
);
```

এখন department-এর নাম এক জায়গায় থাকবে। নাম পরিবর্তন হলে department table-এর একটি row update করলেই হবে।

### 8.4 Normalized schema

```text
departments
-----------
department_id (PK)
department_name

students
--------
student_id (PK)
student_name
department_id (FK)

courses
-------
course_id (PK)
course_name

enrollments
-----------
student_id (PK, FK)
course_id (PK, FK)
grade
```

`enrollments`-এর composite primary key হলো `(student_id, course_id)`। প্রতিটি row একজন student ও একটি course-এর সম্পর্ককে বোঝায়।

## 9. সম্পূর্ণ Practical Project: College Enrollment Database

### Step 1: প্রয়োজনীয় তথ্য চিহ্নিত করো

- Student ID ও নাম
- Department ID ও নাম
- Course ID ও নাম
- কোন student কোন course-এ enrolled
- Enrollment-এর grade

### Step 2: Entity চিহ্নিত করো

1. `normalization_demo_departments`
2. `normalization_demo_students`
3. `normalization_demo_courses`
4. `normalization_demo_enrollments`

### Step 3: Table তৈরি করো

**সতর্কতা:** এগুলো demo-specific table name। একই নামের table আগে থেকে থাকলে `CREATE TABLE` আবার চালালে error হবে। Existing table delete করার দরকার নেই।

```sql
CREATE TABLE normalization_demo_departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE normalization_demo_students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id)
        REFERENCES normalization_demo_departments(department_id)
);

CREATE TABLE normalization_demo_courses (
    course_id INT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL
);

CREATE TABLE normalization_demo_enrollments (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    grade VARCHAR(2),
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id)
        REFERENCES normalization_demo_students(student_id),
    FOREIGN KEY (course_id)
        REFERENCES normalization_demo_courses(course_id)
);
```

### Step 4: Sample data insert করো

Foreign key-এর কারণে parent table-এর data আগে insert করতে হবে: প্রথমে department, তারপর student ও course, তারপর enrollment।

```sql
INSERT INTO normalization_demo_departments
    (department_id, department_name)
VALUES
    (10, 'Computer Science'),
    (20, 'Business');

INSERT INTO normalization_demo_students
    (student_id, student_name, department_id)
VALUES
    (1, 'Rahim', 10),
    (2, 'Salma', 20),
    (3, 'Karim', 10);

INSERT INTO normalization_demo_courses
    (course_id, course_name)
VALUES
    (101, 'SQL Basics'),
    (102, 'Web Basics');

INSERT INTO normalization_demo_enrollments
    (student_id, course_id, grade)
VALUES
    (1, 101, 'A'),
    (1, 102, 'B'),
    (2, 101, 'A-'),
    (3, 101, 'B+');
```

### Step 5: Data দেখো

```sql
SELECT * FROM normalization_demo_departments;
SELECT * FROM normalization_demo_students;
SELECT * FROM normalization_demo_courses;
SELECT * FROM normalization_demo_enrollments;
```

### Step 6: JOIN দিয়ে সব তথ্য দেখো

Normalization করলে data আলাদা table-এ থাকে, তাই report তৈরির সময় JOIN প্রয়োজন হতে পারে।

```sql
SELECT
    s.student_id,
    s.student_name,
    d.department_name,
    c.course_name,
    e.grade
FROM normalization_demo_enrollments AS e
JOIN normalization_demo_students AS s
    ON e.student_id = s.student_id
JOIN normalization_demo_departments AS d
    ON s.department_id = d.department_id
JOIN normalization_demo_courses AS c
    ON e.course_id = c.course_id
ORDER BY s.student_id, c.course_id;
```

এই query student-এর নাম, department, course ও grade একসঙ্গে দেখাবে—যদিও এগুলো database-এ আলাদা table-এ রাখা হয়েছে।

### Step 7: Update-এর সুবিধা যাচাই করো

```sql
UPDATE normalization_demo_departments
SET department_name = 'Computing'
WHERE department_id = 10;
```

এরপর JOIN query চালালে department 10-এর student-দের নামের পাশে `Computing` দেখা যাবে। প্রতিটি student row আলাদা করে update করতে হয়নি।

## 10. Normalization-এর সুবিধা ও Trade-off

### সুবিধা

- Duplicate data কমায়।
- Update, insert ও delete anomaly কমাতে সাহায্য করে।
- Data consistency বজায় রাখা সহজ হয়।
- Entity-গুলোর তথ্য তাদের নিজস্ব table-এ থাকে।
- Foreign key দিয়ে relationship-এর integrity রক্ষা করা যায়।

### Trade-off

- Data একাধিক table-এ থাকায় report query-তে JOIN প্রয়োজন হতে পারে।
- Reporting query বুঝতে ও maintain করতে বেশি পরিকল্পনা লাগতে পারে।
- সব পরিস্থিতিতে সর্বোচ্চ normalization-ই একমাত্র লক্ষ্য নয়; বাস্তব workload, consistency ও performance বিবেচনা করতে হয়।

সাধারণ transactional database design-এ 3NF একটি ভালো লক্ষ্য হতে পারে। পরে performance সমস্যা মাপা হলে নির্দিষ্ট reporting use case-এ denormalization বিবেচনা করা যায়। শুরুতেই শুধু query ছোট করার জন্য duplicate data ছড়িয়ে রাখা উচিত নয়।

## 11. BCNF — Advanced Preview

BCNF (Boyce–Codd Normal Form) হলো 3NF-এর চেয়ে আরও কঠোর একটি normal form। এর মূল ধারণা হলো: প্রতিটি non-trivial functional dependency-এর determinant একটি superkey হতে হবে।

এই Phase-এ BCNF-এর বিস্তারিত শেখা জরুরি নয়। আগে 1NF, 2NF, 3NF এবং functional dependency ভালোভাবে বুঝে নাও।

## 12. Database Design-এর Workflow

1. **Requirements সংগ্রহ:** কী কী তথ্য রাখতে হবে তা লিখে ফেলো।
2. **Entity চিহ্নিত:** Student, Department, Course-এর মতো entity আলাদা করো।
3. **Attribute নির্ধারণ:** প্রতিটি entity-এর প্রয়োজনীয় column ঠিক করো।
4. **Primary key নির্ধারণ:** প্রতিটি row কীভাবে uniquely শনাক্ত হবে ঠিক করো।
5. **Relationship নির্ধারণ:** One-to-one, one-to-many, many-to-many relationship চিহ্নিত করো।
6. **Foreign key যোগ:** সম্পর্ক বজায় রাখতে উপযুক্ত foreign key নির্ধারণ করো।
7. **Normalization যাচাই:** 1NF, 2NF, 3NF-এর নিয়মে duplication ও dependency সমস্যা খুঁজে দেখো।
8. **Constraints যোগ:** `NOT NULL`, `UNIQUE`, `CHECK`, foreign key ইত্যাদি প্রয়োজন অনুযায়ী ব্যবহার করো।
9. **Sample data দিয়ে পরীক্ষা:** স্বাভাবিক ও ভুল data insert করে design যাচাই করো।
10. **Query পরীক্ষা:** প্রয়োজনীয় SELECT, JOIN, INSERT ও UPDATE query চালাও।

## 13. Beginner-দের সাধারণ ভুল

- সব তথ্য একটি বিশাল table-এ রাখা।
- এক cell-এ comma-separated list রাখা।
- `course1`, `course2`, `course3`-এর মতো repeating column তৈরি করা।
- একই department বা course-এর নাম অপ্রয়োজনীয়ভাবে বারবার রাখা।
- Many-to-many relationship-এর জন্য junction table না বানানো।
- Composite key কেন দরকার তা না বুঝে duplicate relationship অনুমোদন করা।
- Functional dependency না বুঝে শুধু normal form-এর নাম মুখস্থ করা।
- Normalization করলেই সব query দ্রুত হবে—এমন ধরে নেওয়া।
- Foreign key-এর parent record আগে insert করার বিষয়টি ভুলে যাওয়া।

## 14. Practice Exercises

প্রথমে নিজে সমাধান করার চেষ্টা করো। পরে Answer Key দেখো।

### Exercise 1 — 1NF

একটি table:

| student_id | student_name | skills |
|---:|---|---|
| 1 | Rahim | SQL, PHP, JavaScript |
| 2 | Salma | Excel, SQL |

প্রশ্ন:
1. এখানে 1NF-এর কোন সমস্যা আছে?
2. Skills-এর জন্য কী ধরনের table তৈরি করা যায়?

### Exercise 2 — 2NF

একটি table-এর composite primary key `(student_id, course_id)`। Columns: `student_id`, `course_id`, `student_name`, `course_name`, `grade`।

প্রশ্ন:
1. কোন column-গুলো partial dependency তৈরি করতে পারে?
2. কোন 3টি table-এ data ভাগ করা যায়?

### Exercise 3 — 3NF

`employees` table-এ আছে `employee_id`, `employee_name`, `department_id`, `department_name`। ধরা যাক:

```text
employee_id → department_id
department_id → department_name
```

প্রশ্ন:
1. Transitive dependency কোথায়?
2. কীভাবে table-গুলো ভাগ করবে?

### Exercise 4 — Design

একটি library system-এ রাখতে হবে Book ID, title, Member ID, member name, কোন member কোন book ধার নিয়েছে, borrow date ও return date।

প্রশ্ন:
1. কী কী table তৈরি করবে?
2. কোন table-এ foreign key থাকবে?
3. Borrow record-এর জন্য কোন key ব্যবহার করা যেতে পারে?

### Exercise 5 — SQL Practice

`department_id = 10`-এর student-দের নাম দেখাও:

```sql
SELECT student_name
FROM normalization_demo_students
WHERE department_id = 10;
```

Query চালিয়ে ফলাফল যাচাই করো।

## 15. Practice Answer Key

### Exercise 1 — সম্ভাব্য উত্তর

`skills` column-এ এক cell-এ একাধিক value আছে। `students` ও `student_skills` table করা যায়।

```sql
CREATE TABLE normalization_demo_student_skills (
    student_id INT NOT NULL,
    skill_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (student_id, skill_name),
    FOREIGN KEY (student_id)
        REFERENCES normalization_demo_students(student_id)
);
```

এই উদাহরণটি চালানোর আগে নিশ্চিত হও `normalization_demo_students` table তৈরি আছে।

### Exercise 2 — সম্ভাব্য উত্তর

- `student_name` শুধু `student_id`-এর ওপর নির্ভরশীল।
- `course_name` শুধু `course_id`-এর ওপর নির্ভরশীল।
- `grade` student ও course-এর combination-এর ওপর নির্ভরশীল।

তাই `students`, `courses`, `enrollments` table করা যায়।

### Exercise 3 — সম্ভাব্য উত্তর

`department_name` হলো `department_id`-এর বৈশিষ্ট্য। `departments(department_id, department_name)` এবং `employees(employee_id, employee_name, department_id)` করা যায়।

### Exercise 4 — সম্ভাব্য উত্তর

সম্ভাব্য table:

- `books(book_id, title)`
- `members(member_id, member_name)`
- `borrow_records(borrow_id, book_id, member_id, borrow_date, return_date)`

`borrow_records`-এ `book_id` ও `member_id` foreign key হবে। আলাদা `borrow_id` primary key ব্যবহার করা যায়। একই member একই book একাধিকবার ধার নিতে পারে, তাই শুধু `(member_id, book_id)` composite key যথেষ্ট হবে না; প্রতিটি borrowing event আলাদা শনাক্ত করতে হবে।

## 16. Quick Revision

| Normal Form | মূল ধারণা | সাধারণ সমস্যা |
|---|---|---|
| 1NF | প্রতিটি cell-এ একটি value; repeating groups নেই | comma-separated list বা `course1/course2` |
| 2NF | 1NF + composite key-এর অংশের ওপর partial dependency নেই | `student_name` শুধু `student_id`-এর ওপর নির্ভরশীল |
| 3NF | 2NF + non-key column-এর মধ্যে transitive dependency নেই | `department_name` নির্ভর করছে `department_id`-এর ওপর |

**এক লাইনে মনে রাখো:**
- 1NF: একটি cell-এ একটি value।
- 2NF: composite key-এর শুধু এক অংশের ওপর non-key data নির্ভর করবে না।
- 3NF: non-key data অন্য non-key data-এর ওপর অপ্রয়োজনীয়ভাবে নির্ভর করবে না।

## 17. Phase Completion Checklist

- [ ] Entity, attribute, row, primary key ও foreign key বুঝতে পারি।
- [ ] Data redundancy কী এবং কেন সমস্যা তৈরি করে তা ব্যাখ্যা করতে পারি।
- [ ] Insert, update ও delete anomaly-এর উদাহরণ দিতে পারি।
- [ ] Functional dependency `A → B` বুঝতে পারি।
- [ ] 1NF-এর সমস্যা চিহ্নিত করে table design করতে পারি।
- [ ] Composite key-সহ 2NF-এর partial dependency বুঝতে পারি।
- [ ] 3NF-এর transitive dependency বুঝতে পারি।
- [ ] Department, student, course ও enrollment table তৈরি করতে পারি।
- [ ] Foreign key-সহ sample data insert করতে পারি।
- [ ] JOIN দিয়ে normalized table থেকে report বের করতে পারি।

## 18. Roadmap Progress

- **এই ফাইল:** Phase 15 — Database Design & Normalization
- **পরবর্তী Phase:** Phase 16 — Views

পরবর্তী Phase-এ আমরা শিখব **Views**—একটি saved SQL query-কে virtual table-এর মতো ব্যবহার করা, `CREATE VIEW`, view থেকে `SELECT`, view update-এর সীমাবদ্ধতা এবং বাস্তব উদাহরণ।

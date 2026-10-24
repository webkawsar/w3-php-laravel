# MySQL Roadmap — Phase 14: Constraints

এই lesson-এ MySQL Constraints beginner level থেকে শেখানো হয়েছে। Constraint হলো database-এর এমন rule, যা ভুল বা অসামঞ্জস্যপূর্ণ data সংরক্ষণ হওয়া আটকায়।

## শেখার লক্ষ্য
- `NOT NULL`, `UNIQUE`, `PRIMARY KEY`, `FOREIGN KEY`, `CHECK`, `DEFAULT` বুঝতে ও ব্যবহার করতে।
- `AUTO_INCREMENT`-এর ভূমিকা বুঝতে।
- Column-level ও table-level constraint চিনতে।
- Existing table-এ constraint যোগ/বাদ দেওয়ার আগে কী যাচাই করতে হয় জানতে।
- Constraint violation error-এর কারণ খুঁজতে।

> Phase 10-এ Primary Key, Foreign Key ও Relationships পড়েছিলে। এখানে সেগুলোকে data validation rules হিসেবে আরও ব্যবহারিকভাবে দেখব.

## 1. Sample database

Phase 12–13-এর `mysql_practice` database-এ `students` ও `departments` table থাকলে সেগুলো ব্যবহার করতে পারো:

```sql
USE mysql_practice;
SHOW TABLES;
DESCRIBE students;
DESCRIBE departments;
```

নিচের examples-এ independent demo table names ব্যবহার করা হয়েছে। Table name আগে থেকেই থাকলে `CREATE TABLE` আবার চালালে error হবে. Demo table-এ data দরকার না থাকলেই drop statements চালাবে.

```sql
DROP TABLE IF EXISTS fk_students_demo;
DROP TABLE IF EXISTS fk_departments_demo;

CREATE TABLE fk_departments_demo (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE fk_students_demo (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE,
    age INT,
    marks DECIMAL(5,2),
    department_id INT,
    status VARCHAR(20) NOT NULL DEFAULT 'Active',
    CONSTRAINT chk_demo_age CHECK (age >= 0),
    CONSTRAINT chk_demo_marks CHECK (marks BETWEEN 0 AND 100),
    CONSTRAINT fk_demo_department
        FOREIGN KEY (department_id)
        REFERENCES fk_departments_demo(department_id)
);
```

MySQL 8.0.16+ এ `CHECK` constraints enforce হয়। নিজের version দেখতে:

```sql
SELECT VERSION();
```

## 2. Constraint কীভাবে কাজ করে?

ধরো, student-এর নাম অবশ্যই থাকতে হবে, email duplicate হতে পারবে না, marks 0 থেকে 100-এর মধ্যে থাকতে হবে এবং department ID সত্যিকারের department-কে নির্দেশ করতে হবে। এসব নিয়ম application-এর বাইরে database-এ enforce করলে অন্য program বা SQL editor দিয়ে data ঢোকালেও rule বজায় থাকে।

## 3. `NOT NULL` — value বাধ্যতামূলক

```sql
CREATE TABLE required_fields_demo (
    student_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    nickname VARCHAR(50) NULL
);
```

- `student_id` এবং `student_name`-এ NULL রাখা যাবে না।
- `nickname`-এ NULL রাখা যাবে।

```sql
INSERT INTO required_fields_demo (student_id, student_name, nickname)
VALUES (1, 'Amina', NULL);
```

এটি বৈধ। কিন্তু `student_name = NULL` দিলে error হবে।

**মনে রাখবে:** `NULL`, empty string (`''`) এবং `0` এক নয়। `NOT NULL` শুধু NULL আটকায়; empty string বা 0 আটকায় না।

## 4. `UNIQUE` — duplicate value আটকায়

```sql
CREATE TABLE unique_email_demo (
    student_id INT PRIMARY KEY,
    email VARCHAR(150) UNIQUE
);
```

```sql
INSERT INTO unique_email_demo VALUES
(1, 'amina@example.com'),
(2, 'rahim@example.com');
```

দুটি email আলাদা, তাই insert হবে। একই email আবার insert করলে unique constraint violation হবে।

```sql
INSERT INTO unique_email_demo VALUES (3, 'amina@example.com');
```

MySQL-এ সাধারণ `UNIQUE` index একাধিক NULL value অনুমোদন করতে পারে। Email অবশ্যই দিতে হবে এবং unique-ও হতে হবে, তাহলে:

```sql
CREATE TABLE required_unique_email_demo (
    student_id INT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE
);
```

### Composite UNIQUE

একই student একই course-এ একবারই enrol করতে পারবে—এমন rule:

```sql
CREATE TABLE enrollment_demo (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE,
    CONSTRAINT uq_student_course UNIQUE (student_id, course_id)
);
```

এখানে `student_id` ও `course_id`-এর pair unique; আলাদা করে প্রতিটি column unique হওয়া বাধ্যতামূলক নয়।

## 5. `PRIMARY KEY` — row-এর unique পরিচয়

```sql
CREATE TABLE primary_key_demo (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);
```

Primary key:
- duplicate value অনুমোদন করে না।
- NULL অনুমোদন করে না।
- একটি table-এ একটি primary-key constraint থাকে; সেটি এক বা একাধিক column নিয়ে গঠিত হতে পারে।

### Composite primary key

```sql
CREATE TABLE student_course_demo (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_on DATE,
    PRIMARY KEY (student_id, course_id)
);
```

একই student একই course-এ duplicate row হিসেবে থাকতে পারবে না।

### PRIMARY KEY বনাম UNIQUE

| বিষয় | PRIMARY KEY | UNIQUE |
|---|---|---|
| Duplicate value | নিষিদ্ধ | নিষিদ্ধ |
| NULL | নিষিদ্ধ | MySQL-এ সাধারণত একাধিক NULL অনুমোদিত হতে পারে |
| Constraint সংখ্যা | একটি primary key | একাধিক UNIQUE থাকতে পারে |
| উদ্দেশ্য | Row-এর মূল পরিচয় | অন্য value-র uniqueness |

## 6. `AUTO_INCREMENT` — ID স্বয়ংক্রিয়ভাবে তৈরি

`AUTO_INCREMENT` নিজে constraint নয়; এটি numeric column attribute, যা ID তৈরি করতে সাহায্য করে।

```sql
CREATE TABLE auto_id_demo (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);

INSERT INTO auto_id_demo (student_name)
VALUES ('Amina'), ('Rahim'), ('Karim');

SELECT * FROM auto_id_demo;
```

সাধারণত ID 1, 2, 3-এর মতো হবে, তবে table-এর history/configuration অনুযায়ী ভিন্ন হতে পারে। Unique ও non-NULL পরিচয় primary key নিশ্চিত করে।

## 7. `FOREIGN KEY` — table-এর মধ্যে valid relationship

```sql
CREATE TABLE fk_departments_demo (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE fk_students_demo (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT,
    CONSTRAINT fk_students_department
        FOREIGN KEY (department_id)
        REFERENCES fk_departments_demo(department_id)
);
```

যদি একই নামের demo table ইতিমধ্যে তৈরি করা থাকে, এই `CREATE TABLE` statements আবার চালিও না।

Parent row আগে insert করো:

```sql
INSERT INTO fk_departments_demo VALUES (1, 'Computer Science');

INSERT INTO fk_students_demo
(student_id, student_name, department_id)
VALUES (101, 'Amina', 1);
```

এটি valid, কারণ department ID 1 parent table-এ আছে।

```sql
INSERT INTO fk_students_demo
(student_id, student_name, department_id)
VALUES (102, 'Rahim', 99);
```

Parent table-এ ID 99 না থাকলে এটি reject হবে।

সাধারণত referenced column parent table-এর primary key বা উপযুক্ত unique indexed key হতে হবে; column-এর data types-ও সামঞ্জস্যপূর্ণ হতে হবে। Foreign key enforcement-এর জন্য InnoDB ব্যবহার করো।

### `ON DELETE` / `ON UPDATE`

```sql
CREATE TABLE fk_action_demo (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT NULL,
    CONSTRAINT fk_action_department
        FOREIGN KEY (department_id)
        REFERENCES fk_departments_demo(department_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
```

- `ON DELETE SET NULL`: parent department delete হলে child-এর department ID NULL হবে; তাই child column nullable হতে হবে।
- `ON UPDATE CASCADE`: parent key বদলালে child reference-ও বদলাবে।
- `ON DELETE CASCADE`: parent delete হলে matching child rows-ও delete হতে পারে—সাবধানে ব্যবহার করো।
- `RESTRICT`/`NO ACTION`: referenced parent row delete/update আটকাতে পারে।

সব ক্ষেত্রে cascade দরকার হয় না; business rule অনুযায়ী বেছে নাও।

## 8. `CHECK` — value-কে condition মানতে হবে

MySQL 8.0.16+ এ enforced `CHECK` constraint সমর্থিত।

```sql
CREATE TABLE check_marks_demo (
    student_id INT PRIMARY KEY,
    marks DECIMAL(5,2) NOT NULL,
    CONSTRAINT chk_marks_range CHECK (marks BETWEEN 0 AND 100)
);
```

Marks -5 বা 105 হলে constraint violation হবে। `NOT NULL`-ও দেওয়া হয়েছে, কারণ `CHECK` একা NULL আটকায় না।

Allowed values নির্দিষ্ট করতেও CHECK ব্যবহার করা যায়:

```sql
CREATE TABLE account_status_demo (
    account_id INT PRIMARY KEY,
    status VARCHAR(20) NOT NULL,
    CONSTRAINT chk_account_status
        CHECK (status IN ('Active', 'Pending', 'Suspended'))
);
```

এখানে status-এর জন্য ওই 3টি value ছাড়া অন্য value অনুমোদিত নয়।

## 9. `DEFAULT` — value না দিলে default value

```sql
CREATE TABLE default_demo (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

```sql
INSERT INTO default_demo (student_id, student_name)
VALUES (1, 'Amina');
```

`status` বাদ দেওয়ায় `Active` default বসবে। `created_at`-এ বর্তমান timestamp default হিসেবে বসবে।

`DEFAULT` এবং `NULL` এক নয়:
- Column বাদ দিলে default value ব্যবহৃত হতে পারে।
- Explicit `NULL` দিলে nullable column-এ NULL থাকতে পারে।
- `NOT NULL` column-এ explicit NULL দিলে error হতে পারে।
- `DEFAULT` নিজে `NOT NULL`-এর বিকল্প নয়।

## 10. Column-level ও table-level constraints

Column definition-এর পাশে:

```sql
CREATE TABLE column_constraint_demo (
    student_id INT PRIMARY KEY,
    email VARCHAR(150) UNIQUE,
    student_name VARCHAR(100) NOT NULL
);
```

Table-এর শেষে:

```sql
CREATE TABLE table_constraint_demo (
    student_id INT NOT NULL,
    email VARCHAR(150) NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (student_id),
    UNIQUE (email)
);
```

Composite key বা একাধিক column-এর combination-এর constraint table-level syntax-এ লেখা হয়। Named constraints (`CONSTRAINT constraint_name ...`) পরে খুঁজে পাওয়া ও পরিচালনা সহজ করে।

## 11. Existing table-এ constraint যোগ করা

আগে data যাচাই করো—পুরোনো row নতুন rule ভাঙলে `ALTER TABLE` ব্যর্থ হতে পারে।

### NOT NULL

```sql
ALTER TABLE required_fields_demo
MODIFY student_name VARCHAR(100) NOT NULL;
```

Column-এ NULL থাকলে ব্যর্থ হতে পারে। `MODIFY`-তে column-এর data type ও প্রয়োজনীয় attributes ঠিকভাবে উল্লেখ করো।

### UNIQUE

```sql
ALTER TABLE unique_email_demo
ADD CONSTRAINT uq_email UNIQUE (email);
```

Duplicate email আগে থেকে থাকলে constraint যোগ করা ব্যর্থ হবে।

### CHECK

```sql
ALTER TABLE students
ADD CONSTRAINT chk_students_marks
CHECK (marks >= 0 AND marks <= 100);
```

এটি শুধু তখন চালাবে, যখন `students.marks`-এর সব non-NULL value range মেনে চলে এবং constraint name আগে ব্যবহৃত হয়নি।

### FOREIGN KEY

```sql
ALTER TABLE fk_students_demo
ADD CONSTRAINT fk_students_demo_department
FOREIGN KEY (department_id)
REFERENCES fk_departments_demo(department_id);
```

Child table-এ parent table-এ অনুপস্থিত non-NULL ID থাকলে constraint যোগ করা ব্যর্থ হবে।

## 12. Constraint বাদ দেওয়া

Constraint বাদ দিলে database আর ওই rule enforce করবে না। Production database-এ impact না বুঝে constraint drop করবে না।

Constraint-এর প্রকৃত নাম দেখতে:

```sql
SHOW CREATE TABLE table_name;
```

Foreign key বাদ দেওয়ার syntax:

```sql
ALTER TABLE fk_students_demo
DROP FOREIGN KEY fk_students_department;
```

CHECK বাদ দেওয়ার syntax:

```sql
ALTER TABLE check_marks_demo
DROP CHECK chk_marks_range;
```

UNIQUE constraint সাধারণত index দিয়ে implement হয়। প্রকৃত index name দেখে তারপর:

```sql
SHOW INDEX FROM unique_email_demo;
```

Index name `email` হলে:

```sql
ALTER TABLE unique_email_demo
DROP INDEX email;
```

প্রকৃত নাম আলাদা হলে সেটিই ব্যবহার করতে হবে। `DROP FOREIGN KEY`, `DROP CHECK` ও `DROP INDEX` একই syntax নয়।

## 13. Table-এর constraint inspect করা

```sql
DESCRIBE students;
SHOW CREATE TABLE students;
SHOW TABLES;
```

- `DESCRIBE` column, type, NULL, key ও default-এর মতো তথ্য দেখায়।
- `SHOW CREATE TABLE` full definition, constraints ও indexes দেখায়।
- `SHOW TABLES` বর্তমান database-এর table names দেখায়।

Constraint error হলে:
1. সম্পূর্ণ error message পড়ো।
2. কোন table/column বা key উল্লেখ আছে দেখো।
3. Duplicate key হলে duplicate value খুঁজো।
4. Foreign key error হলে parent table-এ referenced value আছে কি না দেখো।
5. CHECK error হলে condition যাচাই করো।
6. `SHOW CREATE TABLE` দিয়ে rule ও constraint name পরীক্ষা করো।

## 14. সাধারণ ভুল

1. **UNIQUE মানেই NOT NULL নয়:** email বাধ্যতামূলক ও unique করতে `NOT NULL UNIQUE` ব্যবহার করো।
2. **Parent row নেই:** child foreign key value insert করার আগে parent row থাকতে হবে, যদি value non-NULL হয়।
3. **CHECK NULL আটকায় না:** বাধ্যতামূলক marks-এর জন্য `NOT NULL` যোগ করো।
4. **Existing data পরীক্ষা না করা:** duplicate বা invalid data থাকলে constraint যোগ করা ব্যর্থ হতে পারে।
5. **CASCADE না বুঝে ব্যবহার করা:** parent delete করলে child data মুছে যেতে পারে।
6. **DEFAULT-কে NOT NULL মনে করা:** default value আর mandatory value আলাদা rule।

## 15. Practice tasks

আগে নিজে চেষ্টা করো:

1. `student_id` primary key এবং `student_name` NOT NULL-সহ table তৈরি করো।
2. Email unique রাখো।
3. Email-এ `NOT NULL` ও `UNIQUE` একসঙ্গে ব্যবহার করো।
4. `AUTO_INCREMENT` primary key দিয়ে 3টি row insert করো।
5. Department ও student table তৈরি করে foreign key relationship তৈরি করো।
6. Parent table-এ নেই এমন department ID দিয়ে child insert করার চেষ্টা করো এবং error ব্যাখ্যা করো।
7. `CHECK` দিয়ে age 0 বা তার বেশি রাখো।
8. `CHECK` দিয়ে marks 0–100-এর মধ্যে রাখো এবং `NOT NULL` যোগ করো।
9. `DEFAULT 'Active'` status column তৈরি করো।
10. `(student_id, course_id)`-এর combination unique করো।
11. `SHOW CREATE TABLE` দিয়ে constraint inspect করো।
12. Duplicate email-সহ table-এ UNIQUE যোগ করলে কী হবে ব্যাখ্যা করো।

## 16. Practice answers

### 1

```sql
CREATE TABLE practice_student_pk (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);
```

### 2–3

```sql
CREATE TABLE practice_email (
    student_id INT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE
);
```

### 4

```sql
CREATE TABLE practice_auto_id (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);

INSERT INTO practice_auto_id (student_name)
VALUES ('Amina'), ('Rahim'), ('Karim');
```

### 5–6

```sql
CREATE TABLE practice_departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE practice_students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id)
        REFERENCES practice_departments(department_id)
);
```

এবার `department_id = 999` insert করলে parent table-এ ID 999 না থাকায় foreign key error হবে।

### 7–8

```sql
CREATE TABLE practice_marks (
    student_id INT PRIMARY KEY,
    age INT NOT NULL,
    marks DECIMAL(5,2) NOT NULL,
    CHECK (age >= 0),
    CHECK (marks BETWEEN 0 AND 100)
);
```

### 9

```sql
CREATE TABLE practice_default (
    record_id INT PRIMARY KEY,
    status VARCHAR(20) NOT NULL DEFAULT 'Active'
);
```

### 10

```sql
CREATE TABLE practice_composite_unique (
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    UNIQUE (student_id, course_id)
);
```

### 11

```sql
SHOW CREATE TABLE practice_students;
```

### 12

Existing duplicate email থাকলে UNIQUE constraint যোগ করা ব্যর্থ হবে। আগে duplicate records শনাক্ত করে resolve করতে হবে।

## 17. Quiz

1. Constraint কী?
2. `NOT NULL` কী আটকায়?
3. `PRIMARY KEY` ও `UNIQUE`-এর পার্থক্য কী?
4. `AUTO_INCREMENT` কি নিজেই constraint?
5. `FOREIGN KEY` কেন দরকার?
6. `CHECK (marks BETWEEN 0 AND 100)` কী নিশ্চিত করে?
7. `CHECK` কি সবসময় NULL আটকায়?
8. `DEFAULT` কখন ব্যবহৃত হয়?
9. Existing data আগে যাচাই করা জরুরি কেন?
10. Constraint definition দেখতে কোন command ব্যবহার করবে?

### Quiz answers

1. Database-enforced data rule।
2. NULL value।
3. Primary key হলো row-এর মূল unique, non-NULL identifier; UNIQUE অতিরিক্ত uniqueness rule।
4. না, এটি column attribute।
5. Referential integrity বজায় রাখতে।
6. Non-NULL marks 0–100 range-এ থাকতে হবে।
7. না; দরকার হলে `NOT NULL` যোগ করো।
8. Insert-এ value না দিলে default বসাতে।
9. Existing data নতুন rule ভাঙলে constraint যোগ করা ব্যর্থ হতে পারে।
10. `SHOW CREATE TABLE table_name;`

## 18. Completion checklist

- [ ] `NOT NULL` ও `UNIQUE` বুঝি।
- [ ] `PRIMARY KEY` ও `FOREIGN KEY`-এর উদ্দেশ্য বুঝি।
- [ ] `CHECK` দিয়ে range/allowed values নির্ধারণ করতে পারি।
- [ ] `DEFAULT` ও `AUTO_INCREMENT` বুঝি।
- [ ] Column-level ও table-level constraint চিনতে পারি।
- [ ] `SHOW CREATE TABLE` দিয়ে constraint দেখতে পারি।
- [ ] Constraint violation-এর কারণ খুঁজতে পারি।
- [ ] অন্তত 8টি practice task নিজে সমাধান করেছি।

## Quick reference

| Constraint / attribute | কাজ |
|---|---|
| `NOT NULL` | NULL value আটকায় |
| `UNIQUE` | Duplicate non-NULL value আটকায় |
| `PRIMARY KEY` | Row-এর unique, non-NULL identifier |
| `FOREIGN KEY` | Parent table-এর valid key reference নিশ্চিত করে |
| `CHECK` | Condition মেনে চলা নিশ্চিত করে |
| `DEFAULT` | Value না দিলে default value দেয় |
| `AUTO_INCREMENT` | Numeric ID স্বয়ংক্রিয়ভাবে তৈরি করতে সাহায্য করে |

## Roadmap অনুযায়ী পরের Phase

**Phase 15 — Database Design & Normalization**

পরের Phase-এ table design, duplicate data-এর সমস্যা, 1NF, 2NF, 3NF এবং normalization-এর practical example শিখবে।

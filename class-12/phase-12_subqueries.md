# MySQL শেখার Roadmap — Phase 12: Subqueries

এই ফাইলে MySQL-এর **Subquery** একদম beginner level থেকে ধাপে ধাপে শেখানো হয়েছে। প্রতিটি query নিজে চালিয়ে দেখো, তারপর practice section-এর প্রশ্নগুলো সমাধান করো।

## এই Phase-এ কী শিখবে

এই Phase শেষে তুমি পারবে:

- Subquery কী এবং কেন ব্যবহার করা হয় তা ব্যাখ্যা করতে।
- `WHERE`-এর ভেতরে subquery লিখতে।
- একটি মান ফেরত দেওয়া subquery এবং একাধিক row ফেরত দেওয়া subquery-এর পার্থক্য বুঝতে।
- `IN`, `NOT IN`, `EXISTS`, `NOT EXISTS`, `ANY` এবং `ALL` ব্যবহার করতে।
- `SELECT` ও `FROM`-এর মধ্যে subquery লিখতে।
- Correlated ও non-correlated subquery চিনতে।
- কখন `JOIN` এবং কখন subquery ব্যবহার করা সুবিধাজনক, তা প্রাথমিকভাবে বুঝতে।

---

## 1. Subquery কী?

**Subquery হলো একটি SQL query-এর ভেতরে থাকা আরেকটি SQL query।** একে inner query বা nested query-ও বলা হয়। যে query-টির ভেতরে subquery থাকে, সেটিকে outer query বলা হয়।

সাধারণ উদাহরণ:

```sql
SELECT student_name, age
FROM students
WHERE age > (
    SELECT AVG(age)
    FROM students
);
```

এখানে:

- ভেতরের query: `SELECT AVG(age) FROM students`
- বাইরের query: `SELECT student_name, age FROM students WHERE age > (...)`
- ভেতরের query প্রথমে গড় বয়স বের করে।
- বাইরের query সেই গড় বয়সের চেয়ে বেশি বয়সী শিক্ষার্থীদের দেখায়।

ধরো, গড় বয়স ২১। তাহলে বাইরের query কার্যত এমন হবে:

```sql
SELECT student_name, age
FROM students
WHERE age > 21;
```

**মনে রাখবে:** subquery-র ফলাফল সবসময় একটি মাত্র সংখ্যা হবে, এমন নয়। এটি একটি value, একটি column-এর একাধিক value, অথবা একটি table-এর মতো result দিতে পারে। কোন operator ব্যবহার করবে, তা result-এর ধরন অনুযায়ী ঠিক করতে হয়।

## 2. Practice database ও sample data

এই Phase-এর উদাহরণগুলোতে `students` এবং `departments` table ব্যবহার করা হয়েছে। Phase 11-এর table-গুলো থাকলে এই অংশ বাদ দিয়ে পরের section-এ যেতে পারো।

নতুন করে sample data তৈরি করতে চাইলে নিচের script ব্যবহার করো। সতর্কতা: এই script একই নামের table থাকলে সেগুলো মুছে নতুন করে তৈরি করবে। আগের গুরুত্বপূর্ণ data থাকলে এটি চালিও না।

```sql
CREATE DATABASE IF NOT EXISTS mysql_practice;
USE mysql_practice;

DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS departments;

CREATE TABLE departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    age INT,
    city VARCHAR(50),
    marks DECIMAL(5,2),
    department_id INT,
    FOREIGN KEY (department_id)
        REFERENCES departments(department_id)
);

INSERT INTO departments (department_id, department_name)
VALUES
(1, 'Computer Science'),
(2, 'Business'),
(3, 'English'),
(4, 'Mathematics');

INSERT INTO students
(student_id, student_name, age, city, marks, department_id)
VALUES
(101, 'Amina', 20, 'Dhaka', 85, 1),
(102, 'Rahim', 22, 'Khulna', 72, 2),
(103, 'Karim', 21, 'Dhaka', 91, 1),
(104, 'Nila', 23, 'Sylhet', 68, 3),
(105, 'Sadia', 19, 'Khulna', 88, 2),
(106, 'Hasan', 24, 'Dhaka', 76, 4),
(107, 'Mitu', 22, 'Rajshahi', 95, 1),
(108, 'Rafi', 20, 'Sylhet', 60, NULL);
```

Data ঠিকমতো এসেছে কি না যাচাই করো:

```sql
SELECT * FROM departments;
SELECT * FROM students;
```

## 3. Subquery কেন দরকার?

ধরো, তুমি average marks-এর চেয়ে বেশি নম্বর পাওয়া শিক্ষার্থীদের খুঁজতে চাও। আগে average বের করে সেটি হাতে লিখে query চালানো যায়, কিন্তু data বদলালে average-ও বদলে যাবে। Subquery ব্যবহার করলে MySQL নিজেই বর্তমান data থেকে average বের করে নেয়।

```sql
SELECT student_name, marks
FROM students
WHERE marks > (
    SELECT AVG(marks)
    FROM students
);
```

সুবিধা:

- এক query-এর ফলাফল আরেক query-তে ব্যবহার করা যায়।
- হিসাব করে পাওয়া value হাতে লিখতে হয় না।
- Data পরিবর্তন হলেও query নতুন ফলাফল অনুযায়ী কাজ করে।
- জটিল প্রশ্নকে ছোট ছোট logical ধাপে ভাগ করা যায়।

---

## 4. Scalar subquery — একটি value ফেরত দেয়

যে subquery একটি মাত্র value ফেরত দেয়, তাকে সাধারণভাবে scalar subquery বলা হয়।

### Example 1: সর্বোচ্চ নম্বর পাওয়া শিক্ষার্থীর নম্বর

```sql
SELECT MAX(marks)
FROM students;
```

এটি একটি value দেয়, যেমন `95.00`। এই value-টি subquery হিসেবে ব্যবহার করা যায়:

```sql
SELECT student_name, marks
FROM students
WHERE marks = (
    SELECT MAX(marks)
    FROM students
);
```

### Example 2: গড় নম্বরের চেয়ে বেশি পাওয়া শিক্ষার্থী

```sql
SELECT student_name, marks
FROM students
WHERE marks > (
    SELECT AVG(marks)
    FROM students
);
```

### Example 3: নির্দিষ্ট department-এর শিক্ষার্থীর সংখ্যা তুলনা

প্রথমে Business department-এর ID বের করি:

```sql
SELECT department_id
FROM departments
WHERE department_name = 'Business';
```

এটি একটি ID ফেরত দেয়। তাই নিচের query-তে `=` ব্যবহার করা যায়:

```sql
SELECT student_name, department_id
FROM students
WHERE department_id = (
    SELECT department_id
    FROM departments
    WHERE department_name = 'Business'
);
```

**গুরুত্বপূর্ণ:** `=`-এর পরে থাকা subquery যদি একাধিক row ফেরত দেয়, MySQL error দিতে পারে: `Subquery returns more than 1 row`। একাধিক সম্ভাব্য value-এর জন্য `IN` ব্যবহার করা যায়।

---

## 5. Subquery-এর সঙ্গে comparison operators

Scalar subquery-এর result-এর সঙ্গে `=`, `>`, `<`, `>=`, `<=`, `<>` ব্যবহার করা যায়—যদি subquery একটি value ফেরত দেয়।

```sql
-- Average marks-এর চেয়ে বেশি
SELECT student_name, marks
FROM students
WHERE marks > (SELECT AVG(marks) FROM students);

-- সর্বনিম্ন marks-এর সমান
SELECT student_name, marks
FROM students
WHERE marks = (SELECT MIN(marks) FROM students);

-- সর্বোচ্চ marks নয়
SELECT student_name, marks
FROM students
WHERE marks < (SELECT MAX(marks) FROM students);
```

যদি `marks`-এর value `NULL` হয়, সাধারণ comparison দিয়ে সেটি match করবে না। `NULL`-এর জন্য `IS NULL` / `IS NOT NULL` লাগে।

## 6. `IN` — subquery-এর ফলাফলের মধ্যে আছে কি না

`IN` ব্যবহার করা হয় যখন subquery একাধিক value ফেরত দিতে পারে।

### Example: যেসব department-এ শিক্ষার্থী আছে

```sql
SELECT department_id, department_name
FROM departments
WHERE department_id IN (
    SELECT department_id
    FROM students
);
```

ভেতরের query শিক্ষার্থীদের department ID ফেরত দেয়। বাইরের query সেই ID-গুলোর department দেখায়।

### Example: Dhaka বা Khulna-তে থাকা শিক্ষার্থীদের department-এ যারা আছে

```sql
SELECT student_name, department_id
FROM students
WHERE department_id IN (
    SELECT department_id
    FROM students
    WHERE city IN ('Dhaka', 'Khulna')
);
```

এখানে inner query Dhaka ও Khulna-র শিক্ষার্থীদের department ID বের করে; outer query সেই department-গুলোর সব শিক্ষার্থী দেখায়।

**`IN` মনে রাখার সহজ উপায়:** “এই value-টি কি subquery থেকে পাওয়া value-গুলোর তালিকায় আছে?”

## 7. `NOT IN` — ফলাফলের তালিকায় নেই

যেসব department-এ কোনো শিক্ষার্থী নেই, সেগুলো খুঁজতে:

```sql
SELECT department_id, department_name
FROM departments
WHERE department_id NOT IN (
    SELECT department_id
    FROM students
    WHERE department_id IS NOT NULL
);
```

এখানে `IS NOT NULL` রাখা হয়েছে একটি গুরুত্বপূর্ণ কারণের জন্য। `NOT IN`-এর subquery result-এ `NULL` থাকলে comparison অপ্রত্যাশিতভাবে কোনো row না-ও ফেরত দিতে পারে। তাই `NOT IN` ব্যবহার করার সময় inner query-র সম্ভাব্য `NULL` value খেয়াল করবে।

একই কাজ `NOT EXISTS` দিয়ে অনেক সময় আরও নিরাপদভাবে লেখা যায়; সেটি নিচে শেখানো হয়েছে।

## 8. `ANY` / `SOME` — অন্তত একটি value-এর সঙ্গে শর্ত মেলে

`ANY` বোঝায়: subquery-এর result-এর **অন্তত একটি** value-এর সঙ্গে comparison সত্য হলেই row match করবে। MySQL-এ `SOME` একই অর্থে ব্যবহার করা যায়।

```sql
SELECT student_name, marks
FROM students
WHERE marks > ANY (
    SELECT marks
    FROM students
    WHERE department_id = 2
);
```

অর্থ: Business department-এর অন্তত একজন শিক্ষার্থীর নম্বরের চেয়ে বেশি নম্বর যাদের, তাদের দেখাও।

যদি Business department-এর marks হয় `72` এবং `88`, তাহলে `marks > ANY (...)` কার্যত `72`-এর চেয়ে বেশি হওয়ার মতো কাজ করবে, কারণ অন্তত একটি value-এর সঙ্গে শর্ত সত্য হলেই যথেষ্ট।

আরও একটি উদাহরণ:

```sql
SELECT student_name, marks
FROM students
WHERE marks < ANY (
    SELECT marks
    FROM students
    WHERE department_id = 1
);
```

অর্থ: Computer Science department-এর অন্তত একজন শিক্ষার্থীর নম্বরের চেয়ে কম marks যাদের, তাদের দেখাও।

`ANY` একটু advanced মনে হলে এখন মূলত `IN` ও scalar subquery ভালোভাবে অনুশীলন করো; পরে `ANY`-তে ফিরে আসতে পারো।

## 9. `ALL` — সব value-এর সঙ্গে শর্ত মেলে

`ALL` বোঝায়: subquery থেকে পাওয়া **প্রতিটি** value-এর সঙ্গে comparison সত্য হতে হবে।

```sql
SELECT student_name, marks
FROM students
WHERE marks > ALL (
    SELECT marks
    FROM students
    WHERE department_id = 2
);
```

অর্থ: Business department-এর সব শিক্ষার্থীর marks-এর চেয়ে বেশি marks যাদের, তাদের দেখাও।

যদি Business department-এর marks `72` এবং `88` হয়, তাহলে `marks > ALL (...)`-এর জন্য marks-কে `88`-এর চেয়েও বেশি হতে হবে।

তুলনা:

- `> ANY (...)`: অন্তত একটি value-এর চেয়ে বেশি।
- `> ALL (...)`: সব value-এর চেয়ে বেশি।

`ANY` ও `ALL` ব্যবহার করার সময় `NULL` value comparison-কে প্রভাবিত করতে পারে। প্রয়োজনে inner query-তে `WHERE marks IS NOT NULL` যোগ করো।

```sql
SELECT student_name, marks
FROM students
WHERE marks > ALL (
    SELECT marks
    FROM students
    WHERE department_id = 2
      AND marks IS NOT NULL
);
```

---

## 10. `EXISTS` — অন্তত একটি matching row আছে কি না

`EXISTS` subquery থেকে row পাওয়া যায় কি না তা পরীক্ষা করে। সাধারণত এটি correlated subquery-এর সঙ্গে দেখা যায়।

### Example: যেসব department-এ অন্তত একজন শিক্ষার্থী আছে

```sql
SELECT d.department_id, d.department_name
FROM departments AS d
WHERE EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

ব্যাখ্যা:

1. বাইরের query `departments` table-এর প্রতিটি department পরীক্ষা করে।
2. ভেতরের query দেখে ওই department-এর ID-র সঙ্গে মেলে এমন শিক্ষার্থী আছে কি না।
3. matching row থাকলে `EXISTS` সত্য হয় এবং department-টি result-এ আসে।
4. matching row না থাকলে department-টি বাদ যায়।

`SELECT 1` কেন? `EXISTS`-এর ক্ষেত্রে ভেতরের query কী value select করছে, তার চেয়ে row পাওয়া যাচ্ছে কি না সেটাই গুরুত্বপূর্ণ। তাই `SELECT 1` প্রচলিত একটি রীতি।

### Example: অন্তত একজন শিক্ষার্থী আছে এমন department-এর নাম

```sql
SELECT department_name
FROM departments AS d
WHERE EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

## 11. `NOT EXISTS` — matching row একটিও নেই

যেসব department-এ কোনো শিক্ষার্থী নেই:

```sql
SELECT d.department_id, d.department_name
FROM departments AS d
WHERE NOT EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

`NOT EXISTS` তখনই সত্য হবে, যখন inner query কোনো matching row পাবে না।

`NOT IN` বনাম `NOT EXISTS`:

- `NOT IN`-এর subquery result-এ `NULL` থাকলে সমস্যা হতে পারে।
- `NOT EXISTS` matching row আছে কি না পরীক্ষা করে এবং এই ধরনের anti-match query-তে প্রায়ই সুবিধাজনক।
- বড় data-তে কোনটি দ্রুত হবে, তা query plan, index ও data-র ওপর নির্ভর করে।

---

## 12. `SELECT`-এর মধ্যে subquery

`SELECT` list-এর মধ্যে scalar subquery লিখে প্রতিটি row-এর পাশে একটি হিসাব দেখানো যায়।

```sql
SELECT
    student_name,
    marks,
    (SELECT AVG(marks) FROM students) AS overall_average
FROM students;
```

এখানে প্রতিটি শিক্ষার্থীর row-এর পাশে পুরো table-এর average marks দেখা যাবে।

আরও একটি উদাহরণ:

```sql
SELECT
    student_name,
    marks,
    marks - (SELECT AVG(marks) FROM students) AS difference_from_average
FROM students;
```

এটি প্রত্যেক শিক্ষার্থীর marks গড় marks থেকে কত বেশি বা কম তা দেখায়। `marks` যদি `NULL` হয়, difference-ও `NULL` হবে।

**সতর্কতা:** `SELECT` list-এ ব্যবহৃত scalar subquery-কে একটি value দিতে হবে। একাধিক row ফেরত দিলে error হতে পারে।

## 13. `FROM`-এর মধ্যে subquery — Derived table

`FROM`-এর মধ্যে subquery ব্যবহার করে একটি অস্থায়ী result set তৈরি করা যায়। MySQL-এ `FROM`-এর subquery-কে derived table বলা হয় এবং সাধারণত একটি alias দিতে হয়।

```sql
SELECT department_id, average_marks
FROM (
    SELECT department_id, AVG(marks) AS average_marks
    FROM students
    GROUP BY department_id
) AS department_averages;
```

ভেতরের query প্রতি department-এর average marks বের করে। বাইরের query সেই result set থেকে data পড়ে।

Average marks 75-এর বেশি এমন department-গুলো খুঁজতে:

```sql
SELECT department_id, average_marks
FROM (
    SELECT department_id, AVG(marks) AS average_marks
    FROM students
    GROUP BY department_id
) AS department_averages
WHERE average_marks > 75;
```

কেন alias `department_averages` দেওয়া হয়েছে? MySQL-এ derived table-এর একটি নাম থাকা দরকার, যাতে outer query সেটিকে table-এর মতো refer করতে পারে।

## 14. Correlated বনাম non-correlated subquery

### Non-correlated subquery

Inner query বাইরের query-র কোনো column-এর ওপর নির্ভর করে না। এটি একা চালালেও ফলাফল পাওয়া যায়।

```sql
SELECT student_name, marks
FROM students
WHERE marks > (
    SELECT AVG(marks)
    FROM students
);
```

ভেতরের query `AVG(marks)` হিসাব করতে বাইরের `students` row-এর কোনো value ব্যবহার করছে না।

### Correlated subquery

Inner query বাইরের query-র current row-এর value ব্যবহার করে।

```sql
SELECT d.department_name
FROM departments AS d
WHERE EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

এখানে `s.department_id = d.department_id`-এর `d.department_id` বাইরের query থেকে এসেছে। তাই এটি correlated subquery।

আরও উদাহরণ: নিজের department-এর average marks-এর চেয়ে বেশি marks পাওয়া শিক্ষার্থীদের খুঁজে বের করা।

```sql
SELECT s.student_name, s.department_id, s.marks
FROM students AS s
WHERE s.marks > (
    SELECT AVG(s2.marks)
    FROM students AS s2
    WHERE s2.department_id = s.department_id
);
```

ধাপে ধাপে:

1. বাইরের query একটি শিক্ষার্থীকে পরীক্ষা করে।
2. inner query ওই শিক্ষার্থীর department-এর average marks বের করে।
3. বাইরের শিক্ষার্থীর marks সেই average-এর চেয়ে বেশি হলে row result-এ আসে।
4. এরপর অন্য শিক্ষার্থীর জন্য একই যুক্তি প্রযোজ্য হয়।

এই উদাহরণে `s2` হলো inner query-র table alias, আর `s` হলো outer query-র alias।

## 15. Subquery বনাম JOIN — কখন কোনটি?

একই ধরনের প্রশ্ন কখনও `JOIN`, কখনও subquery দিয়ে সমাধান করা যায়।

`JOIN` উদাহরণ:

```sql
SELECT s.student_name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

`IN` subquery উদাহরণ: শিক্ষার্থী আছে এমন department-গুলো:

```sql
SELECT department_name
FROM departments
WHERE department_id IN (
    SELECT department_id
    FROM students
);
```

সহজ ধারণা:

- দুই table-এর column একসঙ্গে দেখাতে চাইলে `JOIN` সাধারণত সরাসরি ও পরিষ্কার।
- অন্য query-র result দিয়ে filter করতে চাইলে subquery স্বাভাবিক পছন্দ হতে পারে।
- “অন্তত একটি matching row আছে কি?” ধরনের প্রশ্নে `EXISTS` খুব উপযোগী।
- Performance-এর জন্য সবসময় একটিই সেরা—এমন নিয়ম নেই। বাস্তব data-তে `EXPLAIN` দিয়ে query plan দেখা যায়; performance optimization roadmap-এর পরের দিকের topic।

## 16. সাধারণ ভুল ও সমাধান

### ভুল 1: `=` ব্যবহার করে একাধিক row পাওয়া

ভুল হতে পারে:

```sql
SELECT student_name
FROM students
WHERE department_id = (
    SELECT department_id
    FROM students
    WHERE city = 'Dhaka'
);
```

Dhaka-তে একাধিক শিক্ষার্থী থাকলে inner query একাধিক department ID দিতে পারে।

সংশোধন:

```sql
SELECT student_name
FROM students
WHERE department_id IN (
    SELECT department_id
    FROM students
    WHERE city = 'Dhaka'
);
```

### ভুল 2: Subquery-তে একাধিক column ফেরত দেওয়া

এই query scalar comparison-এর জন্য ভুল:

```sql
SELECT student_name
FROM students
WHERE marks > (
    SELECT student_id, marks
    FROM students
);
```

`marks > (...)`-এর ভেতরের subquery-তে একটি value ফেরত দিতে হবে। যেমন:

```sql
SELECT student_name
FROM students
WHERE marks > (
    SELECT AVG(marks)
    FROM students
);
```

### ভুল 3: `NOT IN`-এ NULL উপেক্ষা করা

Subquery-র result-এ `NULL` থাকতে পারে কি না যাচাই করো। প্রয়োজন হলে `IS NOT NULL` ব্যবহার করো, অথবা উপযুক্ত ক্ষেত্রে `NOT EXISTS` লেখো।

### ভুল 4: Derived table-এর alias না দেওয়া

ভুল/অসম্পূর্ণ:

```sql
SELECT *
FROM (
    SELECT department_id
    FROM students
);
```

সঠিক:

```sql
SELECT *
FROM (
    SELECT department_id
    FROM students
) AS student_departments;
```

### ভুল 5: Correlated subquery-তে alias গুলিয়ে ফেলা

Outer ও inner table একই হলে আলাদা alias ব্যবহার করো, যেমন `s` এবং `s2`। এতে কোন column কোন query-র, তা বোঝা সহজ হয়।

---

## 17. Practice tasks — নিজে সমাধান করো

প্রথমে উত্তর না দেখে চেষ্টা করো।

1. Average marks-এর চেয়ে বেশি marks পাওয়া শিক্ষার্থীদের নাম ও marks দেখাও।
2. সর্বোচ্চ marks পাওয়া শিক্ষার্থীর নাম দেখাও।
3. অন্তত একজন শিক্ষার্থী আছে এমন department-এর নাম দেখাও।
4. কোনো শিক্ষার্থী নেই এমন department-এর নাম দেখাও।
5. Business department-এর শিক্ষার্থীদের নাম দেখাও—subquery ব্যবহার করে।
6. Computer Science department-এর সব শিক্ষার্থীর marks-এর চেয়ে বেশি marks পাওয়া শিক্ষার্থীদের খুঁজে বের করো।
7. প্রতিটি শিক্ষার্থীর পাশে overall average marks দেখাও।
8. প্রতি department-এর average marks বের করে শুধু average 75-এর বেশি এমন department ID দেখাও।
9. নিজের department-এর average marks-এর চেয়ে বেশি marks পাওয়া শিক্ষার্থীদের খুঁজে বের করো।
10. `NOT IN` এবং `NOT EXISTS` দিয়ে কোনো শিক্ষার্থী নেই এমন department খোঁজার query লেখো।

## 18. Practice tasks — উত্তর

### উত্তর 1

```sql
SELECT student_name, marks
FROM students
WHERE marks > (
    SELECT AVG(marks)
    FROM students
);
```

### উত্তর 2

```sql
SELECT student_name
FROM students
WHERE marks = (
    SELECT MAX(marks)
    FROM students
);
```

### উত্তর 3

```sql
SELECT department_name
FROM departments AS d
WHERE EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

### উত্তর 4

```sql
SELECT department_name
FROM departments AS d
WHERE NOT EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

### উত্তর 5

```sql
SELECT student_name
FROM students
WHERE department_id IN (
    SELECT department_id
    FROM departments
    WHERE department_name = 'Business'
);
```

### উত্তর 6

```sql
SELECT student_name, marks
FROM students
WHERE marks > ALL (
    SELECT marks
    FROM students
    WHERE department_id = (
        SELECT department_id
        FROM departments
        WHERE department_name = 'Computer Science'
    )
      AND marks IS NOT NULL
);
```

### উত্তর 7

```sql
SELECT
    student_name,
    marks,
    (SELECT AVG(marks) FROM students) AS overall_average
FROM students;
```

### উত্তর 8

```sql
SELECT department_id, average_marks
FROM (
    SELECT department_id, AVG(marks) AS average_marks
    FROM students
    GROUP BY department_id
) AS department_averages
WHERE average_marks > 75;
```

### উত্তর 9

```sql
SELECT s.student_name, s.department_id, s.marks
FROM students AS s
WHERE s.marks > (
    SELECT AVG(s2.marks)
    FROM students AS s2
    WHERE s2.department_id = s.department_id
);
```

### উত্তর 10 — `NOT IN`

```sql
SELECT department_name
FROM departments
WHERE department_id NOT IN (
    SELECT department_id
    FROM students
    WHERE department_id IS NOT NULL
);
```

### উত্তর 10 — `NOT EXISTS`

```sql
SELECT d.department_name
FROM departments AS d
WHERE NOT EXISTS (
    SELECT 1
    FROM students AS s
    WHERE s.department_id = d.department_id
);
```

---

## 19. ছোট Quiz

1. Subquery কী?
2. `=`-এর সঙ্গে subquery ব্যবহার করার সময় inner query-র result-এর ধরন কী হওয়া উচিত?
3. একাধিক সম্ভাব্য value-এর জন্য `IN` কেন উপযোগী?
4. `EXISTS` কী পরীক্ষা করে?
5. `ANY` এবং `ALL`-এর মূল পার্থক্য কী?
6. Correlated subquery কীভাবে outer query-র ওপর নির্ভর করে?
7. `FROM`-এর ভেতরের subquery-কে কী বলা হয়?
8. `NOT IN`-এর subquery result-এ `NULL` থাকলে কেন সতর্ক হতে হয়?

### Quiz-এর সংক্ষিপ্ত উত্তর

1. একটি query-এর ভেতরে থাকা আরেকটি query।
2. একটি value / একটি row-এর একটি column-এর scalar result।
3. কারণ inner query একাধিক value ফেরত দিতে পারে।
4. matching row আছে কি না।
5. `ANY`-তে অন্তত একটি value-এর সঙ্গে শর্ত সত্য হলেই হয়; `ALL`-তে সব value-এর সঙ্গে শর্ত সত্য হতে হয়।
6. inner query outer query-র column reference করে।
7. Derived table।
8. `NULL`-এর কারণে `NOT IN` comparison `UNKNOWN` হতে পারে এবং প্রত্যাশিত row নাও আসতে পারে।

---

## 20. Phase 12 Completion Checklist

নিচের সবগুলো করতে পারলে Phase 12 শেষ:

- [ ] Subquery ও outer query-এর পার্থক্য বলতে পারি।
- [ ] Scalar subquery লিখতে পারি।
- [ ] `IN` ও `NOT IN` ব্যবহার করতে পারি এবং `NULL`-এর সতর্কতা বুঝি।
- [ ] `EXISTS` ও `NOT EXISTS` ব্যবহার করতে পারি।
- [ ] `ANY` ও `ALL`-এর পার্থক্য বুঝি।
- [ ] `SELECT` ও `FROM`-এর মধ্যে subquery লিখতে পারি।
- [ ] Correlated ও non-correlated subquery আলাদা করতে পারি।
- [ ] Practice tasks-এর অন্তত 8টি নিজে সমাধান করতে পেরেছি।

## Quick Reference

| Pattern | কখন ব্যবহার করবে |
|---|---|
| `= (subquery)` | Subquery একটি scalar value দিলে |
| `> (subquery)` | একটি value-এর সঙ্গে তুলনা করতে |
| `IN (subquery)` | result-এর তালিকায় value আছে কি না |
| `NOT IN (subquery)` | result-এর তালিকায় value নেই কি না; NULL সতর্কতা প্রয়োজন |
| `EXISTS (subquery)` | matching row অন্তত একটি আছে কি না |
| `NOT EXISTS (subquery)` | matching row একটিও নেই কি না |
| `> ANY (subquery)` | অন্তত একটি result value-এর চেয়ে বেশি |
| `> ALL (subquery)` | সব result value-এর চেয়ে বেশি |
| `FROM (subquery) AS alias` | subquery result-কে derived table হিসেবে ব্যবহার |

---

## Roadmap অনুযায়ী পরের Phase

**Phase 13 — CASE Statement**

পরের Phase-এ `CASE`, `WHEN`, `THEN`, `ELSE`, `END` ব্যবহার করে SQL query-র মধ্যে conditional logic তৈরি করা শিখবে।

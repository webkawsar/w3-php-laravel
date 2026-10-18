# MySQL Roadmap — Phase 8: SQL JOINs

**ভাষা:** বাংলা  
**লক্ষ্য:** একাধিক table-এর related data এক query-তে আনা।

## 1. এই Phase-এ কী শিখবে?

- `INNER JOIN`, `LEFT JOIN`, `RIGHT JOIN` ব্যবহার
- `ON` condition ও table alias
- unmatched row খুঁজতে `LEFT JOIN`
- `CROSS JOIN` ও `SELF JOIN`
- একাধিক table join করে report তৈরি

## 2. JOIN কেন প্রয়োজন?

ধরে নিই দুটি table আছে।

**students**

| student_id | name | department_id |
|---:|---|---:|
| 1 | Ayan | 10 |
| 2 | Rima | 20 |
| 3 | Sami | 10 |
| 4 | Nila | 30 |
| 5 | Tania | NULL |

**departments**

| department_id | department_name |
|---:|---|
| 10 | CSE |
| 20 | BBA |
| 30 | EEE |
| 40 | English |

`students.department_id` এবং `departments.department_id` matching columns। `JOIN` দিয়ে দুই table-এর related data একসঙ্গে দেখা যায়।

## 3. `INNER JOIN`

শুধু matching row ফেরত দেয়।

```sql
SELECT s.name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

Result-এ Ayan/CSE, Rima/BBA, Sami/CSE, Nila/EEE থাকবে। Tania-র department `NULL`, তাই match হয়নি। English department-এর কোনো student নেই, তাই সেটিও result-এ আসবে না।

`JOIN` লিখলেও MySQL-এ সাধারণত `INNER JOIN`-এর মতোই কাজ করে। `s` ও `d` হলো table alias, যা query ছোট ও পড়তে সহজ করে।

## 4. `LEFT JOIN`

বাম পাশের table-এর **সব row** রাখে। ডান পাশের table-এ match না থাকলে ডান পাশের column-গুলো `NULL` হয়।

```sql
SELECT s.name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id;
```

এবার Tania-ও result-এ থাকবে, তার `department_name` হবে `NULL`।

### Department match পাওয়া যায়নি এমন student খোঁজা

```sql
SELECT s.student_id, s.name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_id IS NULL;
```

`NULL` পরীক্ষা করতে `IS NULL` ব্যবহার করবে, `= NULL` নয়।

### যেসব department-এ কোনো student নেই

```sql
SELECT d.department_id, d.department_name
FROM departments AS d
LEFT JOIN students AS s
    ON s.department_id = d.department_id
WHERE s.student_id IS NULL;
```

এখানে English department দেখা যাবে, কারণ কোনো student-এর `department_id = 40` নেই।

## 5. `RIGHT JOIN`

ডান পাশের table-এর সব row রাখে। বাম পাশের table-এ match না থাকলে বাম পাশের column-গুলো `NULL` হয়।

```sql
SELECT s.name, d.department_name
FROM students AS s
RIGHT JOIN departments AS d
    ON s.department_id = d.department_id;
```

English department result-এ থাকবে, কিন্তু `name` হবে `NULL`। `RIGHT JOIN`-কে table-এর order বদলে `LEFT JOIN` দিয়েও লেখা যায়; অনেক developer clarity-এর জন্য `LEFT JOIN` বেশি ব্যবহার করেন।

## 6. JOIN-গুলোর পার্থক্য

| JOIN type | কী রাখে? |
|---|---|
| `INNER JOIN` | শুধু matching row |
| `LEFT JOIN` | left table-এর সব row + right table-এর match |
| `RIGHT JOIN` | right table-এর সব row + left table-এর match |
| `CROSS JOIN` | সব possible combination |
| `SELF JOIN` | একই table-কে নিজের সঙ্গে join |

## 7. `ON` বনাম `WHERE`

- `ON`: table-গুলোর row কীভাবে match হবে তা নির্ধারণ করে।
- `WHERE`: join result থেকে row filter করে।

শুধু CSE student দেখতে:

```sql
SELECT s.name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'CSE';
```

`LEFT JOIN`-এ condition কোথায় রাখছ, তা result বদলাতে পারে।

সব student রাখতে চাও, তবে department match শুধু CSE হলে হবে:

```sql
SELECT s.name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id
   AND d.department_name = 'CSE';
```

এখানে সব student থাকবে; non-CSE student-এর `department_name` হবে `NULL`। কিন্তু নিচের query শুধু CSE match-যুক্ত student রাখবে:

```sql
SELECT s.name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'CSE';
```

কারণ `WHERE` condition unmatched row-গুলোও বাদ দেয়।

## 8. `CROSS JOIN`

দুই table-এর প্রতিটি row-এর সঙ্গে অন্য table-এর প্রতিটি row combine করে। এটিকে Cartesian product-ও বলা হয়। 3টি color ও 2টি size থাকলে 3 × 2 = 6টি combination হবে।

```sql
SELECT c.color_name, s.size_name
FROM colors AS c
CROSS JOIN sizes AS s;
```

বড় table হলে result অনেক বড় হতে পারে, তাই সতর্ক থাকবে।

## 9. `SELF JOIN`

একই table-কে alias দিয়ে নিজের সঙ্গে join করা। ধরো `employees` table-এ manager-ও employee table-এ রাখা আছে।

| employee_id | employee_name | manager_id |
|---:|---|---:|
| 1 | Sara | NULL |
| 2 | Karim | 1 |
| 3 | Mina | 1 |
| 4 | Rafi | 2 |

Employee ও manager-এর নাম বের করতে:

```sql
SELECT
    e.employee_name AS employee,
    m.employee_name AS manager
FROM employees AS e
LEFT JOIN employees AS m
    ON e.manager_id = m.employee_id;
```

`e` employee-কে এবং `m` manager-কে বোঝায়। Sara-র manager নেই, তাই তার manager value `NULL` থাকবে।

## 10. একাধিক table JOIN করা

ধরে নাও `enrollments` table student ও course-এর সম্পর্ক রাখে।

**enrollments**

| student_id | course_id |
|---:|---:|
| 1 | 101 |
| 1 | 102 |
| 2 | 101 |

**courses**

| course_id | course_name |
|---:|---|
| 101 | SQL Basics |
| 102 | Web Development |

Student-এর নাম ও course name দেখাতে:

```sql
SELECT s.name, c.course_name
FROM students AS s
INNER JOIN enrollments AS e
    ON s.student_id = e.student_id
INNER JOIN courses AS c
    ON e.course_id = c.course_id;
```

এখানে `students` থেকে নাম, `enrollments` থেকে relationship, আর `courses` থেকে course name পাওয়া যায়। JOIN করার আগে table-গুলোর relationship ও matching key বুঝে নাও।

## 11. Duplicate row কেন আসতে পারে?

এক student 3টি course-এ enrolled থাকলে result-এ তার নাম 3 বার আসতে পারে—প্রতিটি course-এর জন্য একবার। এটি সবসময় ভুল নয়; relationship-এর স্বাভাবিক ফল।

শুধু unique student দেখতে:

```sql
SELECT DISTINCT s.name
FROM students AS s
INNER JOIN enrollments AS e
    ON s.student_id = e.student_id;
```

`DISTINCT` ব্যবহারের আগে নিশ্চিত হও যে duplicate-গুলো সত্যিই বাদ দিতে চাও।

## 12. Common mistakes

### ভুল 1: `ON` condition ভুলে যাওয়া বা ভুল key ব্যবহার করা

```sql
SELECT s.name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

### ভুল 2: ambiguous column name

দুই table-এ `department_id` থাকলে `s.department_id` বা `d.department_id` লিখে স্পষ্ট করো।

### ভুল 3: `= NULL` লেখা

ভুল: `WHERE d.department_id = NULL`

সঠিক: `WHERE d.department_id IS NULL`

### ভুল 4: `LEFT JOIN`-এর পর `WHERE`-এ right table-এর condition দেওয়া

এতে unmatched row বাদ পড়ে query কার্যত `INNER JOIN`-এর মতো result দিতে পারে। সব left-side row রাখতে চাইলে condition `ON`-এ রাখা উচিত কি না, তা ভেবে দেখো।

### ভুল 5: SELF JOIN-এ একই alias ব্যবহার করা

আলাদা alias দাও, যেমন `e` ও `m`।

## 13. Practice Tasks

উপরের `students` ও `departments` data ধরে query লেখার চেষ্টা করো।

1. প্রতিটি student-এর নাম ও department name দেখাও; শুধু matching department থাকবে।
2. সব student দেখাও, department match না থাকলেও।
3. সব department দেখাও, student না থাকলেও।
4. department match পাওয়া যায়নি এমন student বের করো।
5. কোনো student নেই এমন department বের করো।
6. শুধু CSE department-এর student দেখাও।
7. `employees` table-এ employee ও manager-এর নাম দেখাও।
8. `students`, `enrollments`, ও `courses` join করে student এবং course name দেখাও।
9. `colors` ও `sizes` table-এর সব combination দেখাও।
10. JOIN result-এ একই student একাধিকবার আসতে পারে কেন, নিজের ভাষায় ব্যাখ্যা করো।

## 14. Answer Key

### Task 1

```sql
SELECT s.name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id;
```

### Task 2

```sql
SELECT s.name, d.department_name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id;
```

### Task 3

```sql
SELECT d.department_name, s.name
FROM departments AS d
LEFT JOIN students AS s
    ON s.department_id = d.department_id;
```

### Task 4

```sql
SELECT s.student_id, s.name
FROM students AS s
LEFT JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_id IS NULL;
```

### Task 5

```sql
SELECT d.department_id, d.department_name
FROM departments AS d
LEFT JOIN students AS s
    ON s.department_id = d.department_id
WHERE s.student_id IS NULL;
```

### Task 6

```sql
SELECT s.name, d.department_name
FROM students AS s
INNER JOIN departments AS d
    ON s.department_id = d.department_id
WHERE d.department_name = 'CSE';
```

### Task 7

```sql
SELECT e.employee_name AS employee, m.employee_name AS manager
FROM employees AS e
LEFT JOIN employees AS m
    ON e.manager_id = m.employee_id;
```

### Task 8

```sql
SELECT s.name, c.course_name
FROM students AS s
INNER JOIN enrollments AS e
    ON s.student_id = e.student_id
INNER JOIN courses AS c
    ON e.course_id = c.course_id;
```

### Task 9

```sql
SELECT c.color_name, s.size_name
FROM colors AS c
CROSS JOIN sizes AS s;
```

### Task 10 — ব্যাখ্যা

এক student-এর একাধিক related row থাকতে পারে, যেমন একাধিক course-এ enrollment। প্রতিটি matching relationship-এর জন্য তার নাম একবার করে আসতে পারে।

## 15. Quick Quiz

1. `INNER JOIN` কি unmatched row রাখে?
2. `LEFT JOIN` কোন table-এর সব row রাখে?
3. `ON` clause-এর কাজ কী?
4. `NULL` খুঁজতে `= NULL` নাকি `IS NULL` ব্যবহার করবে?
5. একই table-কে নিজের সঙ্গে join করলে তাকে কী বলে?
6. 4-row table ও 3-row table-কে `CROSS JOIN` করলে কত combination হবে?

### উত্তর

1. না।
2. বাম পাশের table-এর সব row।
3. দুই table-এর row কীভাবে match হবে তা নির্ধারণ করে।
4. `IS NULL`।
5. `SELF JOIN`।
6. 4 × 3 = 12টি combination।

## 16. Phase 8 Checklist

- [ ] `INNER JOIN` বুঝেছি এবং লিখতে পারি।
- [ ] `LEFT JOIN` ও `RIGHT JOIN`-এর পার্থক্য বুঝেছি।
- [ ] `ON` condition সঠিকভাবে লিখতে পারি।
- [ ] `WHERE` ও `ON`-এর পার্থক্য বুঝেছি।
- [ ] `IS NULL` দিয়ে unmatched row খুঁজতে পারি।
- [ ] `CROSS JOIN` ও `SELF JOIN`-এর ধারণা বুঝেছি।
- [ ] 3টি table join করে query লিখতে পারি।
- [ ] Practice Tasks নিজে solve করেছি।

## Next Phase

**Phase 9 — Subqueries:** একটি query-এর ভেতরে আরেকটি query ব্যবহার করা, যেমন `IN`, `EXISTS`, scalar subquery এবং correlated subquery।

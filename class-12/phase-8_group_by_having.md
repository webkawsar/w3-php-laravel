# MySQL Roadmap — Phase 7: GROUP BY & HAVING

**ভাষা:** বাংলা  
**লক্ষ্য:** একাধিক row-কে group করে summary বের করা এবং নির্দিষ্ট group filter করা।

## 1. এই Phase-এ কী শিখবে?

- `GROUP BY` দিয়ে একই ধরনের data-কে group করা।
- `COUNT()`, `SUM()`, `AVG()`, `MIN()`, `MAX()` দিয়ে summary বের করা।
- `HAVING` দিয়ে group-level condition দেওয়া।
- `WHERE` ও `HAVING`-এর পার্থক্য বোঝা।
- একাধিক column দিয়ে grouping করা।
- বাস্তব report-এর query লেখা।

## 2. Practice table ও sample data

ধরে নিই `students` table-এ এই data আছে:

| id | name | department | age | city | marks |
|---:|---|---|---:|---|---:|
| 1 | Ayan | CSE | 20 | Dhaka | 85 |
| 2 | Rima | BBA | 21 | Khulna | 78 |
| 3 | Sami | CSE | 22 | Dhaka | 91 |
| 4 | Nila | BBA | 20 | Rajshahi | 88 |
| 5 | Rafi | CSE | 21 | Khulna | 74 |
| 6 | Tania | EEE | 22 | Dhaka | 95 |
| 7 | Imran | EEE | 20 | Khulna | 80 |
| 8 | Mitu | BBA | 23 | Dhaka | 82 |

নিজের table-এ column-এর নাম আলাদা হলে query-তে সেই নাম ব্যবহার করবে।

## 3. Aggregate functions

Aggregate function অনেকগুলো row থেকে summary value তৈরি করে।

| Function | কাজ |
|---|---|
| `COUNT(*)` | মোট row গোনে |
| `COUNT(column)` | ওই column-এর non-`NULL` value গোনে |
| `SUM(column)` | যোগফল বের করে |
| `AVG(column)` | গড় বের করে |
| `MIN(column)` | সবচেয়ে ছোট value বের করে |
| `MAX(column)` | সবচেয়ে বড় value বের করে |

```sql
SELECT COUNT(*) AS total_students
FROM students;
```

এটি পুরো table-এ মোট row-এর সংখ্যা দেখায়।

## 4. `GROUP BY` কী?

`GROUP BY` একই value-যুক্ত row-গুলোকে group করে। এরপর aggregate function দিয়ে প্রতিটি group-এর summary বের করা যায়।

প্রতিটি department-এ কতজন student আছে:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department;
```

সম্ভাব্য result:

| department | total_students |
|---|---:|
| BBA | 3 |
| CSE | 3 |
| EEE | 2 |

কীভাবে কাজ করে:

1. `FROM students` table থেকে data নেয়।
2. `GROUP BY department` একই department-এর row এক group-এ রাখে।
3. `COUNT(*)` প্রতিটি group-এর row গোনে।
4. `SELECT` department ও count দেখায়।

মনে রাখবে: `GROUP BY` নিজে count করে না; count করে `COUNT()`। `GROUP BY` group তৈরি করে।

## 5. `GROUP BY`-এর সঙ্গে `SUM()`

প্রতিটি department-এর মোট marks:

```sql
SELECT department, SUM(marks) AS total_marks
FROM students
GROUP BY department;
```

## 6. `GROUP BY`-এর সঙ্গে `AVG()`

প্রতিটি department-এর average marks:

```sql
SELECT department, AVG(marks) AS average_marks
FROM students
GROUP BY department;
```

Average-কে 2 decimal place পর্যন্ত দেখাতে:

```sql
SELECT department, ROUND(AVG(marks), 2) AS average_marks
FROM students
GROUP BY department;
```

`ROUND(value, 2)` ফলাফলকে 2 decimal place পর্যন্ত round করে।

## 7. `MIN()` এবং `MAX()`

প্রতিটি department-এর সর্বনিম্ন ও সর্বোচ্চ marks:

```sql
SELECT
    department,
    MIN(marks) AS lowest_marks,
    MAX(marks) AS highest_marks
FROM students
GROUP BY department;
```

## 8. একাধিক column দিয়ে `GROUP BY`

প্রতিটি department ও city combination-এ কতজন student আছে:

```sql
SELECT
    department,
    city,
    COUNT(*) AS total_students
FROM students
GROUP BY department, city;
```

এখানে group তৈরি হবে `department` ও `city`-এর combination অনুযায়ী। `CSE + Dhaka` এবং `CSE + Khulna` আলাদা group।

## 9. `HAVING` কী?

`HAVING` group তৈরি হওয়ার পর group-কে filter করে।

যেসব department-এ কমপক্ষে 3 জন student আছে:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department
HAVING COUNT(*) >= 3;
```

BBA ও CSE result-এ থাকবে, কারণ দুটিতেই 3 জন student আছে। EEE-তে 2 জন, তাই সেটি বাদ যাবে।

MySQL-এ `HAVING`-এ `SELECT` alias ব্যবহার করা যায়:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department
HAVING total_students >= 3;
```

শেখার সময় `HAVING COUNT(*) >= 3` লিখলে condition-এর অর্থ স্পষ্ট থাকে।

## 10. `WHERE` বনাম `HAVING`

- `WHERE`: group তৈরির আগে individual row filter করে।
- `HAVING`: group তৈরির পরে group filter করে।

### Example A: marks 80 বা তার বেশি এমন student-দের count, department অনুযায়ী

```sql
SELECT department, COUNT(*) AS total_students
FROM students
WHERE marks >= 80
GROUP BY department;
```

প্রথমে `marks >= 80` নয় এমন row বাদ পড়ে, তারপর বাকি row department অনুযায়ী group হয়।

### Example B: average marks 80-এর বেশি এমন department

```sql
SELECT department, AVG(marks) AS average_marks
FROM students
GROUP BY department
HAVING AVG(marks) > 80;
```

এখানে department অনুযায়ী average বের হওয়ার পর average 80-এর বেশি এমন group রাখা হয়।

### `WHERE` এবং `HAVING` একসঙ্গে

marks অন্তত 75 এমন student-দের বিবেচনায় নিয়ে যেসব department-এর average marks 80-এর বেশি, সেগুলো দেখাও:

```sql
SELECT
    department,
    ROUND(AVG(marks), 2) AS average_marks,
    COUNT(*) AS total_students
FROM students
WHERE marks >= 75
GROUP BY department
HAVING AVG(marks) > 80;
```

1. `WHERE` কম marks-যুক্ত row বাদ দেয়।
2. `GROUP BY` department অনুযায়ী group করে।
3. `AVG()` ও `COUNT()` summary তৈরি করে।
4. `HAVING` group-এর average filter করে।

## 11. `GROUP BY`-এর সঙ্গে `ORDER BY` ও `LIMIT`

সবচেয়ে বেশি student-যুক্ত department আগে দেখাও:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department
ORDER BY total_students DESC;
```

Top 2 department দেখতে:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department
ORDER BY total_students DESC, department ASC
LIMIT 2;
```

দ্বিতীয় sort key (`department ASC`) একই count হলে result-কে consistent রাখতে সাহায্য করে।

## 12. `NULL` value হলে কী হয়?

- `GROUP BY`-এ `NULL` value-গুলো সাধারণত একই group-এ পড়ে।
- `COUNT(*)` সব row গোনে, `NULL`-যুক্ত row-ও।
- `COUNT(marks)` শুধু non-`NULL` marks গোনে।
- `SUM(marks)` ও `AVG(marks)` `NULL` marks-কে হিসাবের মধ্যে ধরে না।

```sql
SELECT
    department,
    COUNT(*) AS total_rows,
    COUNT(marks) AS students_with_marks,
    AVG(marks) AS average_marks
FROM students
GROUP BY department;
```

কোনো group-এর সব marks `NULL` হলে `AVG(marks)` হবে `NULL`।

## 13. সাধারণ ভুল

### ভুল 1: group column নয় এমন column-কে aggregate ছাড়া select করা

```sql
-- এড়িয়ে চলো
SELECT department, name, COUNT(*)
FROM students
GROUP BY department;
```

এক department-এ অনেক student name থাকতে পারে, তাই কোন name দেখাবে তা অস্পষ্ট। MySQL-এর `ONLY_FULL_GROUP_BY` mode চালু থাকলে query error-ও হতে পারে।

সঠিক:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department;
```

### ভুল 2: aggregate condition-এ `WHERE` ব্যবহার করা

```sql
-- ভুল
SELECT department, AVG(marks)
FROM students
WHERE AVG(marks) > 80
GROUP BY department;
```

সঠিক:

```sql
SELECT department, AVG(marks) AS average_marks
FROM students
GROUP BY department
HAVING AVG(marks) > 80;
```

### ভুল 3: `GROUP BY` বাদ দেওয়া

Department অনুযায়ী count চাইলে:

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department;
```

### ভুল 4: `COUNT(column)`-কে `COUNT(*)` ভেবে নেওয়া

`COUNT(*)` row গোনে; `COUNT(column)` কেবল non-`NULL` value গোনে।

## 14. SQL query processing-এর সহজ ধারণা

SQL লেখার ক্রম ও logical processing order এক নয়। এই Phase-এর জন্য সহজভাবে মনে রাখো:

1. `FROM`
2. `WHERE`
3. `GROUP BY`
4. Aggregate calculation
5. `HAVING`
6. `SELECT`
7. `ORDER BY`
8. `LIMIT`

এটি বোঝায় কেন `WHERE` আগে এবং `HAVING` পরে কাজ করে।

## 15. Practice Tasks

প্রথমে নিজে query লেখো, তারপর Answer Key-এর সঙ্গে মিলিয়ে দেখো।

1. প্রতিটি department-এ কতজন student আছে?
2. প্রতিটি city-তে কতজন student আছে?
3. প্রতিটি department-এর average marks বের করো।
4. প্রতিটি department-এর highest ও lowest marks বের করো।
5. শুধু সেই department দেখাও যেখানে 2 জনের বেশি student আছে।
6. average marks 82-এর বেশি এমন department দেখাও।
7. প্রতিটি department-এর মোট marks বের করে descending order-এ সাজাও।
8. প্রতিটি department ও city combination-এ student count বের করো।
9. শুধু marks 80 বা তার বেশি student-দের count department অনুযায়ী বের করো।
10. marks 75 বা তার বেশি student-দের নিয়ে যেসব department-এর average marks 82-এর বেশি, সেগুলো দেখাও।

## 16. Answer Key

### Task 1

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department;
```

### Task 2

```sql
SELECT city, COUNT(*) AS total_students
FROM students
GROUP BY city;
```

### Task 3

```sql
SELECT department, ROUND(AVG(marks), 2) AS average_marks
FROM students
GROUP BY department;
```

### Task 4

```sql
SELECT department, MAX(marks) AS highest_marks, MIN(marks) AS lowest_marks
FROM students
GROUP BY department;
```

### Task 5

```sql
SELECT department, COUNT(*) AS total_students
FROM students
GROUP BY department
HAVING COUNT(*) > 2;
```

### Task 6

```sql
SELECT department, AVG(marks) AS average_marks
FROM students
GROUP BY department
HAVING AVG(marks) > 82;
```

### Task 7

```sql
SELECT department, SUM(marks) AS total_marks
FROM students
GROUP BY department
ORDER BY total_marks DESC;
```

### Task 8

```sql
SELECT department, city, COUNT(*) AS total_students
FROM students
GROUP BY department, city;
```

### Task 9

```sql
SELECT department, COUNT(*) AS total_students
FROM students
WHERE marks >= 80
GROUP BY department;
```

### Task 10

```sql
SELECT department, ROUND(AVG(marks), 2) AS average_marks
FROM students
WHERE marks >= 75
GROUP BY department
HAVING AVG(marks) > 82;
```

## 17. Quick Quiz

1. `GROUP BY`-এর কাজ কী?
2. `COUNT(*)` ও `COUNT(marks)`-এর পার্থক্য কী?
3. `WHERE` আগে কাজ করে, নাকি `HAVING`?
4. Department-এর average marks 80-এর বেশি—এমন group filter করতে কোন clause লাগবে?
5. `GROUP BY department, city` দিলে কী অনুযায়ী group তৈরি হবে?

### উত্তর

1. একই value-যুক্ত row-গুলোকে group করা।
2. `COUNT(*)` সব row গোনে; `COUNT(marks)` non-`NULL` marks গোনে।
3. `WHERE` আগে, `HAVING` পরে।
4. `HAVING`।
5. Department ও city-এর প্রতিটি unique combination অনুযায়ী।

## 18. Phase 7 Checklist

- [ ] `GROUP BY` বুঝেছি।
- [ ] `COUNT()`, `SUM()`, `AVG()`, `MIN()`, `MAX()` দিয়ে summary করতে পারি।
- [ ] একাধিক column দিয়ে grouping করতে পারি।
- [ ] `HAVING` দিয়ে group filter করতে পারি।
- [ ] `WHERE` ও `HAVING`-এর পার্থক্য বুঝেছি।
- [ ] `GROUP BY`-এর সঙ্গে `ORDER BY` ও `LIMIT` ব্যবহার করতে পারি।
- [ ] Practice Tasks নিজে solve করেছি।

## Next Phase

**Phase 8 — JOINs:** একাধিক table-এর data একসঙ্গে আনা (`INNER JOIN`, `LEFT JOIN`, `RIGHT JOIN`)।

পরের Phase-এ যাওয়ার আগে Practice Tasks-এর query-গুলো নিজের MySQL database-এ চালিয়ে দেখো।

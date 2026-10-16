# MySQL Phase 6 — SQL Functions for Beginners

> **Level:** Beginner  
> **Prerequisite:** Phase 1–5  
> **Goal:** SQL functions দিয়ে text, number ও date-এর data transform করা, calculations করা এবং `NULL` value handle করা শেখা।

## 📚 Phase 6 Overview

এই Phase-এ শিখবে:
- SQL Function কী
- String Functions: `UPPER()`, `LOWER()`, `LENGTH()`, `CHAR_LENGTH()`, `CONCAT()`, `TRIM()`, `SUBSTRING()`
- Numeric Functions: `ROUND()`, `CEIL()`, `FLOOR()`, `ABS()`
- Aggregate Functions: `COUNT()`, `SUM()`, `AVG()`, `MIN()`, `MAX()`
- Date Functions: `CURRENT_DATE()`, `NOW()`, `YEAR()`, `MONTH()`, `DATEDIFF()`
- NULL Functions: `IFNULL()`, `COALESCE()`
- Functions-এর সঙ্গে `SELECT`, `WHERE` ও `ORDER BY`
- Practice tasks, challenges ও quiz

> **Note:** কিছু behavior MySQL version, data type ও settings অনুযায়ী ভিন্ন হতে পারে।

## 1. SQL Function কী?

Function হলো SQL-এর built-in operation, যা input নিয়ে result return করে।

```sql
SELECT UPPER('kawsar');
```

Result: `KAWSAR`

```sql
SELECT ROUND(12.678, 2);
```

Result: `12.68`

## 2. Practice Database

আগের Phase-গুলোর `school.students` table ব্যবহার করো।

```sql
USE school;

SELECT *
FROM students;
```

Examples-এ `id`, `name`, `age`, `email`, `city`, `status`, `birth_date`, `marks`, `fee` columns ধরে নেওয়া হয়েছে। তোমার table-এ কোনো column না থাকলে schema অনুযায়ী বদলাবে। Function শেখার জন্য direct values দিয়েও practice করা যায়।

# Part 1 — String Functions

## 3. UPPER() — Uppercase

```sql
SELECT UPPER('kawsar');
```

Result: `KAWSAR`

```sql
SELECT name, UPPER(name) AS uppercase_name
FROM students;
```

এটি শুধু query result transform করে; stored name update করে না।

## 4. LOWER() — Lowercase

```sql
SELECT LOWER('KAWSAR AHMED');
```

Result: `kawsar ahmed`

```sql
SELECT email, LOWER(email) AS lowercase_email
FROM students;
```

## 5. LENGTH() এবং CHAR_LENGTH()

`LENGTH()` byte count করে:

```sql
SELECT LENGTH('Kawsar');
```

Result: `6`

`CHAR_LENGTH()` character count করে:

```sql
SELECT CHAR_LENGTH('Kawsar');
```

Result: `6`

ASCII text-এ সাধারণত দুইটির result একই; Unicode text-এ byte ও character count আলাদা হতে পারে।

## 6. CONCAT() — Values যুক্ত করা

```sql
SELECT CONCAT('Kawsar', ' ', 'Ahmed');
```

Result: `Kawsar Ahmed`

আলাদা first ও last name columns থাকলে:

```sql
SELECT CONCAT(first_name, ' ', last_name) AS full_name
FROM users;
```

`CONCAT()`-এর কোনো argument `NULL` হলে সাধারণত result-ও `NULL` হয়। `CONCAT_WS()` separator-এর পরে দেওয়া `NULL` arguments skip করে:

```sql
SELECT CONCAT_WS(' ', first_name, last_name) AS full_name
FROM users;
```

এখানে `users` ও column names উদাহরণ হিসেবে দেওয়া হয়েছে; নিজের schema অনুযায়ী বদলাবে।

## 7. TRIM() — Extra Space সরানো

```sql
SELECT TRIM('   Kawsar   ');
```

Result: `Kawsar`

```sql
SELECT name, TRIM(name) AS clean_name
FROM students;
```

এটি result clean করে দেখায়; stored value নিজে থেকে পরিবর্তন করে না।

## 8. SUBSTRING() — Text-এর অংশ নেওয়া

```sql
SELECT SUBSTRING('Kawsar Ahmed', 1, 6);
```

Result: `Kawsar`

Syntax: `SUBSTRING(string, start_position, length)`

MySQL-এ position সাধারণত 1 থেকে শুরু হয়।

```sql
SELECT name, SUBSTRING(name, 1, 3) AS first_three_chars
FROM students;
```

## 9. String Functions একসাথে

```sql
SELECT
    name,
    UPPER(name) AS uppercase_name,
    LOWER(name) AS lowercase_name,
    LENGTH(name) AS name_bytes,
    CHAR_LENGTH(name) AS name_characters,
    TRIM(name) AS clean_name
FROM students;
```

# Part 2 — Numeric Functions

## 10. ROUND() — Number Round করা

```sql
SELECT ROUND(12.678, 2);
```

Result: `12.68`

```sql
SELECT ROUND(12.4);
SELECT ROUND(12.6);
SELECT ROUND(123.456, 1);
```

সাধারণ ফলাফল: `12`, `13`, `123.5`

```sql
SELECT name, ROUND(marks, 2) AS rounded_marks
FROM students;
```

## 11. CEIL() — Mathematical Ceiling

```sql
SELECT CEIL(12.1);
```

Result: `13`

## 12. FLOOR() — Mathematical Floor

```sql
SELECT FLOOR(12.9);
```

Result: `12`

## 13. ABS() — Absolute Value

```sql
SELECT ABS(-25);
```

Result: `25`

## 14. Arithmetic + Function

```sql
SELECT
    name,
    marks,
    ROUND(marks + 5, 2) AS adjusted_marks
FROM students;
```

এটি calculated result দেখায়, Table-এর `marks` update করে না।

# Part 3 — Aggregate Functions

Aggregate Functions একাধিক row-এর data নিয়ে summary value return করে। `GROUP BY` শেখার সময় এগুলো আরও বিস্তারিত শিখবে।

## 15. COUNT() — Count করা

```sql
SELECT COUNT(*) AS total_students
FROM students;
```

`COUNT(*)` matching rows count করে।

```sql
SELECT COUNT(email) AS students_with_email
FROM students;
```

`COUNT(email)` শুধু non-`NULL` email count করে।

```sql
SELECT COUNT(*) AS active_students
FROM students
WHERE status = 'Active';
```

## 16. SUM() — Total

```sql
SELECT SUM(fee) AS total_fees
FROM students;
```

`SUM()` সাধারণত `NULL` values ignore করে। কোনো non-`NULL` value না থাকলে result `NULL` হতে পারে।

## 17. AVG() — Average

```sql
SELECT AVG(marks) AS average_marks
FROM students;
```

```sql
SELECT ROUND(AVG(marks), 2) AS average_marks
FROM students;
```

## 18. MIN() এবং MAX()

```sql
SELECT MIN(marks) AS lowest_marks
FROM students;
```

```sql
SELECT MAX(marks) AS highest_marks
FROM students;
```

একসাথে:

```sql
SELECT
    MIN(age) AS youngest_age,
    MAX(age) AS oldest_age
FROM students;
```

# Part 4 — Date Functions

## 19. CURRENT_DATE()

```sql
SELECT CURRENT_DATE();
```

MySQL session-এর current date return করে।

## 20. NOW()

```sql
SELECT NOW();
```

Current date ও time return করে, session time zone settings অনুযায়ী।

## 21. YEAR() এবং MONTH()

```sql
SELECT YEAR('2004-08-15');
```

Result: `2004`

```sql
SELECT MONTH('2004-08-15');
```

Result: `8`

```sql
SELECT
    name,
    YEAR(birth_date) AS birth_year,
    MONTH(birth_date) AS birth_month
FROM students;
```

## 22. DATEDIFF() — দিনের পার্থক্য

```sql
SELECT DATEDIFF('2026-10-16', '2026-10-01');
```

Result: `15`

`DATEDIFF(date1, date2)` প্রথম date থেকে দ্বিতীয় date বিয়োগ করে দিনের পার্থক্য দেয়। Time অংশ গণনায় নেয় না; এটি বছর হিসেবে বয়স হিসাব করে না।

```sql
SELECT
    name,
    birth_date,
    DATEDIFF(CURRENT_DATE(), birth_date) AS days_since_birth
FROM students;
```

## 23. Date Filter

2020 সালে জন্মানো student-দের খুঁজতে:

```sql
SELECT name, birth_date
FROM students
WHERE YEAR(birth_date) = 2020;
```

অনেক ক্ষেত্রে date range condition index ব্যবহারের জন্য সুবিধাজনক হতে পারে:

```sql
SELECT name, birth_date
FROM students
WHERE birth_date >= '2020-01-01'
  AND birth_date < '2021-01-01';
```

# Part 5 — NULL Functions

## 24. NULL কী?

`NULL` মানে value অনুপস্থিত বা অজানা। এটি `0`, empty string (`''`) বা text `'NULL'`-এর সমান নয়।

```sql
SELECT *
FROM students
WHERE email IS NULL;
```

```sql
SELECT *
FROM students
WHERE email IS NOT NULL;
```

`email = NULL` নয়; `IS NULL` ব্যবহার করবে।

## 25. IFNULL() — NULL-এর বদলে Value

```sql
SELECT IFNULL(NULL, 'Not provided');
```

Result: `Not provided`

```sql
SELECT
    name,
    IFNULL(email, 'Not provided') AS email_display
FROM students;
```

এটি শুধু result-এ fallback দেখায়; stored email update করে না।

## 26. COALESCE() — প্রথম Non-NULL Value

```sql
SELECT COALESCE(NULL, NULL, 'Available', 'Other');
```

Result: `Available`

```sql
SELECT
    name,
    COALESCE(email, city, 'No information') AS contact_info
FROM students;
```

Email `NULL` হলে city দেখাবে; email ও city দুটোই `NULL` হলে `No information` দেখাবে।

# Part 6 — Practical Use

## 27. এক Query-তে Multiple Functions

```sql
SELECT
    name,
    UPPER(name) AS name_uppercase,
    ROUND(marks, 2) AS marks_rounded,
    IFNULL(email, 'No email') AS email_display
FROM students;
```

## 28. WHERE + Function

নামের প্রথম 3 character `Kaw` এমন records খুঁজতে:

```sql
SELECT *
FROM students
WHERE LOWER(SUBSTRING(name, 1, 3)) = 'kaw';
```

Indexed search-এর performance গুরুত্বপূর্ণ হলে function ছাড়া condition লেখা কখনও ভালো হতে পারে।

## 29. ORDER BY + Function

```sql
SELECT
    id,
    name,
    ROUND(marks, 1) AS rounded_marks
FROM students
ORDER BY rounded_marks DESC, id ASC;
```

Rounded marks descending order-এ সাজবে; marks একই হলে `id` ascending থাকবে।

# 📝 Practice — String Functions

1. `'kawsar ahmed'` uppercase করো।
2. `'MYSQL DATABASE'` lowercase করো।
3. `'Kawsar'`-এর byte length বের করো।
4. `'   Hello MySQL   '`-এর leading ও trailing spaces সরাও।
5. `'Database Learning'` থেকে প্রথম 8টি character বের করো।
6. `first_name` ও `last_name` যুক্ত করে full name তৈরি করো।
7. Student-দের name uppercase করে দেখাও।
8. Student-দের email lowercase করে দেখাও।

# 📝 Practice — Numeric Functions

9. `45.6789`-কে 2 decimal place-এ round করো।
10. `8.2`-এর ceiling বের করো।
11. `8.9`-এর floor বের করো।
12. `-125`-এর absolute value বের করো।
13. Student-দের marks 1 decimal place-এ দেখাও।
14. Marks-এর সাথে 5 যোগ করে calculated result দেখাও; Table update করবে না।

# 📝 Practice — Aggregate Functions

15. মোট student count করো।
16. যাদের email `NULL` নয়, তাদের count করো।
17. সব student-এর marks-এর total বের করো।
18. Average marks বের করো।
19. Minimum marks বের করো।
20. Maximum marks বের করো।
21. Active student count করো।

# 📝 Practice — Date & NULL Functions

22. Current date দেখাও।
23. Current date ও time দেখাও।
24. একটি date থেকে year বের করো।
25. একটি date থেকে month বের করো।
26. দুইটি date-এর দিনের পার্থক্য বের করো।
27. যেসব student-এর email `NULL`, তাদের খুঁজে বের করো।
28. `NULL` email-এর জায়গায় `Not provided` দেখাও।
29. Email `NULL` হলে city, আর city-ও `NULL` হলে `No information` দেখাও।

# 🧠 Challenge — Mixed Functions

### Challenge 1
প্রতিটি student-এর name uppercase, email lowercase এবং marks 2 decimal place-এ দেখাও।

### Challenge 2
Total student, average marks, minimum marks ও maximum marks একটি query-তে বের করো।

### Challenge 3
যেসব student-এর email নেই, তাদের name এবং `Not provided` message দেখাও।

### Challenge 4
Birth date-এর year ও month আলাদা columns-এ দেখাও।

### Challenge 5
Marks descending order-এ সাজাও এবং marks একই হলে `id` ascending রাখো।

### Challenge 6
`NULL` email থাকলে `No email` দেখিয়ে student-দের name অনুযায়ী A–Z সাজাও।

# 🧠 Phase 6 Quiz

1. SQL Function কী?
2. `UPPER()` এবং `LOWER()` কী করে?
3. `LENGTH()` ও `CHAR_LENGTH()`-এর পার্থক্য কী?
4. `CONCAT()` কী কাজে লাগে?
5. `ROUND()` কী করে?
6. `CEIL()` ও `FLOOR()`-এর পার্থক্য কী?
7. `COUNT(*)` ও `COUNT(email)`-এর পার্থক্য কী?
8. `SUM()` ও `AVG()` কী return করে?
9. `MIN()` ও `MAX()` কী করে?
10. `CURRENT_DATE()` ও `NOW()`-এর পার্থক্য কী?
11. `DATEDIFF()` কী return করে?
12. `NULL` ও empty string কি একই?
13. `IS NULL` কেন ব্যবহার করা হয়?
14. `IFNULL()` ও `COALESCE()` কী কাজে লাগে?
15. Function দিয়ে result transform করলে stored data কি নিজে থেকে update হয়?

# 📌 Quick Reference

| Function | কাজ |
|---|---|
| `UPPER(text)` | Uppercase |
| `LOWER(text)` | Lowercase |
| `LENGTH(text)` | Byte length |
| `CHAR_LENGTH(text)` | Character count |
| `CONCAT(a, b)` | Values যুক্ত করা |
| `TRIM(text)` | শুরু/শেষের space সরানো |
| `SUBSTRING(text, start, length)` | Text-এর অংশ নেওয়া |
| `ROUND(number, decimals)` | Round করা |
| `CEIL(number)` | Mathematical ceiling |
| `FLOOR(number)` | Mathematical floor |
| `ABS(number)` | Absolute value |
| `COUNT(*)` | Matching row count |
| `SUM(column)` | Total |
| `AVG(column)` | Average |
| `MIN(column)` | Minimum |
| `MAX(column)` | Maximum |
| `CURRENT_DATE()` | Current date |
| `NOW()` | Current date ও time |
| `YEAR(date)` | Year বের করা |
| `MONTH(date)` | Month বের করা |
| `DATEDIFF(a, b)` | Date-এর দিনের পার্থক্য |
| `IFNULL(value, fallback)` | NULL হলে fallback |
| `COALESCE(a, b, ...)` | প্রথম non-NULL value |

# ✅ Phase 6 Completion Checklist

- [ ] Function-এর ধারণা বুঝি
- [ ] String functions ব্যবহার করতে পারি
- [ ] `LENGTH()` ও `CHAR_LENGTH()`-এর পার্থক্য বুঝি
- [ ] Numeric functions ব্যবহার করতে পারি
- [ ] Aggregate functions-এর basic usage বুঝি
- [ ] Date functions ব্যবহার করতে পারি
- [ ] `NULL` ও empty string-এর পার্থক্য বুঝি
- [ ] `IFNULL()` ও `COALESCE()` ব্যবহার করতে পারি
- [ ] Function result-এ alias দিতে পারি
- [ ] `SELECT`, `WHERE` ও `ORDER BY`-এর সঙ্গে function ব্যবহার করতে পারি

# 🎯 Phase 6 Goal

```sql
SELECT
    UPPER(name) AS uppercase_name,
    ROUND(marks, 2) AS rounded_marks,
    IFNULL(email, 'Not provided') AS email_display
FROM students
WHERE status = 'Active'
ORDER BY name ASC
LIMIT 10;
```

- `SELECT` — কোন values দেখাবে
- `UPPER()` — text transform করবে
- `ROUND()` — number round করবে
- `IFNULL()` — NULL-এর fallback দেখাবে
- `WHERE` — records filter করবে
- `ORDER BY` — result সাজাবে
- `LIMIT` — সর্বোচ্চ 10টি row দেখাবে

# 🚀 Next Phase — GROUP BY & HAVING

পরবর্তী Phase-এ শিখবে:
- `GROUP BY`
- Aggregate Functions-এর সঙ্গে grouping
- `HAVING`
- `WHERE` বনাম `HAVING`
- Grouped data filter করা
- Practical reports ও exercises

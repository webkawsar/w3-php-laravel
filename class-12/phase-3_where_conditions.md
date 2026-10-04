# MySQL Phase 3 — WHERE Conditions

> **Level:** Beginner  
> **Prerequisite:** Phase 1 — Database Fundamentals, Phase 2 — INSERT & SELECT  
> **Goal:** নির্দিষ্ট condition অনুযায়ী Database থেকে প্রয়োজনীয় data খুঁজে বের করা।

---

# 📚 Phase 3 Overview

`SELECT` দিয়ে আমরা Table-এর data দেখতে পারি।

কিন্তু যদি আমাদের প্রশ্ন হয়:

- শুধু 20 বছরের বেশি বয়সী student দেখাও
- শুধু Dhaka-এর student দেখাও
- যাদের age 18 থেকে 25-এর মধ্যে তাদের দেখাও
- যাদের email Gmail-এর তাদের দেখাও
- যাদের phone number নেই তাদের দেখাও

তাহলে আমাদের দরকার:

```sql
WHERE
```

এই Phase শেষ করার পর তুমি:

- `WHERE` বুঝতে পারবে
- Comparison Operators ব্যবহার করতে পারবে
- `AND` ব্যবহার করতে পারবে
- `OR` ব্যবহার করতে পারবে
- `NOT` ব্যবহার করতে পারবে
- `BETWEEN` ব্যবহার করতে পারবে
- `IN` এবং `NOT IN` ব্যবহার করতে পারবে
- `LIKE` এবং `NOT LIKE` ব্যবহার করতে পারবে
- `IS NULL` এবং `IS NOT NULL` ব্যবহার করতে পারবে
- একাধিক condition combine করতে পারবে
- Complex filtering query লিখতে পারবে

---

# 1. WHERE কী?

`WHERE` ব্যবহার করে আমরা নির্দিষ্ট condition অনুযায়ী row filter করি।

সহজভাবে:

```text
WHERE = কোন data দেখতে চাই সেটা নির্ধারণ করা
```

### Basic Syntax

```sql
SELECT column1, column2
FROM table_name
WHERE condition;
```

---

# 2. Practice Database

এই Phase-এ আমরা `school` database-এর `students` table ব্যবহার করব।

```sql
USE school;
```

Table:

```text
students
```

Structure:

```text
id
name
age
email
phone
birth_date
city
gender
status
```

যদি `city`, `gender`, `status` column না থাকে, তাহলে practice-এর জন্য নতুন table তৈরি করতে পারো।

```sql
CREATE TABLE students (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(150),
    phone VARCHAR(20),
    birth_date DATE,
    city VARCHAR(100),
    gender VARCHAR(20),
    status VARCHAR(20)
);
```

---

# 3. Practice Data

```sql
INSERT INTO students
(id, name, age, email, phone, birth_date, city, gender, status)
VALUES
(1, 'Rahim', 20, 'rahim@gmail.com', '01711111111', '2006-05-15', 'Dhaka', 'Male', 'Active'),
(2, 'Karim', 22, 'karim@gmail.com', '01722222222', '2004-08-10', 'Chittagong', 'Male', 'Active'),
(3, 'Hasan', 17, 'hasan@gmail.com', '01733333333', '2009-03-20', 'Dhaka', 'Male', 'Inactive'),
(4, 'Nadia', 19, 'nadia@gmail.com', '01744444444', '2007-01-12', 'Khulna', 'Female', 'Active'),
(5, 'Sakib', 23, 'sakib@yahoo.com', '01755555555', '2003-11-08', 'Dhaka', 'Male', 'Active'),
(6, 'Arafat', 24, 'arafat@gmail.com', '01766666666', '2002-06-18', 'Rajshahi', 'Male', 'Inactive'),
(7, 'Sumaiya', 20, 'sumaiya@gmail.com', '01777777777', '2006-02-25', 'Dhaka', 'Female', 'Active'),
(8, 'Jannat', 22, 'jannat@yahoo.com', NULL, '2004-09-14', 'Sylhet', 'Female', 'Active'),
(9, 'Fahim', 21, 'fahim@gmail.com', '01799999999', '2005-12-05', 'Khulna', 'Male', 'Inactive'),
(10, 'Mim', 19, 'mim@gmail.com', NULL, '2007-04-22', 'Dhaka', 'Female', 'Active');
```

এখন আমরা বিভিন্ন condition practice করব।

---

# 4. Basic WHERE

সব student দেখতে:

```sql
SELECT *
FROM students;
```

এখন শুধু Dhaka-এর student দেখতে:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka';
```

এখানে:

```text
city = 'Dhaka'
```

হলো condition।

---

# 5. Equality Operator `=`

`=` ব্যবহার করে কোনো value-এর সাথে exact match করা হয়।

### Example

```sql
SELECT *
FROM students
WHERE age = 20;
```

অর্থ:

> যাদের age ঠিক 20 তাদের দেখাও।

আরেকটি:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka';
```

---

# 6. Not Equal `!=`

কোনো value-এর সমান নয় এমন data বের করতে:

```sql
SELECT *
FROM students
WHERE age != 20;
```

অর্থ:

> যাদের age 20 নয় তাদের দেখাও।

---

# 7. Not Equal `<>`

MySQL-এ `<>`-ও not equal বোঝায়।

```sql
SELECT *
FROM students
WHERE age <> 20;
```

এটি:

```sql
WHERE age != 20
```

এর মতোই কাজ করে।

### Remember

```text
!=
<>
```

দুটিই Not Equal।

---

# 8. Greater Than `>`

কোনো value-এর চেয়ে বড় data খুঁজতে:

```sql
SELECT *
FROM students
WHERE age > 20;
```

অর্থ:

> যাদের age 20-এর বেশি তাদের দেখাও।

---

# 9. Less Than `<`

```sql
SELECT *
FROM students
WHERE age < 20;
```

অর্থ:

> যাদের age 20-এর কম তাদের দেখাও।

---

# 10. Greater Than or Equal `>=`

```sql
SELECT *
FROM students
WHERE age >= 20;
```

অর্থ:

> যাদের age 20 বা তার বেশি।

---

# 11. Less Than or Equal `<=`

```sql
SELECT *
FROM students
WHERE age <= 20;
```

অর্থ:

> যাদের age 20 বা তার কম।

---

# 12. Comparison Operators Summary

| Operator | Meaning |
|---|---|
| `=` | Equal |
| `!=` | Not Equal |
| `<>` | Not Equal |
| `>` | Greater Than |
| `<` | Less Than |
| `>=` | Greater Than or Equal |
| `<=` | Less Than or Equal |

---

# 13. WHERE with String

Text-এর ক্ষেত্রে:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka';
```

আর:

```sql
SELECT *
FROM students
WHERE gender = 'Female';
```

Text value সাধারণত single quote-এর মধ্যে লিখবে।

---

# 14. WHERE with Number

Number-এর ক্ষেত্রে সাধারণত quote দরকার নেই।

```sql
SELECT *
FROM students
WHERE age = 20;
```

---

# 15. WHERE with Date

Date filter করা যায়।

```sql
SELECT *
FROM students
WHERE birth_date = '2006-05-15';
```

আর:

```sql
SELECT *
FROM students
WHERE birth_date > '2005-01-01';
```

---

# 16. AND

একসাথে একাধিক condition সত্য হতে হলে `AND` ব্যবহার করা হয়।

### Example

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
AND age >= 20;
```

এর অর্থ:

```text
city = Dhaka
AND
age >= 20
```

দুটো condition-ই true হতে হবে।

---

# 17. AND Example

Dhaka-এর এবং Active student:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
AND status = 'Active';
```

আরেকটি:

```sql
SELECT *
FROM students
WHERE age >= 20
AND age <= 25;
```

---

# 18. Multiple AND

একাধিক condition একসাথে ব্যবহার করা যায়।

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
AND age >= 18
AND status = 'Active';
```

এখানে 3টি condition-ই true হতে হবে।

---

# 19. OR

কমপক্ষে একটি condition true হলেই result চাইলে `OR` ব্যবহার করা হয়।

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
OR city = 'Khulna';
```

অর্থ:

> Dhaka অথবা Khulna-এর student দেখাও।

---

# 20. Multiple OR

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
OR city = 'Khulna'
OR city = 'Sylhet';
```

এখানে 3টি city-এর যেকোনো একটি হলে result আসবে।

---

# 21. AND বনাম OR

### AND

```sql
WHERE city = 'Dhaka'
AND age >= 20;
```

মানে:

```text
Dhaka হতে হবে
+
age 20 বা বেশি হতে হবে
```

### OR

```sql
WHERE city = 'Dhaka'
OR city = 'Khulna';
```

মানে:

```text
Dhaka অথবা Khulna হলেই হবে
```

---

# 22. Parentheses `()`

Complex condition-এর ক্ষেত্রে parentheses খুব গুরুত্বপূর্ণ।

Example:

```sql
SELECT *
FROM students
WHERE
    (city = 'Dhaka' OR city = 'Khulna')
    AND age >= 20;
```

এর অর্থ:

```text
(Dhaka অথবা Khulna)
AND
age >= 20
```

---

# 23. NOT

কোনো condition-এর বিপরীত result চাইলে `NOT` ব্যবহার করা যায়।

```sql
SELECT *
FROM students
WHERE NOT city = 'Dhaka';
```

অর্থ:

> Dhaka ছাড়া অন্য city-এর student দেখাও।

আরেকভাবে:

```sql
SELECT *
FROM students
WHERE city != 'Dhaka';
```

---

# 24. NOT with IN

```sql
SELECT *
FROM students
WHERE city NOT IN ('Dhaka', 'Khulna');
```

এটি পরে আরও বিস্তারিত দেখব।

---

# 25. BETWEEN

একটি range-এর মধ্যে data খুঁজতে `BETWEEN` ব্যবহার করা হয়।

### Example

```sql
SELECT *
FROM students
WHERE age BETWEEN 18 AND 22;
```

এখানে সাধারণভাবে 18 থেকে 22 পর্যন্ত values অন্তর্ভুক্ত হবে।

অর্থাৎ:

```text
18
19
20
21
22
```

---

# 26. BETWEEN with Date

```sql
SELECT *
FROM students
WHERE birth_date
BETWEEN '2004-01-01' AND '2006-12-31';
```

এটি নির্দিষ্ট date range-এর মধ্যে থাকা records খুঁজবে।

---

# 27. BETWEEN-এর গুরুত্বপূর্ণ বিষয়

এই query:

```sql
WHERE age BETWEEN 18 AND 22;
```

সাধারণভাবে equivalent:

```sql
WHERE age >= 18
AND age <= 22;
```

অর্থাৎ `BETWEEN` range-এর দুই endpoint-ই অন্তর্ভুক্ত করে।

---

# 28. NOT BETWEEN

Range-এর বাইরে data চাইলে:

```sql
SELECT *
FROM students
WHERE age NOT BETWEEN 18 AND 22;
```

---

# 29. IN

একাধিক নির্দিষ্ট value-এর মধ্যে match খুঁজতে `IN` ব্যবহার করা হয়।

এই query:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
OR city = 'Khulna'
OR city = 'Sylhet';
```

এর বদলে:

```sql
SELECT *
FROM students
WHERE city IN ('Dhaka', 'Khulna', 'Sylhet');
```

এটি অনেক cleaner।

---

# 30. IN with Numbers

```sql
SELECT *
FROM students
WHERE age IN (18, 20, 22, 24);
```

অর্থ:

> যাদের age 18, 20, 22 অথবা 24।

---

# 31. NOT IN

নির্দিষ্ট values বাদ দিতে:

```sql
SELECT *
FROM students
WHERE city NOT IN ('Dhaka', 'Khulna');
```

অর্থ:

> Dhaka এবং Khulna ছাড়া অন্য city-এর student দেখাও।

---

# 32. LIKE

Pattern matching-এর জন্য `LIKE` ব্যবহার করা হয়।

বিশেষ করে text search-এর ক্ষেত্রে এটি খুব গুরুত্বপূর্ণ।

### `%`

`%` মানে:

```text
যেকোনো সংখ্যক character
```

### Example

যাদের name `R` দিয়ে শুরু:

```sql
SELECT *
FROM students
WHERE name LIKE 'R%';
```

Matches হতে পারে:

```text
Rahim
Rafi
Rashed
```

---

# 33. LIKE — Starts With

```sql
WHERE name LIKE 'R%';
```

অর্থ:

```text
R দিয়ে শুরু
```

---

# 34. LIKE — Ends With

```sql
SELECT *
FROM students
WHERE name LIKE '%m';
```

অর্থ:

```text
m দিয়ে শেষ
```

---

# 35. LIKE — Contains

```sql
SELECT *
FROM students
WHERE name LIKE '%im%';
```

অর্থ:

```text
name-এর মধ্যে "im" আছে
```

---

# 36. `%` আরও পরিষ্কারভাবে

```text
'R%'     → R দিয়ে শুরু
'%m'     → m দিয়ে শেষ
'%im%'   → যেকোনো জায়গায় im আছে
```

---

# 37. Underscore `_`

`LIKE`-এর আরেকটি wildcard হলো `_`।

একটি `_` একটি character represent করে।

Example:

```sql
SELECT *
FROM students
WHERE name LIKE 'M_m';
```

এখানে pattern:

```text
M + যেকোনো 1 character + m
```

---

# 38. LIKE with Email

Gmail users খুঁজতে:

```sql
SELECT *
FROM students
WHERE email LIKE '%@gmail.com';
```

অর্থ:

> যাদের email `@gmail.com` দিয়ে শেষ হয়।

---

# 39. NOT LIKE

Pattern-এর সাথে match না করা records:

```sql
SELECT *
FROM students
WHERE email NOT LIKE '%@gmail.com';
```

অর্থ:

> Gmail ছাড়া অন্য email provider-এর student দেখাও।

---

# 40. NULL কী?

`NULL` মানে value missing বা unknown।

এটি:

```text
0
```

নয়।

এটি:

```text
''
```

empty string-ও নয়।

### Example

আমাদের data-তে:

```text
Jannat → phone = NULL
Mim    → phone = NULL
```

---

# 41. NULL-এর সাথে `=` ব্যবহার করা যাবে না

ভুল:

```sql
SELECT *
FROM students
WHERE phone = NULL;
```

এভাবে `NULL` check করা উচিত নয়।

সঠিক:

```sql
SELECT *
FROM students
WHERE phone IS NULL;
```

---

# 42. IS NULL

যাদের phone number নেই:

```sql
SELECT *
FROM students
WHERE phone IS NULL;
```

---

# 43. IS NOT NULL

যাদের phone number আছে:

```sql
SELECT *
FROM students
WHERE phone IS NOT NULL;
```

---

# 44. NULL Summary

| Condition | Meaning |
|---|---|
| `IS NULL` | Value নেই |
| `IS NOT NULL` | Value আছে |

মনে রাখবে:

```text
= NULL     ❌
IS NULL    ✅
```

---

# 45. WHERE + SELECT Specific Columns

`WHERE` শুধু `SELECT *`-এর সাথে নয়।

```sql
SELECT name, age, city
FROM students
WHERE age >= 20;
```

অর্থ:

> যাদের age 20 বা বেশি, তাদের name, age এবং city দেখাও।

---

# 46. WHERE + ORDER BY

`WHERE` এবং `ORDER BY` একসাথে ব্যবহার করা যায়।

```sql
SELECT *
FROM students
WHERE age >= 20
ORDER BY age DESC;
```

এখানে:

1. age 20 বা বেশি records filter হবে
2. তারপর age descending order-এ দেখাবে

---

# 47. WHERE + LIMIT

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
LIMIT 3;
```

অর্থ:

> Dhaka-এর সর্বোচ্চ 3টি student দেখাও।

---

# 48. Complex WHERE Example 1

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
AND age >= 20
AND status = 'Active';
```

Condition:

```text
Dhaka
AND
age >= 20
AND
Active
```

---

# 49. Complex WHERE Example 2

```sql
SELECT *
FROM students
WHERE
    (city = 'Dhaka' OR city = 'Khulna')
    AND age >= 20;
```

Condition:

```text
Dhaka অথবা Khulna
+
age >= 20
```

---

# 50. Complex WHERE Example 3

```sql
SELECT *
FROM students
WHERE
    age BETWEEN 18 AND 25
    AND city IN ('Dhaka', 'Khulna');
```

Condition:

```text
age 18–25
+
city Dhaka অথবা Khulna
```

---

# 51. Complex WHERE Example 4

```sql
SELECT *
FROM students
WHERE
    email LIKE '%@gmail.com'
    AND phone IS NOT NULL;
```

Condition:

```text
Gmail email
+
phone number আছে
```

---

# 52. WHERE Query-এর Execution Concept

Beginner হিসেবে এখন শুধু basic idea মনে রাখো:

```sql
SELECT name, age
FROM students
WHERE age >= 20;
```

এখানে:

```text
students table
      ↓
WHERE condition apply
      ↓
age >= 20 records
      ↓
name এবং age দেখানো
```

---

# 53. Common Beginner Mistakes

## Mistake 1 — String quote না দেওয়া

ভুল:

```sql
SELECT *
FROM students
WHERE city = Dhaka;
```

সঠিক:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka';
```

---

## Mistake 2 — NULL-এর সাথে `=`

ভুল:

```sql
WHERE phone = NULL;
```

সঠিক:

```sql
WHERE phone IS NULL;
```

---

## Mistake 3 — AND / OR Logic ভুল করা

ভুল logic:

```sql
WHERE city = 'Dhaka'
OR city = 'Khulna'
AND age >= 20;
```

Complex condition হলে parentheses ব্যবহার করা safer:

```sql
WHERE
    (city = 'Dhaka' OR city = 'Khulna')
    AND age >= 20;
```

---

## Mistake 4 — BETWEEN-এর range ভুল বোঝা

```sql
WHERE age BETWEEN 18 AND 22;
```

এখানে 18 এবং 22 দুটিই সাধারণভাবে included।

---

## Mistake 5 — LIKE-এর `%` ভুল জায়গায় দেওয়া

```sql
'R%'      → R দিয়ে শুরু
'%R'      → R দিয়ে শেষ
'%R%'     → R যেকোনো জায়গায়
```

---

# 54. Practice — Comparison Operators

### Task 1

যাদের age 20 তাদের দেখাও।

### Task 2

যাদের age 20 নয় তাদের দেখাও।

### Task 3

যাদের age 20-এর বেশি তাদের দেখাও।

### Task 4

যাদের age 20-এর কম তাদের দেখাও।

### Task 5

যাদের age 20 বা তার বেশি তাদের দেখাও।

### Task 6

যাদের age 20 বা তার কম তাদের দেখাও।

---

# 55. Practice — AND

### Task 7

Dhaka-এর এবং Active student দেখাও।

### Task 8

যাদের age 20 বা তার বেশি এবং status Active।

### Task 9

Khulna-এর এবং age 20-এর বেশি student দেখাও।

### Task 10

Dhaka-এর Female Active student দেখাও।

---

# 56. Practice — OR

### Task 11

Dhaka অথবা Khulna-এর student দেখাও।

### Task 12

যাদের age 19 অথবা 22 তাদের দেখাও।

### Task 13

Dhaka অথবা Sylhet-এর student যাদের age 20 বা তার বেশি তাদের দেখাও।

---

# 57. Practice — NOT

### Task 14

Dhaka ছাড়া অন্য city-এর student দেখাও।

### Task 15

Active নয় এমন student দেখাও।

### Task 16

Female নয় এমন student দেখাও।

---

# 58. Practice — BETWEEN

### Task 17

18 থেকে 22 বছর বয়সী student দেখাও।

### Task 18

20 থেকে 24 বছর বয়সী student দেখাও।

### Task 19

2004-01-01 থেকে 2006-12-31-এর মধ্যে জন্মগ্রহণ করা student দেখাও।

### Task 20

18 থেকে 22-এর বাইরে age-এর student দেখাও।

---

# 59. Practice — IN / NOT IN

### Task 21

Dhaka, Khulna এবং Sylhet-এর student দেখাও।

### Task 22

Dhaka এবং Khulna ছাড়া অন্য city-এর student দেখাও।

### Task 23

Age 19, 20 এবং 22-এর student দেখাও।

### Task 24

Age 19, 20 এবং 22 ছাড়া অন্যদের দেখাও।

---

# 60. Practice — LIKE

### Task 25

যাদের name `R` দিয়ে শুরু তাদের দেখাও।

### Task 26

যাদের name `a` দিয়ে শেষ তাদের দেখাও।

### Task 27

যাদের name-এর মধ্যে `im` আছে তাদের দেখাও।

### Task 28

যাদের email Gmail-এর তাদের দেখাও।

### Task 29

যাদের email Gmail নয় তাদের দেখাও।

---

# 61. Practice — NULL

### Task 30

যাদের phone number নেই তাদের দেখাও।

### Task 31

যাদের phone number আছে তাদের দেখাও।

---

# 62. Practice — Mixed Conditions

### Task 32

Dhaka-এর Active student যাদের age 20 বা তার বেশি তাদের দেখাও।

### Task 33

Dhaka অথবা Khulna-এর student যাদের age 20 থেকে 24-এর মধ্যে তাদের দেখাও।

### Task 34

Gmail ব্যবহার করে এবং phone number আছে এমন student দেখাও।

### Task 35

Dhaka-এর Female অথবা Khulna-এর Female student দেখাও।

### Task 36

18 থেকে 25 বছর বয়সী এবং Dhaka/Khulna/Sylhet-এর student দেখাও।

---

# 63. Challenge Questions

এখন একটু বেশি চিন্তা করে query লিখবে।

### Challenge 1

যাদের:

```text
age >= 20
AND
city = Dhaka
AND
email Gmail
```

তাদের দেখাও।

---

### Challenge 2

যাদের:

```text
age 18–24
AND
city Dhaka অথবা Khulna
AND
status Active
```

তাদের দেখাও।

---

### Challenge 3

যাদের:

```text
phone নেই
OR
email Gmail নয়
```

তাদের দেখাও।

---

### Challenge 4

যাদের:

```text
name R দিয়ে শুরু
AND
age >= 20
```

তাদের দেখাও।

---

### Challenge 5

যাদের:

```text
city Dhaka / Khulna / Sylhet
AND
age 20–25
AND
phone আছে
```

তাদের দেখাও।

---

# 🧠 Phase 3 Quiz

নিজে answer করার চেষ্টা করো।

### Question 1

`WHERE` কী কাজে ব্যবহার করা হয়?

### Question 2

`=` এবং `!=`-এর মধ্যে পার্থক্য কী?

### Question 3

`!=` এবং `<>` কী বোঝায়?

### Question 4

`>` কী বোঝায়?

### Question 5

`>=` কী বোঝায়?

### Question 6

`AND` কীভাবে কাজ করে?

### Question 7

`OR` কীভাবে কাজ করে?

### Question 8

`AND` এবং `OR`-এর পার্থক্য কী?

### Question 9

Parentheses `()` WHERE condition-এ কেন ব্যবহার করা হয়?

### Question 10

`BETWEEN 18 AND 22` কোন values include করে?

### Question 11

`IN` কেন ব্যবহার করা হয়?

### Question 12

`LIKE 'R%'` কী খুঁজবে?

### Question 13

`LIKE '%m'` কী খুঁজবে?

### Question 14

`LIKE '%im%'` কী খুঁজবে?

### Question 15

`NULL` কী?

### Question 16

`phone = NULL` কেন সঠিক নয়?

### Question 17

`IS NULL` কী করে?

### Question 18

`IS NOT NULL` কী করে?

---

# 🔍 Query Reading Practice

নিচের query-টি line by line বোঝার চেষ্টা করো:

```sql
SELECT name, age, city
FROM students
WHERE age >= 20
AND city IN ('Dhaka', 'Khulna');
```

নিজেকে প্রশ্ন করো:

```text
কোন Table?
কোন columns?
কোন age condition?
কোন city?
AND-এর কাজ কী?
```

---

আরেকটি:

```sql
SELECT *
FROM students
WHERE
    (city = 'Dhaka' OR city = 'Khulna')
    AND age BETWEEN 20 AND 24;
```

নিজেকে প্রশ্ন করো:

```text
কোন 2টি city?
Age range কত?
Parentheses কেন ব্যবহার করা হয়েছে?
```

---

# 📌 WHERE Cheat Sheet

## Equal

```sql
WHERE age = 20;
```

## Not Equal

```sql
WHERE age != 20;
```

```sql
WHERE age <> 20;
```

## Greater

```sql
WHERE age > 20;
```

## Less

```sql
WHERE age < 20;
```

## Greater or Equal

```sql
WHERE age >= 20;
```

## Less or Equal

```sql
WHERE age <= 20;
```

## AND

```sql
WHERE age >= 20
AND city = 'Dhaka';
```

## OR

```sql
WHERE city = 'Dhaka'
OR city = 'Khulna';
```

## NOT

```sql
WHERE NOT city = 'Dhaka';
```

## BETWEEN

```sql
WHERE age BETWEEN 18 AND 25;
```

## IN

```sql
WHERE city IN ('Dhaka', 'Khulna');
```

## NOT IN

```sql
WHERE city NOT IN ('Dhaka', 'Khulna');
```

## LIKE — Starts With

```sql
WHERE name LIKE 'R%';
```

## LIKE — Ends With

```sql
WHERE name LIKE '%m';
```

## LIKE — Contains

```sql
WHERE name LIKE '%im%';
```

## NOT LIKE

```sql
WHERE email NOT LIKE '%@gmail.com';
```

## NULL

```sql
WHERE phone IS NULL;
```

## NOT NULL

```sql
WHERE phone IS NOT NULL;
```

---

# ⚠️ Important Rules to Remember

### Rule 1

String-এর জন্য quote ব্যবহার করো:

```sql
'Dhaka'
'Rahim'
'Active'
```

### Rule 2

Number-এর জন্য সাধারণত quote দরকার নেই:

```sql
20
25
100
```

### Rule 3

NULL check করতে:

```sql
IS NULL
IS NOT NULL
```

### Rule 4

Multiple `OR` condition-এর সাথে `IN` ব্যবহার করলে query cleaner হয়।

```sql
WHERE city IN ('Dhaka', 'Khulna', 'Sylhet');
```

### Rule 5

Complex `AND` + `OR` condition হলে parentheses ব্যবহার করো।

```sql
WHERE
    (city = 'Dhaka' OR city = 'Khulna')
    AND age >= 20;
```

---

# ✅ Phase 3 Completion Checklist

Phase 4-এ যাওয়ার আগে নিশ্চিত হও যে তুমি এগুলো পারো:

- [ ] `WHERE` বুঝি
- [ ] `=` ব্যবহার করতে পারি
- [ ] `!=` ব্যবহার করতে পারি
- [ ] `<>` ব্যবহার করতে পারি
- [ ] `>` ব্যবহার করতে পারি
- [ ] `<` ব্যবহার করতে পারি
- [ ] `>=` ব্যবহার করতে পারি
- [ ] `<=` ব্যবহার করতে পারি
- [ ] `AND` ব্যবহার করতে পারি
- [ ] `OR` ব্যবহার করতে পারি
- [ ] `NOT` ব্যবহার করতে পারি
- [ ] Parentheses ব্যবহার করতে পারি
- [ ] `BETWEEN` ব্যবহার করতে পারি
- [ ] `NOT BETWEEN` ব্যবহার করতে পারি
- [ ] `IN` ব্যবহার করতে পারি
- [ ] `NOT IN` ব্যবহার করতে পারি
- [ ] `LIKE` ব্যবহার করতে পারি
- [ ] `%` wildcard বুঝি
- [ ] `_` wildcard বুঝি
- [ ] `NOT LIKE` ব্যবহার করতে পারি
- [ ] `IS NULL` ব্যবহার করতে পারি
- [ ] `IS NOT NULL` ব্যবহার করতে পারি
- [ ] Multiple conditions combine করতে পারি
- [ ] Complex WHERE query লিখতে পারি

---

# 🎯 Phase 3 Goal

Phase 3 শেষে তোমার এই pattern পরিষ্কার থাকা উচিত:

```text
SELECT
    ↓
কোন columns চাই?
    ↓
FROM
    ↓
কোন Table থেকে?
    ↓
WHERE
    ↓
কোন conditions-এর records চাই?
```

উদাহরণ:

```sql
SELECT name, age, city
FROM students
WHERE
    age >= 20
    AND city IN ('Dhaka', 'Khulna')
    AND status = 'Active';
```

এই query-এর অর্থ:

> `students` table থেকে `name`, `age` এবং `city` দেখাও, যেখানে student-এর age 20 বা তার বেশি, city Dhaka অথবা Khulna এবং status Active।

---

# 🚀 Next Phase

## Phase 4 — ORDER BY, LIMIT & OFFSET

পরবর্তী Phase-এ আমরা শিখব কীভাবে filtered data:

```text
ORDER BY
ASC
DESC
LIMIT
OFFSET
```

ব্যবহার করে sort এবং control করতে হয়।

এরপর আমরা pagination-এর basic concept-ও practice করব।

# MySQL Learning Roadmap — Phase 7: Aggregate Functions

**ভাষা:** বাংলা  
**লক্ষ্য:** `COUNT()`, `SUM()`, `AVG()`, `MIN()`, এবং `MAX()` ব্যবহার করে টেবিলের একাধিক row থেকে summary বা সারসংক্ষেপ বের করা শেখা।

---

## 1. এই Phase-এ কী শিখবে?

এই Phase শেষে তুমি পারবে:

- Aggregate Function কী এবং কেন ব্যবহার করা হয় তা বুঝতে।
- `COUNT()` দিয়ে row বা নির্দিষ্ট column-এর value গণনা করতে।
- `SUM()` দিয়ে সংখ্যার যোগফল বের করতে।
- `AVG()` দিয়ে গড় বের করতে।
- `MIN()` ও `MAX()` দিয়ে সবচেয়ে ছোট ও বড় value বের করতে।
- `NULL` value aggregate function-এ কীভাবে আচরণ করে তা বুঝতে।
- `WHERE` দিয়ে কোন row-গুলো হিসাবের মধ্যে আসবে তা নিয়ন্ত্রণ করতে।
- বাস্তব database-এ summary query লিখতে।

> **Roadmap অনুযায়ী মনে রাখবে:** এই Phase শুধু Aggregate Functions নিয়ে। `GROUP BY` ও `HAVING` পরের Phase 8-এ বিস্তারিত শিখবে।

---

## 2. Aggregate Function কী?

Aggregate Function হলো এমন SQL function, যা একাধিক row-এর value নিয়ে একটি summary result দেয়।

ধরো, `students` table-এ অনেক শিক্ষার্থীর তথ্য আছে। তুমি জানতে চাও:

- মোট কতজন শিক্ষার্থী আছে?
- সব শিক্ষার্থীর বয়সের যোগফল কত?
- শিক্ষার্থীদের গড় বয়স কত?
- সবচেয়ে কম বয়স কত?
- সবচেয়ে বেশি বয়স কত?

প্রতিটি row আলাদাভাবে দেখানোর বদলে Aggregate Function দিয়ে সংক্ষিপ্ত ফলাফল পাওয়া যায়।

### Aggregate Functions-এর তালিকা

| Function | কাজ |
|---|---|
| `COUNT()` | Row বা non-NULL value গণনা করে |
| `SUM()` | সংখ্যার যোগফল বের করে |
| `AVG()` | সংখ্যার গড় বের করে |
| `MIN()` | সবচেয়ে ছোট value বের করে |
| `MAX()` | সবচেয়ে বড় value বের করে |

---

## 3. Practice Database ও Table তৈরি

নিচের SQL code MySQL-এ চালিয়ে practice data তৈরি করো। আগে থেকে একই নামে table থাকলে এটি সেটিকে মুছে নতুন করে তৈরি করবে।

```sql
CREATE DATABASE IF NOT EXISTS mysql_practice;
USE mysql_practice;

DROP TABLE IF EXISTS students;

CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    age INT,
    city VARCHAR(50),
    marks DECIMAL(5,2),
    fee DECIMAL(10,2)
);

INSERT INTO students (student_name, age, city, marks, fee)
VALUES
('Ayesha', 20, 'Dhaka', 85.50, 5000),
('Rahim', 22, 'Khulna', 72.00, 4500),
('Karim', 21, 'Dhaka', 90.00, 5000),
('Nadia', 19, 'Chattogram', 88.50, 4000),
('Sakib', 23, 'Khulna', 65.00, 3500),
('Mim', NULL, 'Dhaka', 91.00, 4500),
('Tanvir', 20, 'Rajshahi', NULL, 3000),
('Rupa', 22, 'Chattogram', 78.00, NULL);
```

Data ঠিকমতো insert হয়েছে কি না দেখতে চালাও:

```sql
SELECT * FROM students;
```

এই table-এ কিছু `NULL` value ইচ্ছাকৃতভাবে রাখা হয়েছে, যাতে `NULL` নিয়ে Aggregate Function-এর আচরণ পরীক্ষা করা যায়।

---

## 4. `COUNT()` — গণনা করা

`COUNT()` দিয়ে row বা column-এর non-`NULL` value গণনা করা হয়।

### 4.1 `COUNT(*)`

```sql
SELECT COUNT(*) AS total_students
FROM students;
```

**ফলাফল:** `8`

ব্যাখ্যা:

- `COUNT(*)` table-এর matching row-গুলো গণনা করে।
- কোনো column-এর value `NULL` হলেও row-টি গণনার মধ্যে আসে।
- `AS total_students` result column-এর একটি সহজে বোঝা যায় এমন নাম দেয়। একে alias বলে।

### 4.2 `COUNT(column_name)`

```sql
SELECT COUNT(age) AS students_with_age
FROM students;
```

**ফলাফল:** `7`

কারণ 8টি row-এর মধ্যে 1টি row-তে `age` হলো `NULL`। `COUNT(age)` শুধু non-`NULL` age value গণনা করে।

Marks-এর ক্ষেত্রেও একই নিয়ম:

```sql
SELECT COUNT(marks) AS students_with_marks
FROM students;
```

**ফলাফল:** `7`

### 4.3 `COUNT(*)` বনাম `COUNT(column)`

| Query | কী গণনা করে | এই data-তে ফলাফল |
|---|---|---:|
| `COUNT(*)` | সব row | 8 |
| `COUNT(age)` | যেসব row-তে age `NULL` নয় | 7 |
| `COUNT(marks)` | যেসব row-তে marks `NULL` নয় | 7 |
| `COUNT(fee)` | যেসব row-তে fee `NULL` নয় | 7 |

**মনে রাখবে:** `COUNT(column)`-এর মধ্যে `NULL` value গণনা হয় না। কিন্তু `COUNT(*)` row গণনা করে, তাই ওই row-তে `NULL` থাকলেও সেটি গণনা হয়।

---

## 5. `SUM()` — যোগফল বের করা

`SUM()` একটি numeric column-এর non-`NULL` value-গুলোর যোগফল বের করে।

```sql
SELECT SUM(fee) AS total_fee
FROM students;
```

**ফলাফল:** `29500`

ব্যাখ্যা:

- প্রতিটি শিক্ষার্থীর `fee` যোগ করা হয়েছে।
- Rupa-র `fee` হলো `NULL`; এটি যোগফলে ধরা হয় না।
- `SUM()` সাধারণত সংখ্যাসূচক column-এ ব্যবহার করা হয়।

আরও উদাহরণ:

```sql
SELECT SUM(marks) AS total_marks
FROM students;
```

এই data-তে ফলাফল `570`।

### `WHERE` দিয়ে নির্দিষ্ট row-এর যোগফল

```sql
SELECT SUM(fee) AS dhaka_total_fee
FROM students
WHERE city = 'Dhaka';
```

Dhaka-র Ayesha, Karim ও Mim-এর fee যোগ হবে: `5000 + 5000 + 4500 = 14500`।

`WHERE` আগে কোন row-গুলো হিসাবের মধ্যে আসবে তা বেছে নেয়; তারপর Aggregate Function সেই row-গুলোর value নিয়ে হিসাব করে।

---

## 6. `AVG()` — গড় বের করা

`AVG()` একটি numeric column-এর non-`NULL` value-গুলোর গড় বের করে।

```sql
SELECT AVG(age) AS average_age
FROM students;
```

এই data-তে বয়সের non-`NULL` value হলো:

`20, 22, 21, 19, 23, 20, 22`

যোগফল `147`, value আছে 7টি, তাই গড় `147 / 7 = 21`।

**ফলাফল:** `21`

### Marks-এর গড়

```sql
SELECT AVG(marks) AS average_marks
FROM students;
```

Marks-এর non-`NULL` value 7টি। এই data-তে গড় `81.428571...`-এর কাছাকাছি হবে। MySQL decimal result দেখাতে পারে।

দুই ঘর পর্যন্ত দেখাতে:

```sql
SELECT ROUND(AVG(marks), 2) AS average_marks
FROM students;
```

**ফলাফল:** `81.43`

`ROUND(number, 2)` হলো value-কে decimal-এর পর 2 ঘর পর্যন্ত round করার জন্য ব্যবহৃত function।

### গুরুত্বপূর্ণ বিষয়

`AVG()` `NULL`-কে শূন্য ধরে না; `NULL` value-টি গড়ের হিসাব থেকে বাদ পড়ে।

উদাহরণ হিসেবে, `marks`-এর `NULL`-কে 0 ধরে গড় করা হচ্ছে না। শুধু যেসব row-তে marks আছে, সেগুলো দিয়ে গড় হচ্ছে।

---

## 7. `MIN()` — সবচেয়ে ছোট value

`MIN()` কোনো column-এর সবচেয়ে ছোট non-`NULL` value বের করে।

```sql
SELECT MIN(age) AS youngest_age
FROM students;
```

**ফলাফল:** `19`

Marks-এর সর্বনিম্ন value:

```sql
SELECT MIN(marks) AS lowest_marks
FROM students;
```

**ফলাফল:** `65.00`

Fee-এর সর্বনিম্ন value:

```sql
SELECT MIN(fee) AS lowest_fee
FROM students;
```

**ফলাফল:** `3000`

`NULL` value-কে এখানে সর্বনিম্ন value হিসেবে ধরা হয় না।

---

## 8. `MAX()` — সবচেয়ে বড় value

`MAX()` কোনো column-এর সবচেয়ে বড় non-`NULL` value বের করে।

```sql
SELECT MAX(age) AS oldest_age
FROM students;
```

**ফলাফল:** `23`

সর্বোচ্চ marks:

```sql
SELECT MAX(marks) AS highest_marks
FROM students;
```

**ফলাফল:** `91.00`

সর্বোচ্চ fee:

```sql
SELECT MAX(fee) AS highest_fee
FROM students;
```

**ফলাফল:** `5000`

একই সর্বোচ্চ fee একাধিক শিক্ষার্থীর থাকতে পারে। `MAX(fee)` শুধু সর্বোচ্চ fee-এর value দেয়; কোন শিক্ষার্থী বা শিক্ষার্থীদের সেই fee আছে, তা সরাসরি দেখায় না।

---

## 9. এক Query-তে একাধিক Aggregate Function

একটি query-তে একাধিক Aggregate Function ব্যবহার করা যায়।

```sql
SELECT
    COUNT(*) AS total_students,
    COUNT(age) AS students_with_age,
    SUM(fee) AS total_fee,
    AVG(marks) AS average_marks,
    MIN(age) AS youngest_age,
    MAX(age) AS oldest_age
FROM students;
```

এই query-তে table-এর সব row নিয়ে একটি summary row পাওয়া যাবে।

Expected result-এর ধারণা:

| total_students | students_with_age | total_fee | average_marks | youngest_age | oldest_age |
|---:|---:|---:|---:|---:|---:|
| 8 | 7 | 29500 | 81.428571… | 19 | 23 |

`AVG(marks)`-এর exact displayed decimal format MySQL-এর result display-এর ওপর নির্ভর করতে পারে। `ROUND(AVG(marks), 2)` ব্যবহার করলে 2 decimal place পাওয়া যাবে।

---

## 10. `WHERE`-এর সঙ্গে Aggregate Function

Aggregate Function-এর আগে `WHERE` দিয়ে row filter করা যায়।

### উদাহরণ 1: শুধু Dhaka-র শিক্ষার্থীদের সংখ্যা

```sql
SELECT COUNT(*) AS dhaka_students
FROM students
WHERE city = 'Dhaka';
```

**ফলাফল:** `3`

### উদাহরণ 2: যাদের বয়স 21 বা তার বেশি, তাদের গড় বয়স

```sql
SELECT AVG(age) AS average_age
FROM students
WHERE age >= 21;
```

এখানে কেবল `age >= 21` এমন row-গুলো হিসাবের মধ্যে আসবে।

### উদাহরণ 3: marks 80 বা তার বেশি—এমন শিক্ষার্থীর সংখ্যা

```sql
SELECT COUNT(*) AS students_with_80_plus
FROM students
WHERE marks >= 80;
```

**ফলাফল:** `4`

**মনে রাখবে:** `WHERE` row filter করে; Aggregate Function filtered row-গুলোর ওপর হিসাব করে।

---

## 11. Aggregate Function ও সাধারণ Function-এর পার্থক্য

সাধারণ বা scalar function সাধারণত প্রতিটি row-এর input নিয়ে প্রতিটি row-এর জন্য result দেয়। Aggregate Function একাধিক row-এর value নিয়ে summary result দেয়।

উদাহরণ:

```sql
SELECT
    student_name,
    ROUND(marks) AS rounded_marks
FROM students;
```

এখানে প্রতিটি শিক্ষার্থীর row-এর জন্য rounded marks দেখানো হয়।

অন্যদিকে:

```sql
SELECT AVG(marks) AS average_marks
FROM students;
```

এখানে সব matching row-এর marks থেকে একটি গড় result পাওয়া যায়।

---

## 12. `NULL` নিয়ে জরুরি নিয়ম

Aggregate Function শেখার সময় এই নিয়মগুলো মনে রাখবে:

- `COUNT(*)` সব matching row গণনা করে, এমনকি row-তে `NULL` থাকলেও।
- `COUNT(column)` শুধু non-`NULL` value গণনা করে।
- `SUM(column)` `NULL` value বাদ দিয়ে বাকি সংখ্যাগুলো যোগ করে।
- `AVG(column)` `NULL` বাদ দিয়ে বাকি numeric value-এর গড় বের করে।
- `MIN(column)` ও `MAX(column)` `NULL` বাদ দিয়ে value-এর সর্বনিম্ন/সর্বোচ্চ বের করে।
- কোনো row-তেই যদি column-এর non-`NULL` value না থাকে, তাহলে `COUNT(column)` হবে `0`; `SUM()`, `AVG()`, `MIN()`, ও `MAX()` সাধারণত `NULL` return করবে।

`NULL` মানে 0 নয়; এটি অনুপস্থিত বা অজানা value বোঝায়।

---

## 13. সাধারণ ভুল ও সংশোধন

### ভুল 1: `COUNT(age)`-কে মোট শিক্ষার্থীর সংখ্যা মনে করা

```sql
SELECT COUNT(age)
FROM students;
```

এটি age দেওয়া আছে এমন row গণনা করে, সব row নয়।

মোট row গণনা করতে:

```sql
SELECT COUNT(*)
FROM students;
```

### ভুল 2: `AVG()`-এ `NULL`-কে 0 ধরে নেওয়া

```sql
SELECT AVG(marks)
FROM students;
```

এটি `NULL` marks-কে 0 ধরে না; বাদ দেয়।

যদি কোনো বিশেষ business rule অনুযায়ী `NULL`-কে 0 হিসেবে গণনা করতে হয়, তাহলে সেটি আলাদা করে লিখতে হবে, যেমন:

```sql
SELECT AVG(COALESCE(marks, 0)) AS average_including_missing_as_zero
FROM students;
```

সতর্কতা: এটি কেবল তখনই ব্যবহার করবে, যখন সত্যিই `NULL`-কে 0 হিসেবে ধরার নিয়ম আছে। সব ক্ষেত্রে এটি সঠিক সিদ্ধান্ত নয়।

### ভুল 3: `SUM()` দিয়ে text column যোগ করার চেষ্টা

```sql
SELECT SUM(student_name)
FROM students;
```

এটি অর্থপূর্ণ query নয়। `SUM()` numeric data-এর জন্য ব্যবহার করো।

### ভুল 4: `MAX(fee)`-কে সর্বোচ্চ fee দেওয়া শিক্ষার্থীর নাম মনে করা

```sql
SELECT MAX(fee)
FROM students;
```

এটি শুধু সর্বোচ্চ fee-এর value দেয়। শিক্ষার্থীর নামও দেখতে হলে আলাদা query বা পরের Phase-এ শেখা SQL techniques দরকার হবে।

---

## 14. Practice Tasks — নিজে করো

প্রথমে উত্তর না দেখে নিজে query লেখার চেষ্টা করো।

1. মোট শিক্ষার্থীর সংখ্যা বের করো।
2. যেসব শিক্ষার্থীর `age` আছে, তাদের সংখ্যা বের করো।
3. যেসব শিক্ষার্থীর `marks` আছে, তাদের সংখ্যা বের করো।
4. সব শিক্ষার্থীর fee-এর যোগফল বের করো।
5. শিক্ষার্থীদের গড় marks 2 decimal place পর্যন্ত দেখাও।
6. সবচেয়ে কম বয়স বের করো।
7. সবচেয়ে বেশি marks বের করো।
8. Dhaka শহরের শিক্ষার্থীর সংখ্যা বের করো।
9. Khulna শহরের শিক্ষার্থীদের fee-এর যোগফল বের করো।
10. `age >= 21` এমন শিক্ষার্থীদের সর্বোচ্চ marks বের করো।
11. এক query-তে মোট row, মোট fee, সর্বনিম্ন fee ও সর্বোচ্চ fee দেখাও।
12. `COUNT(*)` ও `COUNT(fee)`-এর result তুলনা করো এবং পার্থক্যের কারণ ব্যাখ্যা করো।

---

## 15. Practice Tasks — Answer Key

নিজে চেষ্টা করার পর মিলিয়ে দেখো।

### 1. মোট শিক্ষার্থীর সংখ্যা

```sql
SELECT COUNT(*) AS total_students
FROM students;
```

### 2. Age দেওয়া আছে এমন শিক্ষার্থী

```sql
SELECT COUNT(age) AS students_with_age
FROM students;
```

### 3. Marks দেওয়া আছে এমন শিক্ষার্থী

```sql
SELECT COUNT(marks) AS students_with_marks
FROM students;
```

### 4. Fee-এর যোগফল

```sql
SELECT SUM(fee) AS total_fee
FROM students;
```

### 5. গড় marks, 2 decimal place

```sql
SELECT ROUND(AVG(marks), 2) AS average_marks
FROM students;
```

### 6. সবচেয়ে কম বয়স

```sql
SELECT MIN(age) AS youngest_age
FROM students;
```

### 7. সবচেয়ে বেশি marks

```sql
SELECT MAX(marks) AS highest_marks
FROM students;
```

### 8. Dhaka-র শিক্ষার্থীর সংখ্যা

```sql
SELECT COUNT(*) AS dhaka_students
FROM students
WHERE city = 'Dhaka';
```

### 9. Khulna-র fee-এর যোগফল

```sql
SELECT SUM(fee) AS khulna_total_fee
FROM students
WHERE city = 'Khulna';
```

Expected result: `8000`

### 10. বয়স 21 বা তার বেশি—এমন শিক্ষার্থীদের সর্বোচ্চ marks

```sql
SELECT MAX(marks) AS highest_marks
FROM students
WHERE age >= 21;
```

Expected result: `90.00`

### 11. এক query-তে summary

```sql
SELECT
    COUNT(*) AS total_students,
    SUM(fee) AS total_fee,
    MIN(fee) AS lowest_fee,
    MAX(fee) AS highest_fee
FROM students;
```

### 12. `COUNT(*)` বনাম `COUNT(fee)`

```sql
SELECT
    COUNT(*) AS all_rows,
    COUNT(fee) AS rows_with_fee
FROM students;
```

Expected result: `all_rows = 8`, `rows_with_fee = 7`। কারণ 1টি row-তে fee হলো `NULL`।

---

## 16. ছোট Quiz

**প্রশ্ন 1:** কোন function সব matching row গণনা করে, এমনকি কোনো column-এ `NULL` থাকলেও?

A. `COUNT(column)`  
B. `COUNT(*)`  
C. `SUM(*)`

**প্রশ্ন 2:** `AVG(marks)` কি `NULL`-কে 0 ধরে?

A. হ্যাঁ  
B. না

**প্রশ্ন 3:** সবচেয়ে বড় fee বের করতে কোন function লাগবে?

A. `MIN(fee)`  
B. `MAX(fee)`  
C. `SUM(fee)`

**প্রশ্ন 4:** Dhaka-র শিক্ষার্থীদের গড় marks বের করতে কোন clause দিয়ে আগে row filter করবে?

A. `WHERE`  
B. `ORDER BY`  
C. `LIMIT`

**প্রশ্ন 5:** `SUM(fee)` কী return করে?

A. Fee-এর যোগফল  
B. Fee-এর গড়  
C. Fee-সহ row-এর সংখ্যা

### Quiz Answer Key

1. B — `COUNT(*)`
2. B — `NULL` বাদ পড়ে
3. B — `MAX(fee)`
4. A — `WHERE`
5. A — Fee-এর যোগফল

---

## 17. Phase 7 Completion Checklist

নিচের প্রতিটি বিষয় নিজে ব্যাখ্যা করতে পারলে checkbox-এ টিক দাও।

- [ ] Aggregate Function কী তা বুঝি।
- [ ] `COUNT(*)` ও `COUNT(column)`-এর পার্থক্য বুঝি।
- [ ] `SUM()` দিয়ে যোগফল বের করতে পারি।
- [ ] `AVG()` দিয়ে গড় বের করতে পারি।
- [ ] `MIN()` ও `MAX()` ব্যবহার করতে পারি।
- [ ] Aggregate Function-এর সঙ্গে `WHERE` ব্যবহার করতে পারি।
- [ ] Aggregate Function-এ `NULL` কীভাবে আচরণ করে তা বুঝি।
- [ ] এক query-তে একাধিক Aggregate Function ব্যবহার করতে পারি।
- [ ] Answer Key না দেখে অন্তত 8টি practice task সমাধান করতে পারি।

---

## 18. Phase 7-এর সংক্ষিপ্ত সারাংশ

| Function | উদাহরণ | কাজ |
|---|---|---|
| `COUNT(*)` | `COUNT(*)` | সব matching row গণনা |
| `COUNT(column)` | `COUNT(age)` | non-`NULL` value গণনা |
| `SUM()` | `SUM(fee)` | যোগফল |
| `AVG()` | `AVG(marks)` | গড় |
| `MIN()` | `MIN(age)` | সর্বনিম্ন value |
| `MAX()` | `MAX(marks)` | সর্বোচ্চ value |

### পরবর্তী Phase

**Phase 8 — `GROUP BY` & `HAVING`**

সেখানে শিখবে কীভাবে `city`, `age` বা অন্য column অনুযায়ী data-কে group করে প্রতিটি group-এর জন্য `COUNT()`, `SUM()`, `AVG()` ইত্যাদি বের করতে হয় এবং `HAVING` দিয়ে group filter করতে হয়।

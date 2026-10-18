# MySQL Learning Roadmap — Phase 9: DISTINCT

**ভাষা:** বাংলা  
**লেভেল:** একদম Beginner  
**এই Phase-এর মূল বিষয়:** `DISTINCT` দিয়ে duplicate value বাদ দিয়ে unique value বা unique combination বের করা।

---

## 1. Phase 9-এ কী শিখবে?

এই Phase শেষ করলে তুমি পারবে:

- Duplicate data কী, তা বুঝতে।
- `SELECT DISTINCT` দিয়ে duplicate value বাদ দিতে।
- একাধিক column-এর সঙ্গে `DISTINCT` ব্যবহার করতে।
- `DISTINCT` ও `GROUP BY`-এর প্রাথমিক পার্থক্য বুঝতে।
- `NULL` value-এর ক্ষেত্রে `DISTINCT` কীভাবে কাজ করে তা বুঝতে।
- `WHERE`, `ORDER BY`, এবং `LIMIT`-এর সঙ্গে `DISTINCT` ব্যবহার করতে।
- বাস্তব database-এ unique city, unique age, unique fee ইত্যাদি বের করতে।
- Common mistakes শনাক্ত করে সঠিক query লিখতে।

**Roadmap অনুযায়ী:** Phase 9 হলো `DISTINCT`। Phase 10-এ Primary Key, Foreign Key ও Relationships শিখবে। এই ফাইলে পরের Phase-এর বিষয়গুলো বিস্তারিত শেখানো হবে না।

---

## 2. `DISTINCT` কেন প্রয়োজন?

ধরো, একটি `students` table-এ 8 জন শিক্ষার্থী আছে। কয়েকজন একই শহরে থাকে:

| student_name | city |
|---|---|
| Ayesha | Dhaka |
| Rahim | Khulna |
| Karim | Dhaka |
| Nadia | Chattogram |
| Sakib | Khulna |
| Mim | Dhaka |
| Tanvir | Rajshahi |
| Rupa | Chattogram |

যদি তুমি চালাও:

```sql
SELECT city
FROM students;
```

তাহলে city column-এর সব row দেখাবে। তাই `Dhaka`, `Khulna`, এবং `Chattogram` একাধিকবার দেখা যাবে।

কিন্তু তুমি যদি জানতে চাও, **কোন কোন আলাদা শহরে শিক্ষার্থী আছে**, তাহলে duplicate city বারবার দেখানোর প্রয়োজন নেই। এখানেই `DISTINCT` কাজে লাগে।

```sql
SELECT DISTINCT city
FROM students;
```

সম্ভাব্য result:

| city |
|---|
| Dhaka |
| Khulna |
| Chattogram |
| Rajshahi |

MySQL result-এর row order নিশ্চিত নয়, যদি `ORDER BY` ব্যবহার না করো।

### সহজভাবে মনে রাখো

- `SELECT column` — matching row-গুলোর value দেখায়; duplicate value থাকতে পারে।
- `SELECT DISTINCT column` — result-এ duplicate value বাদ দিয়ে unique value দেখায়।

`DISTINCT` database-এর original table থেকে duplicate row delete করে না। এটি শুধু query-এর result-এ duplicate value বাদ দেয়।

---

## 3. Practice Database তৈরি করো

নিচের SQL code MySQL Workbench, phpMyAdmin বা অন্য MySQL client-এ চালাতে পারো।

> **সতর্কতা:** এই script `students` নামে table থাকলে সেটি drop করে আবার তৈরি করবে। আগে থেকে গুরুত্বপূর্ণ data থাকলে এই script সেই database-এ চালাবে না। Practice-এর জন্য আলাদা database ব্যবহার করাই ভালো।

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

প্রথমে সব data দেখো:

```sql
SELECT *
FROM students;
```

এখন এই table-এ একই city, age ও fee একাধিকবার আছে। এগুলো দিয়ে `DISTINCT` practice করা যাবে।

---

## 4. Syntax: `SELECT DISTINCT`

সাধারণ syntax:

```sql
SELECT DISTINCT column_name
FROM table_name;
```

এখানে:

- `SELECT` — কোন data দেখতে চাও তা নির্ধারণ করে।
- `DISTINCT` — result-এ duplicate value বা duplicate combination বাদ দেয়।
- `column_name` — যে column-এর unique value দেখতে চাও।
- `FROM` — কোন table থেকে data নিতে হবে তা বলে।

### উদাহরণ

```sql
SELECT DISTINCT city
FROM students;
```

এই query `students` table থেকে unique city value দেখাবে।

---

## 5. একটি Column-এর সঙ্গে `DISTINCT`

### 5.1 Unique city বের করা

```sql
SELECT DISTINCT city
FROM students;
```

Unique city হলো:

- Dhaka
- Khulna
- Chattogram
- Rajshahi

একই city-তে একাধিক শিক্ষার্থী থাকলেও city একবারই result-এ আসবে।

### 5.2 Unique age বের করা

```sql
SELECT DISTINCT age
FROM students;
```

এই data-তে unique age value:

- 19
- 20
- 21
- 22
- 23
- `NULL`

`NULL` এখানে আলাদা একটি distinct value হিসেবে result-এ একবার দেখাতে পারে। `NULL` মানে 0 নয়; এটি missing বা unknown value বোঝায়।

Result-এর order নির্দিষ্ট করতে:

```sql
SELECT DISTINCT age
FROM students
ORDER BY age;
```

MySQL-এ ascending sort-এ সাধারণত `NULL` আগে দেখা যায়। Order গুরুত্বপূর্ণ হলে `ORDER BY` ব্যবহার করো।

### 5.3 Unique fee বের করা

```sql
SELECT DISTINCT fee
FROM students;
```

একই fee একাধিক শিক্ষার্থীর থাকলে fee value একবারই দেখানো হবে। Fee column-এ `NULL` থাকলে সেটিও result-এ একবার আসবে।

### 5.4 Unique marks বের করা

```sql
SELECT DISTINCT marks
FROM students;
```

একই marks একাধিক row-তে থাকলে result-এ একবার দেখাবে। `NULL` থাকলে সেটিও একবার দেখাবে।

---

## 6. `DISTINCT` দিয়ে একাধিক Column নির্বাচন

এটি খুব গুরুত্বপূর্ণ বিষয়। একাধিক column দিলে `DISTINCT` **প্রতিটি column-কে আলাদাভাবে unique করে না**। বরং নির্বাচিত column-গুলোর **সম্পূর্ণ combination** unique কি না তা দেখে।

### উদাহরণ

```sql
SELECT DISTINCT city, age
FROM students;
```

এর মানে:

> প্রতিটি `city + age` combination একবার করে দেখাও।

ধরো, data এমন:

| city | age |
|---|---:|
| Dhaka | 20 |
| Dhaka | 20 |
| Dhaka | 21 |
| Khulna | 20 |
| Khulna | 20 |

Query:

```sql
SELECT DISTINCT city, age
FROM students;
```

Result:

| city | age |
|---|---:|
| Dhaka | 20 |
| Dhaka | 21 |
| Khulna | 20 |

কারণ:

- `Dhaka, 20` দুইবার ছিল, তাই একবার এসেছে।
- `Dhaka, 21` আলাদা combination, তাই এসেছে।
- `Khulna, 20` আলাদা combination, তাই এসেছে।

### খুব গুরুত্বপূর্ণ পার্থক্য

```sql
SELECT DISTINCT city, age
FROM students;
```

এটি unique city list নয়, unique age list-ও নয়। এটি unique **city-age pair** দেখায়।

যদি শুধু unique city দরকার হয়:

```sql
SELECT DISTINCT city
FROM students;
```

যদি শুধু unique age দরকার হয়:

```sql
SELECT DISTINCT age
FROM students;
```

### আরও একটি উদাহরণ: city ও fee

```sql
SELECT DISTINCT city, fee
FROM students;
```

এখানে `city + fee` combination unique হবে। একই শহরে একই fee একাধিকবার থাকলে combination একবার দেখাবে; একই শহরে অন্য fee থাকলে সেটি আলাদা row হবে।

---

## 7. `DISTINCT` এবং `NULL`

SQL-এ `NULL` মানে value নেই, অজানা, বা নির্ধারিত নয়। এটি 0 বা empty string-এর সমান নয়।

এই query চালাও:

```sql
SELECT DISTINCT age
FROM students;
```

যেহেতু `age`-এ একটি `NULL` আছে, result-এ `NULL` একবার দেখাবে।

যদি জানতে চাও কয়টি আলাদা non-NULL age আছে, তাহলে:

```sql
SELECT COUNT(DISTINCT age) AS unique_age_count
FROM students;
```

এই query-তে `NULL` গণনা হয় না। Practice data-তে non-NULL age হলো `19, 20, 21, 22, 23`, তাই result হবে `5`।

### `COUNT(DISTINCT column)` কী করে?

```sql
SELECT COUNT(DISTINCT city) AS unique_city_count
FROM students;
```

এই data-তে result হবে `4`।

এখানে 2টি ধাপের মতো করে ভাবতে পারো:

1. `city` column-এর duplicate value বাদ দেওয়া হয়।
2. unique non-NULL city value-গুলোর সংখ্যা গণনা করা হয়।

যদি column-এ `NULL` থাকে, `COUNT(DISTINCT column)` সেটিকে count করে না।

### তুলনা

| Query | কাজ |
|---|---|
| `SELECT DISTINCT age FROM students;` | Unique age value দেখায়; `NULL`-ও result-এ থাকতে পারে |
| `COUNT(DISTINCT age)` | Unique non-NULL age value-এর সংখ্যা দেয় |
| `COUNT(age)` | Non-NULL age value-এর মোট সংখ্যা দেয় |
| `COUNT(*)` | সব row গণনা করে |

এই পার্থক্যটি ভালোভাবে বুঝে রাখো।

---

## 8. `WHERE`-এর সঙ্গে `DISTINCT`

`WHERE` দিয়ে আগে কোন row-গুলো বিবেচনা করা হবে তা নির্ধারণ করা যায়। এরপর `DISTINCT` সেই matching row-গুলো থেকে duplicate value বা combination বাদ দেয়।

### উদাহরণ 1: Dhaka-র শিক্ষার্থীদের unique age

```sql
SELECT DISTINCT age
FROM students
WHERE city = 'Dhaka';
```

শুধু Dhaka-র row-গুলোর age দেখা হবে। তারপর duplicate age বাদ যাবে।

Practice data-তে Dhaka-র age হলো `20`, `21`, এবং `NULL`।

### উদাহরণ 2: 4000 বা তার বেশি fee-এর unique value

```sql
SELECT DISTINCT fee
FROM students
WHERE fee >= 4000;
```

`WHERE fee >= 4000` matching row-গুলো নির্বাচন করে। তারপর সেই row-গুলোর fee value duplicate হলে একবার দেখানো হয়।

`fee` হলো `NULL` এমন row `fee >= 4000` condition-এ match করবে না।

### উদাহরণ 3: Khulna ও Dhaka শহরের unique city

```sql
SELECT DISTINCT city
FROM students
WHERE city IN ('Khulna', 'Dhaka');
```

Result-এ `Dhaka` ও `Khulna` একবার করে আসবে।

---

## 9. `ORDER BY`-এর সঙ্গে `DISTINCT`

Unique value-গুলো সাজিয়ে দেখতে `ORDER BY` ব্যবহার করো।

### City A–Z অনুযায়ী

```sql
SELECT DISTINCT city
FROM students
ORDER BY city ASC;
```

- `ASC` মানে ascending order।
- Text-এর ক্ষেত্রে সাধারণত A–Z ক্রমে সাজায়।

### City Z–A অনুযায়ী

```sql
SELECT DISTINCT city
FROM students
ORDER BY city DESC;
```

- `DESC` মানে descending order।
- Text-এর ক্ষেত্রে সাধারণত Z–A ক্রমে সাজায়।

### Unique age ছোট থেকে বড়

```sql
SELECT DISTINCT age
FROM students
ORDER BY age ASC;
```

**মনে রাখবে:** `DISTINCT` duplicate বাদ দেয়; `ORDER BY` result সাজায়। এরা ভিন্ন কাজ করে।

---

## 10. `LIMIT`-এর সঙ্গে `DISTINCT`

Unique value-এর result থেকে নির্দিষ্ট সংখ্যক row দেখতে `LIMIT` ব্যবহার করতে পারো।

```sql
SELECT DISTINCT city
FROM students
ORDER BY city ASC
LIMIT 2;
```

এটি unique city-গুলোকে আগে A–Z অনুযায়ী সাজায়, তারপর প্রথম 2টি row দেখায়।

**কেন `ORDER BY` যোগ করা হয়েছে?** `ORDER BY` ছাড়া কোন 2টি unique city আগে দেখাবে, সেটি নির্ভরযোগ্যভাবে নির্দিষ্ট করা যায় না।

আরেকটি উদাহরণ:

```sql
SELECT DISTINCT age
FROM students
ORDER BY age ASC
LIMIT 3;
```

এটি ascending order-এ unique age-এর প্রথম 3টি result দেখাবে। `NULL` থাকলে MySQL-এর ascending sort-এ সেটি সাধারণত শুরুতে আসে।

---

## 11. `DISTINCT` বনাম `GROUP BY`

এই দুটির result কিছু ক্ষেত্রে একই রকম হতে পারে, তবে উদ্দেশ্য এক নয়।

### `DISTINCT`

Duplicate value বা duplicate combination বাদ দিয়ে unique result দেখাতে ব্যবহার হয়।

```sql
SELECT DISTINCT city
FROM students;
```

উদ্দেশ্য: কোন কোন city আছে তা জানা।

### `GROUP BY`

একই value-যুক্ত row-গুলোকে group করে প্রতিটি group-এর ওপর summary calculation করার কাজে ব্যবহৃত হয়।

```sql
SELECT city, COUNT(*) AS total_students
FROM students
GROUP BY city;
```

উদ্দেশ্য: প্রতিটি city-তে কতজন শিক্ষার্থী আছে তা জানা।

### পার্থক্য

| বিষয় | `DISTINCT` | `GROUP BY` |
|---|---|---|
| প্রধান উদ্দেশ্য | Duplicate result বাদ দেওয়া | একই value-র row group করা |
| Unique city list | খুব উপযোগী | করা সম্ভব, তবে প্রয়োজনের চেয়ে বেশি |
| প্রতি city-তে শিক্ষার্থী গণনা | একা সরাসরি সেই summary দেয় না | `COUNT(*)`-এর সঙ্গে করা যায় |
| Aggregate calculation | `COUNT(DISTINCT column)`-এর মতো expression-এ কাজে লাগে | প্রতিটি group-এর জন্য aggregate calculation-এ ব্যবহৃত হয় |

**Beginner tip:** শুধু unique value চাইলে `DISTINCT` দিয়ে শুরু করো। Group অনুযায়ী count, sum বা average চাইলে `GROUP BY` শিখতে হবে।

---

## 12. `DISTINCT` কি Original Table-এর Data Delete করে?

না। এটি খুব সাধারণ ভুল ধারণা।

```sql
SELECT DISTINCT city
FROM students;
```

এই query শুধু result-এ duplicate city বাদ দেয়। `students` table-এ থাকা কোনো row delete বা update করে না।

মূল data যাচাই করতে:

```sql
SELECT *
FROM students;
```

এখনও সব 8টি row থাকবে।

`DISTINCT` হলো data দেখানোর পদ্ধতি; এটি data-cleaning বা duplicate row delete করার command নয়।

---

## 13. `DISTINCT` ব্যবহারে Common Mistakes

### Mistake 1: `DISTINCT`-কে `SELECT`-এর পরে ভুল জায়গায় লেখা

ভুল:

```sql
SELECT city DISTINCT
FROM students;
```

সঠিক:

```sql
SELECT DISTINCT city
FROM students;
```

### Mistake 2: একাধিক column দিলে প্রত্যেকটি আলাদাভাবে unique হবে ভাবা

```sql
SELECT DISTINCT city, age
FROM students;
```

এটি unique `city + age` combination দেখায়, unique city এবং unique age আলাদা তালিকা হিসেবে দেখায় না।

### Mistake 3: `DISTINCT` original table পরিষ্কার করে মনে করা

`SELECT DISTINCT` table-এর data পরিবর্তন করে না।

### Mistake 4: `COUNT(DISTINCT column)`-এ `NULL` গণনা হবে ভাবা

```sql
SELECT COUNT(DISTINCT age)
FROM students;
```

`NULL` গণনা হয় না। এটি শুধু unique non-NULL age value গোনে।

### Mistake 5: `DISTINCT` মানেই result sorted ভাবা

`DISTINCT` নিজে result order নিশ্চিত করে না। সাজানো result চাইলে `ORDER BY` ব্যবহার করো।

### Mistake 6: `SELECT DISTINCT *`-কে নির্দিষ্ট column-এর duplicate বাদ দেওয়া ভাবা

```sql
SELECT DISTINCT *
FROM students;
```

এটি সব selected column মিলিয়ে সম্পূর্ণ row duplicate হলে duplicate row বাদ দেয়। শুধু city duplicate হলেও অন্য column ভিন্ন থাকলে সেই row-গুলো আলাদা থাকবে।

---

## 14. `SELECT DISTINCT *` কী করে?

এই query:

```sql
SELECT DISTINCT *
FROM students;
```

সব column বিবেচনা করে সম্পূর্ণ row-গুলো তুলনা করে। সব selected column-এর value একই এমন duplicate row থাকলে result-এ সেটি একবার দেখাবে।

কিন্তু নিচের row-গুলো আলাদা:

| student_name | city |
|---|---|
| Ayesha | Dhaka |
| Karim | Dhaka |

শহর একই, কিন্তু নাম আলাদা। তাই পুরো row আলাদা।

**সাধারণ কাজের জন্য:** কোন column-এর unique value দরকার, সেটি স্পষ্টভাবে লেখো।

```sql
SELECT DISTINCT city
FROM students;
```

এটি `SELECT DISTINCT *`-এর চেয়ে আলাদা উদ্দেশ্য পূরণ করে।

---

## 15. বাস্তব জীবনে `DISTINCT` কোথায় কাজে লাগে?

### Example 1: Website-এর unique country list

ধরো, orders table-এ customer country অনেকবার আছে:

```sql
SELECT DISTINCT country
FROM orders
ORDER BY country;
```

ব্যবহার: কোন কোন country থেকে order এসেছে, তা দেখা।

### Example 2: Unique product category

```sql
SELECT DISTINCT category
FROM products
ORDER BY category;
```

ব্যবহার: product table-এ কোন কোন category আছে তা জানা।

### Example 3: Unique payment method

```sql
SELECT DISTINCT payment_method
FROM payments;
```

ব্যবহার: card, bank transfer, mobile payment ইত্যাদির unique list দেখা।

### Example 4: Unique customer ID-এর সংখ্যা

```sql
SELECT COUNT(DISTINCT customer_id) AS unique_customers
FROM orders;
```

ব্যবহার: orders table-এ মোট কতজন আলাদা customer-এর order আছে তা জানা। `customer_id`-তে `NULL` থাকলে তা গণনায় আসবে না।

### Example 5: Unique artist name

```sql
SELECT DISTINCT artist_name
FROM tracks
ORDER BY artist_name;
```

ব্যবহার: tracks table-এ থাকা artist-দের unique নামের তালিকা পাওয়া।

---

## 16. Practice Tasks — আগে নিজে চেষ্টা করো

Practice database ও `students` table তৈরি করা আছে ধরে নিচের query-গুলো নিজে লেখো।

1. `students` table-এর unique city-গুলো বের করো।
2. unique age-গুলো বের করো।
3. unique fee-গুলো ছোট থেকে বড় সাজিয়ে দেখাও।
4. unique marks-গুলো বড় থেকে ছোট সাজিয়ে দেখাও।
5. শুধু Dhaka-র শিক্ষার্থীদের unique age বের করো।
6. `age >= 20` এমন শিক্ষার্থীদের unique city বের করো।
7. Khulna ও Chattogram শহরের unique city list বের করো।
8. মোট কতটি unique city আছে, তা গণনা করো।
9. মোট কতটি unique non-NULL age আছে, তা গণনা করো।
10. unique `city + age` combination দেখাও।
11. unique city-গুলো সাজিয়ে প্রথম 2টি দেখাও।
12. `SELECT DISTINCT *` চালিয়ে বোঝার চেষ্টা করো কেন এটি `SELECT DISTINCT city`-এর মতো result দেয় না।
13. `SELECT city FROM students;` এবং `SELECT DISTINCT city FROM students;`-এর result তুলনা করো।
14. এমন একটি query লেখো যা শুধু `fee >= 4000` row-গুলোর unique fee দেখায়।
15. নিজের ভাষায় ব্যাখ্যা করো: `DISTINCT` কি table থেকে duplicate row delete করে?

---

## 17. Practice Tasks — Answer Key

নিজে চেষ্টা করার পর উত্তর মিলিয়ে দেখো।

### 1. Unique city

```sql
SELECT DISTINCT city
FROM students;
```

### 2. Unique age

```sql
SELECT DISTINCT age
FROM students;
```

### 3. Unique fee ছোট থেকে বড়

```sql
SELECT DISTINCT fee
FROM students
ORDER BY fee ASC;
```

### 4. Unique marks বড় থেকে ছোট

```sql
SELECT DISTINCT marks
FROM students
ORDER BY marks DESC;
```

### 5. Dhaka-র শিক্ষার্থীদের unique age

```sql
SELECT DISTINCT age
FROM students
WHERE city = 'Dhaka';
```

### 6. Age 20 বা তার বেশি—এমন শিক্ষার্থীদের unique city

```sql
SELECT DISTINCT city
FROM students
WHERE age >= 20;
```

### 7. Khulna ও Chattogram-এর unique city

```sql
SELECT DISTINCT city
FROM students
WHERE city IN ('Khulna', 'Chattogram');
```

### 8. Unique city-এর সংখ্যা

```sql
SELECT COUNT(DISTINCT city) AS unique_city_count
FROM students;
```

Expected result: `4`

### 9. Unique non-NULL age-এর সংখ্যা

```sql
SELECT COUNT(DISTINCT age) AS unique_age_count
FROM students;
```

Expected result: `5`

### 10. Unique city-age combination

```sql
SELECT DISTINCT city, age
FROM students;
```

### 11. সাজানো unique city-এর প্রথম 2টি

```sql
SELECT DISTINCT city
FROM students
ORDER BY city ASC
LIMIT 2;
```

### 12. সব column দিয়ে distinct row

```sql
SELECT DISTINCT *
FROM students;
```

এটি সম্পূর্ণ row-এর duplicate খোঁজে। শুধু city একই হলেই row duplicate হয় না।

### 13. সব city বনাম unique city

```sql
SELECT city
FROM students;
```

এটি প্রতিটি row-এর city দেখায়, তাই duplicate থাকতে পারে।

```sql
SELECT DISTINCT city
FROM students;
```

এটি unique city দেখায়।

### 14. Fee 4000 বা তার বেশি—এমন row-এর unique fee

```sql
SELECT DISTINCT fee
FROM students
WHERE fee >= 4000;
```

### 15. `DISTINCT` কি data delete করে?

না। `DISTINCT` শুধু query result-এ duplicate value বা combination বাদ দেয়। Original table অপরিবর্তিত থাকে।

---

## 18. ছোট Quiz

### প্রশ্ন 1

Unique city list পেতে কোন query সঠিক?

A.

```sql
SELECT city
FROM students;
```

B.

```sql
SELECT DISTINCT city
FROM students;
```

C.

```sql
DELETE DISTINCT city
FROM students;
```

### প্রশ্ন 2

`SELECT DISTINCT city, age FROM students;` কী দেখায়?

A. শুধু unique city  
B. শুধু unique age  
C. Unique `city + age` combination

### প্রশ্ন 3

`COUNT(DISTINCT age)` কি `NULL` age গণনা করে?

A. হ্যাঁ  
B. না

### প্রশ্ন 4

`DISTINCT` result sort করে কি?

A. সব সময়  
B. না, দরকার হলে `ORDER BY` ব্যবহার করতে হয়

### প্রশ্ন 5

`SELECT DISTINCT city FROM students;` কি original table থেকে duplicate city delete করে?

A. হ্যাঁ  
B. না

### Quiz Answer Key

1. B
2. C
3. B
4. B
5. B

---

## 19. Phase 9 Completion Checklist

প্রতিটি বিষয় নিজে বুঝিয়ে বলতে পারলে টিক দাও:

- [ ] `DISTINCT` কেন ব্যবহার করা হয়, তা বুঝি।
- [ ] একটি column-এর unique value বের করতে পারি।
- [ ] একাধিক column-এর unique combination বুঝি।
- [ ] `DISTINCT` ও `COUNT(DISTINCT column)`-এর পার্থক্য বুঝি।
- [ ] `NULL`-এর ক্ষেত্রে `DISTINCT` ও `COUNT(DISTINCT ...)`-এর আচরণ বুঝি।
- [ ] `WHERE`-এর সঙ্গে `DISTINCT` ব্যবহার করতে পারি।
- [ ] `ORDER BY` ও `LIMIT`-এর সঙ্গে `DISTINCT` ব্যবহার করতে পারি।
- [ ] `DISTINCT` ও `GROUP BY`-এর প্রাথমিক পার্থক্য বুঝি।
- [ ] `SELECT DISTINCT *` কী করে তা বুঝি।
- [ ] Answer Key না দেখে অন্তত 10টি practice task সমাধান করতে পারি।

---

## 20. Phase 9-এর Quick Reference

| প্রয়োজন | Query pattern |
|---|---|
| Unique city | `SELECT DISTINCT city FROM students;` |
| Unique age | `SELECT DISTINCT age FROM students;` |
| Unique city-age pair | `SELECT DISTINCT city, age FROM students;` |
| Unique city-এর সংখ্যা | `SELECT COUNT(DISTINCT city) FROM students;` |
| Filter করা row থেকে unique city | `SELECT DISTINCT city FROM students WHERE city = 'Dhaka';` |
| Unique city সাজানো | `SELECT DISTINCT city FROM students ORDER BY city;` |
| প্রথম 2টি unique city | `SELECT DISTINCT city FROM students ORDER BY city LIMIT 2;` |
| সম্পূর্ণ duplicate row বাদ দেওয়া | `SELECT DISTINCT * FROM students;` |

---

## 21. Phase 9-এর সারাংশ

- `DISTINCT` result থেকে duplicate value বা duplicate combination বাদ দেয়।
- একটি column select করলে সেই column-এর unique value পাওয়া যায়।
- একাধিক column select করলে তাদের unique combination পাওয়া যায়।
- `COUNT(DISTINCT column)` unique non-`NULL` value-এর সংখ্যা দেয়।
- `DISTINCT` original table-এর data delete বা update করে না।
- Result নির্দিষ্ট ক্রমে চাইলে `ORDER BY` ব্যবহার করো।
- `WHERE` দিয়ে row filter করা যায়, তারপর `DISTINCT` duplicate বাদ দেয়।

### পরবর্তী Phase

**Phase 10 — Primary Key, Foreign Key & Relationships**

পরবর্তী Phase-এ শিখবে table-এর প্রতিটি record-কে কীভাবে uniqueভাবে চেনা যায়, এক table-এর সঙ্গে অন্য table-এর সম্পর্ক কীভাবে তৈরি হয়, এবং Primary Key ও Foreign Key কেন প্রয়োজন।

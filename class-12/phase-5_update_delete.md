# MySQL Phase 5 — UPDATE & DELETE

> **Level:** Beginner  
> **Prerequisite:** Phase 1–4  
> **Goal:** Existing data update করা, অপ্রয়োজনীয় records delete করা এবং নিরাপদে data পরিবর্তন করতে শেখা।

---

## 📚 Phase 5 Overview

এই Phase-এ শিখবে:

- `UPDATE`
- `SET`
- `WHERE` দিয়ে নির্দিষ্ট row update করা
- একাধিক column update করা
- একাধিক row update করা
- `DELETE`
- নির্দিষ্ট row delete করা
- একাধিক row delete করা
- Update/Delete করার আগে `SELECT` দিয়ে যাচাই করা
- Common mistakes ও safe practices

> ⚠️ **সতর্কতা:** `UPDATE` বা `DELETE`-এ ভুল condition দিলে অনেক row পরিবর্তিত বা মুছে যেতে পারে। Practice করার সময় সবসময় আগে `SELECT` দিয়ে target rows যাচাই করো।

---

## 1. UPDATE কী?

`UPDATE` ব্যবহার করে Table-এর existing data পরিবর্তন করা হয়।

সহজভাবে:

```text
UPDATE = আগের data পরিবর্তন করা
```

### Basic Syntax

```sql
UPDATE table_name
SET column_name = new_value
WHERE condition;
```

- `UPDATE` — কোন Table পরিবর্তন করবে
- `SET` — কোন column-এর value পরিবর্তন করবে
- `WHERE` — কোন row বা rows পরিবর্তন করবে

---

## 2. Practice Table

আগের Phase-গুলোর `school.students` table ব্যবহার করো।

```sql
USE school;

SELECT *
FROM students;
```

ধরে নেওয়া হচ্ছে Table-এ `id`, `name`, `age`, `email`, `city`, `status` columns আছে।

---

## 3. একটি নির্দিষ্ট Row Update করা

ধরো, `id = 3` student-এর age 17 থেকে 18 করতে চাও।

```sql
UPDATE students
SET age = 18
WHERE id = 3;
```

এরপর verify করো:

```sql
SELECT *
FROM students
WHERE id = 3;
```

শুধু `id = 3` row-টিই target হবে, যদি `id` unique Primary Key হয়।

---

## 4. UPDATE-এর আগে SELECT দিয়ে যাচাই

Safe workflow:

### Step 1 — Target row খুঁজে দেখো

```sql
SELECT *
FROM students
WHERE id = 3;
```

### Step 2 — UPDATE করো

```sql
UPDATE students
SET age = 18
WHERE id = 3;
```

### Step 3 — আবার যাচাই করো

```sql
SELECT *
FROM students
WHERE id = 3;
```

এভাবে ভুল row পরিবর্তন করার ঝুঁকি কমে।

---

## 5. একাধিক Column Update করা

একই row-এর একাধিক column পরিবর্তন করা যায়।

```sql
UPDATE students
SET age = 21,
    city = 'Dhaka'
WHERE id = 4;
```

এখানে `id = 4` student-এর age এবং city—দুটিই পরিবর্তিত হবে।

Verify:

```sql
SELECT *
FROM students
WHERE id = 4;
```

---

## 6. Text, Number ও Date Update করা

### Text

```sql
UPDATE students
SET city = 'Khulna'
WHERE id = 2;
```

### Number

```sql
UPDATE students
SET age = 23
WHERE id = 2;
```

### Date

```sql
UPDATE students
SET birth_date = '2004-08-15'
WHERE id = 2;
```

Text ও date value সাধারণত single quote-এর মধ্যে লিখবে।

---

## 7. একাধিক Row Update করা

`WHERE` condition একাধিক row-এর সাথে match করলে সব matching row update হবে।

উদাহরণ: Dhaka-এর সব student-এর status `Active` করতে:

```sql
UPDATE students
SET status = 'Active'
WHERE city = 'Dhaka';
```

এখানে Dhaka-এর সব matching row update হবে—শুধু একটি row নয়।

Update করার আগে কোন rows match করবে তা দেখো:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka';
```

---

## 8. Arithmetic Expression দিয়ে Update

কোনো column-এর বর্তমান value-এর ভিত্তিতে update করা যায়।

উদাহরণ: সব student-এর age 1 বাড়ানো:

```sql
UPDATE students
SET age = age + 1;
```

> ⚠️ এই query-তে `WHERE` নেই, তাই Table-এর **সব row** update হবে। এটি শুধু তখনই চালাবে, যখন সত্যিই সব row পরিবর্তন করতে চাও।

নির্দিষ্ট student-এর age 1 বাড়াতে:

```sql
UPDATE students
SET age = age + 1
WHERE id = 5;
```

---

## 9. AND দিয়ে Update Condition

Dhaka-এর Active student-দের status `Inactive` করতে:

```sql
UPDATE students
SET status = 'Inactive'
WHERE city = 'Dhaka'
  AND status = 'Active';
```

এখানে দুইটি condition-ই true হতে হবে।

Update করার আগে target rows যাচাই করো:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
  AND status = 'Active';
```

---

## 10. OR দিয়ে Update Condition

ধরো, Dhaka অথবা Khulna-এর student-দের একটি নির্দিষ্ট status দিতে চাও:

```sql
UPDATE students
SET status = 'Active'
WHERE city = 'Dhaka'
   OR city = 'Khulna';
```

`OR` ব্যবহার করলে যেকোনো একটি condition match করলেই row update হবে। তাই চালানোর আগে `SELECT` দিয়ে matching rows দেখে নাও।

---

## 11. UPDATE + BETWEEN

18 থেকে 20 বছর বয়সী student-দের status `Active` করতে:

```sql
UPDATE students
SET status = 'Active'
WHERE age BETWEEN 18 AND 20;
```

`BETWEEN` দুই endpoint-ই অন্তর্ভুক্ত করে।

---

## 12. UPDATE + IN

নির্দিষ্ট কয়েকটি city-এর student update করতে:

```sql
UPDATE students
SET status = 'Active'
WHERE city IN ('Dhaka', 'Khulna', 'Sylhet');
```

একাধিক `OR` condition-এর বদলে `IN` ব্যবহার করলে query সংক্ষিপ্ত হয়।

---

## 13. DELETE কী?

`DELETE` ব্যবহার করে Table থেকে row মুছে ফেলা হয়।

সহজভাবে:

```text
DELETE = Table থেকে record মুছে ফেলা
```

### Basic Syntax

```sql
DELETE FROM table_name
WHERE condition;
```

---

## 14. একটি নির্দিষ্ট Row Delete করা

ধরো, `id = 10` student record মুছে ফেলতে চাও।

### Step 1 — আগে যাচাই

```sql
SELECT *
FROM students
WHERE id = 10;
```

### Step 2 — Delete

```sql
DELETE FROM students
WHERE id = 10;
```

### Step 3 — Verify

```sql
SELECT *
FROM students
WHERE id = 10;
```

Delete সফল হলে ওই `id`-এর record আর থাকবে না।

---

## 15. একাধিক Row Delete করা

একটি condition একাধিক row-এর সাথে match করলে সব matching row delete হবে।

উদাহরণ: Inactive student-দের delete করতে:

```sql
DELETE FROM students
WHERE status = 'Inactive';
```

> ⚠️ এটি `Inactive` status-এর **সব matching student** মুছে দেবে। Delete করার আগে অবশ্যই check করো:

```sql
SELECT *
FROM students
WHERE status = 'Inactive';
```

যদি শুধু status পরিবর্তন করতে চাও, delete না করে `UPDATE` ব্যবহার করো।

---

## 16. DELETE + AND

Dhaka-এর Inactive student-দের delete করতে:

```sql
DELETE FROM students
WHERE city = 'Dhaka'
  AND status = 'Inactive';
```

আগে target rows দেখো:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
  AND status = 'Inactive';
```

---

## 17. DELETE + IN

নির্দিষ্ট কয়েকটি city-এর records delete করতে:

```sql
DELETE FROM students
WHERE city IN ('Sylhet', 'Rajshahi');
```

এই query ঐ city-গুলোর সব matching row delete করবে। চালানোর আগে `SELECT` দিয়ে যাচাই করা জরুরি।

---

## 18. DELETE + LIMIT

MySQL-এ কিছু ক্ষেত্রে `DELETE`-এর সাথে `LIMIT` ব্যবহার করে delete হওয়া row-এর সংখ্যা সীমিত করা যায়।

```sql
DELETE FROM students
WHERE status = 'Inactive'
LIMIT 1;
```

এটি matching Inactive rows-এর মধ্যে সর্বোচ্চ 1টি row delete করবে। কোন নির্দিষ্ট row delete হবে তা নিশ্চিত করতে হলে আগে unique key দিয়ে target নির্ধারণ করো।

---

## 19. WHERE ছাড়া UPDATE — বিপজ্জনক

```sql
UPDATE students
SET city = 'Dhaka';
```

এখানে `WHERE` নেই। ফলে Table-এর **সব row**-এর city `Dhaka` হয়ে যাবে।

নির্দিষ্ট row update করতে:

```sql
UPDATE students
SET city = 'Dhaka'
WHERE id = 5;
```

---

## 20. WHERE ছাড়া DELETE — বিপজ্জনক

```sql
DELETE FROM students;
```

এখানে `WHERE` নেই। ফলে Table-এর **সব row** মুছে যাবে।

এটি Table structure delete করে না; শুধু records মুছে দেয়। Table structure-ও মুছে ফেলতে `DROP TABLE` লাগে।

---

## 21. DELETE বনাম DROP TABLE

| Command | কী করে |
|---|---|
| `DELETE FROM students WHERE id = 3;` | Condition অনুযায়ী row delete করে |
| `DELETE FROM students;` | Table-এর সব row delete করে, Table থাকে |
| `DROP TABLE students;` | Table এবং তার data মুছে দেয় |

`DELETE` এবং `DROP TABLE` এক জিনিস নয়।

---

## 22. UPDATE বনাম DELETE

| Command | উদ্দেশ্য | Example |
|---|---|---|
| `UPDATE` | Existing data পরিবর্তন | Age 20 থেকে 21 |
| `DELETE` | Record মুছে ফেলা | `id = 5` record delete |

### UPDATE

```sql
UPDATE students
SET age = 21
WHERE id = 5;
```

### DELETE

```sql
DELETE FROM students
WHERE id = 5;
```

প্রথমটি record রাখে, শুধু value পরিবর্তন করে। দ্বিতীয়টি matching record মুছে দেয়।

---

## 23. Transaction দিয়ে অতিরিক্ত Safety

InnoDB-এর মতো transaction-supported storage engine ব্যবহার করলে কিছু data modification transaction-এর মধ্যে করা যায়।

```sql
START TRANSACTION;

UPDATE students
SET age = 21
WHERE id = 5;

SELECT *
FROM students
WHERE id = 5;

COMMIT;
```

পরিবর্তন স্থায়ী করতে `COMMIT` ব্যবহার করা হয়।

পরিবর্তন commit করার আগে বাতিল করতে:

```sql
ROLLBACK;
```

> গুরুত্বপূর্ণ: `COMMIT` করার পর সাধারণ `ROLLBACK` দিয়ে সেই পরিবর্তন ফিরিয়ে আনা যায় না। Production data-তে কাজ করার আগে backup ও transaction behavior বুঝে নাও।

---

## 24. Safe Data Modification Checklist

কোনো গুরুত্বপূর্ণ `UPDATE` বা `DELETE` করার আগে:

1. Table ও Database সঠিক কি না যাচাই করো।
2. একই condition দিয়ে `SELECT` চালাও।
3. কতটি row match করছে তা যাচাই করো।
4. `WHERE` condition সঠিক কি না নিশ্চিত হও।
5. Production data হলে backup এবং transaction strategy বিবেচনা করো।
6. পরিবর্তনের পরে আবার `SELECT` দিয়ে verify করো।

### Rows-এর সংখ্যা যাচাই

```sql
SELECT COUNT(*)
FROM students
WHERE status = 'Inactive';
```

এতে condition-এর সাথে কতটি row match করছে তা দেখা যাবে।

---

## 25. Common Beginner Mistakes

### Mistake 1 — UPDATE-তে WHERE ভুলে যাওয়া

```sql
UPDATE students
SET age = 25;
```

এটি সব row-এর age পরিবর্তন করবে।

### Mistake 2 — DELETE-তে WHERE ভুলে যাওয়া

```sql
DELETE FROM students;
```

এটি সব row মুছে দেবে।

### Mistake 3 — ভুল ID ব্যবহার করা

```sql
UPDATE students
SET city = 'Dhaka'
WHERE id = 50;
```

`id = 50` না থাকলে কোনো row update হবে না। আগে ID যাচাই করো।

### Mistake 4 — একাধিক row match করবে বুঝতে না পারা

```sql
DELETE FROM students
WHERE city = 'Dhaka';
```

এটি Dhaka-এর সব matching row delete করবে, শুধু একটি নয়।

### Mistake 5 — UPDATE আর DELETE গুলিয়ে ফেলা

তথ্য ঠিক করতে চাইলে `UPDATE`; record সরাতে চাইলে `DELETE`।

---

# 📝 Practice — UPDATE

### Task 1
`id = 2` student-এর age 23 করো।

### Task 2
`id = 4` student-এর city `Dhaka` করো।

### Task 3
`id = 5` student-এর email `sakib.new@gmail.com` করো।

### Task 4
`id = 6` student-এর age 25 এবং status `Active` করো।

### Task 5
Dhaka-এর সব student-এর status `Active` করো।

### Task 6
Age 18 থেকে 20-এর মধ্যে থাকা student-দের status `Active` করো।

### Task 7
Dhaka অথবা Khulna-এর student-দের status `Inactive` করো।

### Task 8
`id = 7` student-এর age 1 বাড়াও।

---

# 📝 Practice — DELETE

### Task 9
`id = 10` student record delete করো।

### Task 10
যে student-এর email `test@example.com`, সেই record delete করো।

### Task 11
`status = 'Inactive'` এবং `city = 'Sylhet'`—এমন records delete করো।

### Task 12
`city IN ('Rajshahi', 'Barishal')`—এমন records delete করার query লেখো।

### Task 13
Inactive student-দের মধ্যে সর্বোচ্চ 1টি row delete করার query লেখো।

> Practice-এর জন্য delete করার আগে target rows অবশ্যই `SELECT` দিয়ে যাচাই করো।

---

# 🧠 Challenge — Mixed Tasks

### Challenge 1
আগে `id = 3` student-এর বর্তমান data দেখাও, তারপর age 18 করো, শেষে আবার verify করো।

### Challenge 2
Dhaka-এর Active student কতজন তা `COUNT(*)` দিয়ে বের করো। তারপর একই condition ব্যবহার করে status `Inactive` করার query লেখো। Practice table-এ চালানোর আগে target rows যাচাই করো।

### Challenge 3
Age 18 থেকে 22-এর মধ্যে থাকা student-দের city `Khulna` করো।

### Challenge 4
একটি নির্দিষ্ট student-এর email update করার আগে ও পরে কীভাবে verify করবে তা দেখাও।

### Challenge 5
কোনো delete করার আগে কতটি row মুছতে পারে তা `COUNT(*)` দিয়ে যাচাই করার query লেখো।

---

# 🧠 Phase 5 Quiz

1. `UPDATE` কী কাজে ব্যবহার হয়?
2. `SET` কী নির্দেশ করে?
3. `WHERE` কেন গুরুত্বপূর্ণ?
4. `UPDATE`-এ `WHERE` না থাকলে কী হতে পারে?
5. `DELETE` কী কাজে ব্যবহার হয়?
6. `DELETE`-এ `WHERE` না থাকলে কী হতে পারে?
7. `DELETE` এবং `DROP TABLE`-এর পার্থক্য কী?
8. একটি query দিয়ে কীভাবে একাধিক column update করবে?
9. কীভাবে একাধিক row update হতে পারে?
10. Update করার আগে `SELECT` কেন চালানো ভালো?
11. `COMMIT` কী করে?
12. `ROLLBACK` কখন কাজে লাগে?

---

# 📌 Quick Reference

## একটি row update

```sql
UPDATE students
SET age = 21
WHERE id = 5;
```

## একাধিক column update

```sql
UPDATE students
SET age = 22,
    city = 'Dhaka'
WHERE id = 5;
```

## একাধিক row update

```sql
UPDATE students
SET status = 'Active'
WHERE city = 'Dhaka';
```

## একটি row delete

```sql
DELETE FROM students
WHERE id = 5;
```

## নির্দিষ্ট condition-এ delete

```sql
DELETE FROM students
WHERE city = 'Dhaka'
  AND status = 'Inactive';
```

## আগে যাচাই

```sql
SELECT *
FROM students
WHERE id = 5;
```

## Matching rows count

```sql
SELECT COUNT(*)
FROM students
WHERE status = 'Inactive';
```

---

# ✅ Phase 5 Completion Checklist

- [ ] `UPDATE` বুঝি
- [ ] `SET` ব্যবহার করতে পারি
- [ ] `WHERE` দিয়ে নির্দিষ্ট row update করতে পারি
- [ ] একাধিক column update করতে পারি
- [ ] একাধিক row update হওয়ার বিষয়টি বুঝি
- [ ] `AND`, `OR`, `IN`, `BETWEEN` দিয়ে update condition লিখতে পারি
- [ ] `DELETE` দিয়ে নির্দিষ্ট row মুছতে পারি
- [ ] একাধিক row delete হওয়ার বিষয়টি বুঝি
- [ ] `DELETE` ও `DROP TABLE`-এর পার্থক্য জানি
- [ ] Update/Delete-এর আগে `SELECT` দিয়ে যাচাই করি
- [ ] `WHERE` ছাড়া query-এর ঝুঁকি বুঝি
- [ ] Basic transaction ও rollback ধারণা বুঝি

---

# 🎯 Phase 5 Goal

এই দুইটি pattern ভালোভাবে বুঝে practice করো।

## UPDATE

```sql
UPDATE table_name
SET column_name = new_value
WHERE condition;
```

## DELETE

```sql
DELETE FROM table_name
WHERE condition;
```

**মনে রাখবে:** Data পরিবর্তন বা মুছে ফেলার আগে target rows যাচাই করা একটি গুরুত্বপূর্ণ professional habit।

---

# 🚀 Next Phase — SQL Functions

পরবর্তী Phase-এ শিখবে:

- String Functions
- Numeric Functions
- Date Functions
- NULL Functions

এসব ব্যবহার করে query result-এর data transform ও calculate করা যাবে।

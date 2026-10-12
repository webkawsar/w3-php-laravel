# MySQL Phase 4 — ORDER BY, LIMIT & OFFSET

> **Level:** Beginner  
> **Prerequisite:** Phase 1 — Database Fundamentals, Phase 2 — INSERT & SELECT, Phase 3 — WHERE Conditions  
> **Goal:** Query result sort করা, result-এর সংখ্যা সীমিত করা এবং pagination-এর basic ধারণা শেখা।

---

## 📚 Phase 4 Overview

এই Phase-এ শিখবে:

- `ORDER BY`
- `ASC`
- `DESC`
- একাধিক column দিয়ে sorting
- `WHERE` + `ORDER BY`
- `LIMIT`
- `OFFSET`
- Pagination
- Common mistakes
- Practice tasks ও quiz

---

## 1. ORDER BY কী?

`ORDER BY` ব্যবহার করে query result নির্দিষ্ট order-এ সাজানো যায়।

যেমন:
- বয়স অনুযায়ী ছোট থেকে বড়
- নাম অনুযায়ী A থেকে Z
- Salary অনুযায়ী বেশি থেকে কম
- Date অনুযায়ী পুরোনো থেকে নতুন

### Syntax

```sql
SELECT columns
FROM table_name
ORDER BY column_name;
```

---

## 2. Practice Database

আগের Phase-এর `school.students` table ব্যবহার করো।

```sql
USE school;

SELECT *
FROM students;
```

ধরে নাও table-এ `id`, `name`, `age`, `email`, `city`, `status`, `birth_date` columns আছে।

---

## 3. ASC — Ascending Order

`ASC` মানে ascending order:

- Numbers: ছোট থেকে বড়
- Text: সাধারণত A থেকে Z
- Dates: পুরোনো থেকে নতুন

### Example

```sql
SELECT *
FROM students
ORDER BY age ASC;
```

এখানে কম বয়সী student আগে আসবে।

`ORDER BY age` লিখলেও MySQL-এর default sorting হলো `ASC`। তাই নিচের query দুটো একইভাবে sort করে:

```sql
SELECT *
FROM students
ORDER BY age ASC;
```

```sql
SELECT *
FROM students
ORDER BY age;
```

Beginner হিসেবে পরিষ্কার বোঝার জন্য `ASC` লিখতে পারো।

---

## 4. DESC — Descending Order

`DESC` মানে descending order:

- Numbers: বড় থেকে ছোট
- Text: সাধারণত Z থেকে A
- Dates: নতুন থেকে পুরোনো

```sql
SELECT *
FROM students
ORDER BY age DESC;
```

এখানে বেশি বয়সী student আগে আসবে।

নাম Z থেকে A সাজাতে:

```sql
SELECT name
FROM students
ORDER BY name DESC;
```

---

## 5. ASC বনাম DESC

| Keyword | Meaning | Number Example |
|---|---|---|
| `ASC` | Ascending | 10, 20, 30, 40 |
| `DESC` | Descending | 40, 30, 20, 10 |

মনে রাখবে:

```text
ASC  = ছোট থেকে বড়
DESC = বড় থেকে ছোট
```

---

## 6. নির্দিষ্ট Columns দেখিয়ে Sorting

শুধু name ও age দেখিয়ে age অনুযায়ী sort করতে:

```sql
SELECT name, age
FROM students
ORDER BY age ASC;
```

`SELECT` নির্ধারণ করে কোন columns দেখাবে, আর `ORDER BY` নির্ধারণ করে result কীভাবে সাজবে।

---

## 7. Text দিয়ে Sorting

নাম A থেকে Z:

```sql
SELECT name
FROM students
ORDER BY name ASC;
```

নাম Z থেকে A:

```sql
SELECT name
FROM students
ORDER BY name DESC;
```

Text sorting-এর ক্ষেত্রে collation ও case অনুযায়ী আচরণ কিছুটা ভিন্ন হতে পারে।

---

## 8. Date দিয়ে Sorting

পুরোনো জন্মতারিখ আগে:

```sql
SELECT name, birth_date
FROM students
ORDER BY birth_date ASC;
```

নতুন জন্মতারিখ আগে:

```sql
SELECT name, birth_date
FROM students
ORDER BY birth_date DESC;
```

---

## 9. একাধিক Column দিয়ে ORDER BY

প্রথমে city অনুযায়ী এবং একই city-এর মধ্যে age অনুযায়ী sort করতে:

```sql
SELECT name, city, age
FROM students
ORDER BY city ASC, age ASC;
```

এখানে:
1. প্রথমে `city` ascending order-এ সাজবে।
2. একই city-এর records-এর মধ্যে `age` ascending order-এ সাজবে।

একই city-এর মধ্যে বেশি বয়সী student আগে চাইলে:

```sql
SELECT name, city, age
FROM students
ORDER BY city ASC, age DESC;
```

---

## 10. WHERE + ORDER BY

প্রথমে condition অনুযায়ী records filter হবে, তারপর result sort হবে।

```sql
SELECT name, age, city
FROM students
WHERE age >= 20
ORDER BY age ASC;
```

অর্থ: যাদের age 20 বা তার বেশি, তাদের name, age ও city দেখাও এবং age ছোট থেকে বড় সাজাও।

Dhaka-এর student-দের বেশি বয়স থেকে কম বয়সে সাজাতে:

```sql
SELECT name, age, city
FROM students
WHERE city = 'Dhaka'
ORDER BY age DESC;
```

---

## 11. LIMIT কী?

`LIMIT` দিয়ে result-এ সর্বোচ্চ কতটি row দেখানো হবে তা নির্ধারণ করা যায়।

```sql
SELECT *
FROM students
LIMIT 5;
```

সর্বোচ্চ 5টি row দেখাবে।

> `LIMIT` নিজে নির্দিষ্ট sorting নিশ্চিত করে না। কোন records আগে আসবে তা নিয়ন্ত্রণ করতে হলে `ORDER BY` ব্যবহার করো।

---

## 12. ORDER BY + LIMIT

বয়সে সবচেয়ে বেশি 3 জন student দেখতে:

```sql
SELECT name, age
FROM students
ORDER BY age DESC
LIMIT 3;
```

বয়সে সবচেয়ে কম 3 জন:

```sql
SELECT name, age
FROM students
ORDER BY age ASC
LIMIT 3;
```

---

## 13. WHERE + LIMIT

Dhaka-এর সর্বোচ্চ 3টি record দেখতে:

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
LIMIT 3;
```

Dhaka-এর বয়সে সবচেয়ে বেশি 3 জন দেখতে:

```sql
SELECT name, age
FROM students
WHERE city = 'Dhaka'
ORDER BY age DESC
LIMIT 3;
```

---

## 14. OFFSET কী?

`OFFSET` বলে দেয় result-এর শুরু থেকে কতটি row skip করতে হবে।

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 0;
```

প্রথম 5টি row দেখাবে।

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 5;
```

প্রথম 5টি skip করে পরের সর্বোচ্চ 5টি row দেখাবে।

```text
LIMIT 5 OFFSET 0  → প্রথম 5টি row
LIMIT 5 OFFSET 5  → প্রথম 5টি বাদ দিয়ে পরের 5টি
LIMIT 5 OFFSET 10 → প্রথম 10টি বাদ দিয়ে পরের 5টি
```

---

## 15. LIMIT + OFFSET দিয়ে Pagination

Pagination মানে data-কে একাধিক page-এ ভাগ করে দেখানো।

ধরো, প্রতি page-এ 5টি student দেখাতে চাও।

### Page 1

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 0;
```

### Page 2

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 5;
```

### Page 3

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 10;
```

`ORDER BY id ASC` ব্যবহার করায় records একটি consistent order-এ আসে।

---

## 16. Pagination Formula

```text
OFFSET = (Page number - 1) × Page size
```

ধরো, প্রতি page-এ 10টি row এবং Page 3 দেখতে চাও:

```text
OFFSET = (3 - 1) × 10
OFFSET = 20
```

Query:

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 10 OFFSET 20;
```

---

## 17. LIMIT-এর Alternative Syntax

MySQL-এ এই format-টিও ব্যবহার করা যায়:

```sql
SELECT *
FROM students
LIMIT 5, 10;
```

অর্থ: প্রথম 5টি row skip করে পরের সর্বোচ্চ 10টি row দেখাও।

এটি equivalent:

```sql
SELECT *
FROM students
LIMIT 10 OFFSET 5;
```

Beginner হিসেবে বেশি readable হওয়ায় `LIMIT 10 OFFSET 5` ব্যবহার করতে পারো।

---

## 18. ORDER BY + LIMIT + OFFSET একসাথে

```sql
SELECT id, name, age
FROM students
WHERE status = 'Active'
ORDER BY age DESC
LIMIT 5 OFFSET 10;
```

এখানে:
1. Active student filter হবে।
2. Age বড় থেকে ছোট সাজবে।
3. প্রথম 10টি matching row skip হবে।
4. পরের সর্বোচ্চ 5টি row দেখানো হবে।

---

## 19. Sorting-এর সময় Tie হলে কী হবে?

ধরো, একাধিক student-এর age একই:

```sql
SELECT id, name, age
FROM students
ORDER BY age DESC;
```

একই age-এর student-দের মধ্যে order নিশ্চিত নয়। Consistent order চাইলে দ্বিতীয় column যোগ করো:

```sql
SELECT id, name, age
FROM students
ORDER BY age DESC, id ASC;
```

এখন age বড় থেকে ছোট হবে। Age একই হলে `id` ছোট থেকে বড় হবে।

---

## 20. Common Beginner Mistakes

### Mistake 1 — ভুল direction

```sql
ORDER BY age ASC;
```

এটি ছোট থেকে বড় সাজায়। বড় থেকে ছোট চাইলে:

```sql
ORDER BY age DESC;
```

### Mistake 2 — LIMIT-কে sorting মনে করা

```sql
SELECT *
FROM students
LIMIT 5;
```

এটি সর্বোচ্চ 5টি row দেখায়; বয়সে সবচেয়ে বেশি 5 জনকে বেছে নেয় না।

সঠিক:

```sql
SELECT *
FROM students
ORDER BY age DESC
LIMIT 5;
```

### Mistake 3 — Pagination-এ ORDER BY না দেওয়া

```sql
SELECT *
FROM students
LIMIT 5 OFFSET 5;
```

এটি কাজ করে, কিন্তু নির্দিষ্ট row order নিশ্চিত করে না। আরও নির্ভরযোগ্য:

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 5;
```

### Mistake 4 — OFFSET ভুল হিসাব করা

Page size 5 হলে:

```text
Page 1 → OFFSET 0
Page 2 → OFFSET 5
Page 3 → OFFSET 10
Page 4 → OFFSET 15
```

Formula: `(Page number - 1) × Page size`

---

## 21. Practice — ORDER BY

1. সব student-কে age ছোট থেকে বড় সাজাও।
2. সব student-কে age বড় থেকে ছোট সাজাও।
3. সব student-এর name A থেকে Z সাজাও।
4. সব student-এর name Z থেকে A সাজাও।
5. Student-দের birth date পুরোনো থেকে নতুন সাজাও।
6. Student-দের birth date নতুন থেকে পুরোনো সাজাও।

---

## 22. Practice — Multiple Columns

7. প্রথমে city A–Z, তারপর একই city-এর মধ্যে age ছোট থেকে বড় সাজাও।
8. প্রথমে city A–Z, তারপর একই city-এর মধ্যে age বড় থেকে ছোট সাজাও।
9. প্রথমে status, তারপর name A–Z সাজাও।
10. Age বড় থেকে ছোট এবং age একই হলে `id` ছোট থেকে বড় সাজাও।

---

## 23. Practice — WHERE + ORDER BY

11. শুধু Dhaka-এর student দেখাও এবং age ছোট থেকে বড় সাজাও।
12. শুধু Active student দেখাও এবং name A–Z সাজাও।
13. Age 20 বা তার বেশি student-দের age বড় থেকে ছোট সাজাও।
14. Dhaka-এর Female student-দের age বড় থেকে ছোট সাজাও।

---

## 24. Practice — LIMIT

15. Table-এর প্রথম 5টি row দেখাও।
16. Age-এ সবচেয়ে বেশি 3 জন student দেখাও।
17. Age-এ সবচেয়ে কম 3 জন student দেখাও।
18. Dhaka-এর সর্বোচ্চ 4টি student record দেখাও।
19. Active student-দের মধ্যে বয়সে সবচেয়ে বেশি 5 জন দেখাও।

---

## 25. Practice — OFFSET & Pagination

20. প্রথম 5টি row দেখাও।
21. প্রথম 5টি বাদ দিয়ে পরের 5টি row দেখাও।
22. প্রথম 10টি বাদ দিয়ে পরের 5টি row দেখাও।
23. প্রতি page-এ 10টি row হলে Page 4-এর query লেখো।
24. প্রতি page-এ 5টি row হলে Page 6-এর query লেখো।
25. `id` ascending order-এ Page 2-এর 5টি student দেখাও।

---

## 26. Challenge — Mixed Queries

### Challenge 1
Dhaka-এর Active student-দের age বড় থেকে ছোট সাজিয়ে প্রথম 3 জন দেখাও।

### Challenge 2
Age 18 থেকে 25-এর মধ্যে থাকা student-দের name A–Z সাজিয়ে প্রথম 5 জন দেখাও।

### Challenge 3
Gmail ব্যবহার করে এমন student-দের মধ্যে বয়সে সবচেয়ে বেশি 5 জন দেখাও।

### Challenge 4
Dhaka অথবা Khulna-এর student-দের age বড় থেকে ছোট সাজিয়ে প্রথম 5টি row দেখাও।

### Challenge 5
Active student-দের `id` ascending order-এ সাজিয়ে Page 3-এর 5টি row দেখাও।

### Challenge 6
Age একই হলে `id` ascending রেখে সব student-কে age descending order-এ সাজাও।

---

## 🧠 Phase 4 Quiz

1. `ORDER BY` কী কাজে ব্যবহার হয়?
2. `ASC` কী বোঝায়?
3. `DESC` কী বোঝায়?
4. Direction না লিখলে default sorting কী?
5. একাধিক column দিয়ে কীভাবে sort করবে?
6. `LIMIT 5` কী করে?
7. `OFFSET 5` কী বোঝায়?
8. `LIMIT 5 OFFSET 10` কী করে?
9. Page size 10 হলে Page 4-এর OFFSET কত?
10. Pagination-এ `ORDER BY` কেন গুরুত্বপূর্ণ?
11. Age descending order-এ সবচেয়ে বেশি বয়সী 3 জনের query কী?
12. `WHERE`, `ORDER BY` এবং `LIMIT` একসাথে কীভাবে ব্যবহার করবে?

---

## 📌 Quick Reference

### Ascending

```sql
SELECT *
FROM students
ORDER BY age ASC;
```

### Descending

```sql
SELECT *
FROM students
ORDER BY age DESC;
```

### Multiple Columns

```sql
SELECT *
FROM students
ORDER BY city ASC, age DESC;
```

### Filter + Sort

```sql
SELECT *
FROM students
WHERE city = 'Dhaka'
ORDER BY age DESC;
```

### First 5 Rows

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5;
```

### Skip 5, Show Next 5

```sql
SELECT *
FROM students
ORDER BY id ASC
LIMIT 5 OFFSET 5;
```

### Pagination Formula

```text
OFFSET = (Page number - 1) × Page size
```

---

## ✅ Phase 4 Completion Checklist

- [ ] `ORDER BY` বুঝি
- [ ] `ASC` ব্যবহার করতে পারি
- [ ] `DESC` ব্যবহার করতে পারি
- [ ] Number, text ও date দিয়ে sort করতে পারি
- [ ] Multiple columns দিয়ে sort করতে পারি
- [ ] `WHERE` + `ORDER BY` ব্যবহার করতে পারি
- [ ] `LIMIT` ব্যবহার করতে পারি
- [ ] `OFFSET` ব্যবহার করতে পারি
- [ ] Pagination-এর formula বুঝি
- [ ] Pagination-এ consistent ordering-এর গুরুত্ব বুঝি
- [ ] Complex sorting query লিখতে পারি

---

## 🎯 Phase 4 Goal

এই pattern বুঝে practice করো:

```sql
SELECT columns
FROM table_name
WHERE condition
ORDER BY column_name ASC
LIMIT 5 OFFSET 0;
```

- `SELECT` — কোন columns দেখাবে
- `FROM` — কোন Table থেকে data নেবে
- `WHERE` — কোন records filter করবে
- `ORDER BY` — কীভাবে সাজাবে
- `LIMIT` — সর্বোচ্চ কতটি row দেখাবে
- `OFFSET` — শুরু থেকে কতটি row skip করবে

---

## 🚀 Next Phase — UPDATE & DELETE

পরবর্তী Phase-এ শিখবে:

```text
UPDATE
SET
DELETE
WHERE-এর গুরুত্ব
Safe data modification
```

বিশেষ করে `UPDATE` বা `DELETE` করার আগে কীভাবে সঠিক records নির্বাচন করতে হয়, তা practice করা হবে।

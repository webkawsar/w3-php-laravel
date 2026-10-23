# MySQL শেখার Roadmap — Phase 13: CASE Statement

এই Phase-এ MySQL-এর `CASE` statement একদম beginner level থেকে ধাপে ধাপে শিখবে। `CASE` দিয়ে SQL query-এর মধ্যে condition অনুযায়ী আলাদা result তৈরি করা যায়—যেমন marks অনুযায়ী grade, age অনুযায়ী category, অথবা pass/fail status।

## এই Phase শেষে তুমি পারবে

- `CASE`, `WHEN`, `THEN`, `ELSE`, `END`-এর কাজ বুঝতে।
- Simple CASE এবং searched CASE-এর পার্থক্য বুঝতে।
- `SELECT`, `ORDER BY`, `GROUP BY` ও `UPDATE`-এর সঙ্গে CASE ব্যবহার করতে।
- একাধিক condition-এর order কেন গুরুত্বপূর্ণ তা বুঝতে।
- `NULL` এবং `ELSE` বাদ দেওয়ার আচরণ বুঝতে।
- CASE ব্যবহার করে বাস্তবধর্মী report তৈরি করতে।

---

## 1. CASE কী?

`CASE` হলো SQL-এর conditional expression। এটি row-এর data পরীক্ষা করে condition অনুযায়ী একটি value ফেরত দেয়।

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 80 THEN 'Excellent'
        WHEN marks >= 60 THEN 'Good'
        ELSE 'Needs Improvement'
    END AS performance
FROM students;
```

এখানে:

- `CASE` conditional expression শুরু করে।
- `WHEN` একটি condition দেয়।
- `THEN` condition সত্য হলে result কী হবে তা বলে।
- `ELSE` কোনো `WHEN` condition সত্য না হলে default result দেয়।
- `END` CASE expression শেষ করে।
- `AS performance` result column-এর নাম দেয়।

`CASE`-কে programming-এর `if/else`-এর সঙ্গে তুলনা করতে পারো। তবে SQL-এ এটি query-এর ভেতরে value তৈরি করে।

## 2. Practice database ও sample data

Phase 12-এর `mysql_practice` database এবং `students` table থাকলে সেটিই ব্যবহার করো:

```sql
USE mysql_practice;

SELECT student_id, student_name, age, city, marks, department_id
FROM students;
```

Table না থাকলে Phase 12-এর Markdown ফাইলের “Practice database ও sample data” section থেকে sample data তৈরি করো। একই নামের table drop করে এমন setup script চালানোর আগে সতর্ক থাকবে।

## 3. প্রথম CASE query

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 40 THEN 'Pass'
        ELSE 'Fail'
    END AS result_status
FROM students;
```

ধারণা: `marks >= 40` সত্য হলে `Pass`; অন্যথায় `Fail`। এখানে 40 শুধু শেখার উদাহরণ হিসেবে pass mark ধরা হয়েছে। বাস্তব পরীক্ষায় প্রতিষ্ঠানের নির্ধারিত নিয়ম ব্যবহার করবে।

| student_name | marks | result_status |
|---|---:|---|
| Amina | 85 | Pass |
| Rahim | 72 | Pass |
| Rafi | 60 | Pass |

এটি শুধু কয়েকটি উদাহরণ row; query-তে table-এর সব row আসবে।

## 4. একাধিক WHEN condition

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 90 THEN 'A'
        WHEN marks >= 80 THEN 'B'
        WHEN marks >= 70 THEN 'C'
        WHEN marks >= 60 THEN 'D'
        ELSE 'Needs Improvement'
    END AS grade
FROM students;
```

CASE ওপর থেকে নিচে condition পরীক্ষা করে এবং **প্রথম যে condition সত্য হয়, সেটির result ফেরত দেয়**। এরপরের condition আর পরীক্ষা করে না।

যেমন marks `95` হলে `marks >= 90` সত্য, তাই grade `A`। বড় threshold থেকে ছোট threshold-এর দিকে সাজানো নিরাপদ।

নিচের order ভুল:

```sql
CASE
    WHEN marks >= 60 THEN 'D'
    WHEN marks >= 70 THEN 'C'
    WHEN marks >= 80 THEN 'B'
    WHEN marks >= 90 THEN 'A'
    ELSE 'Needs Improvement'
END
```

এখানে 95 marks-ও প্রথম condition-এ match করে `D` পাবে।

## 5. Simple CASE এবং Searched CASE

### Searched CASE

প্রতিটি `WHEN`-এ সম্পূর্ণ condition লেখা হয়।

```sql
SELECT
    student_name,
    age,
    CASE
        WHEN age < 20 THEN 'Under 20'
        WHEN age BETWEEN 20 AND 22 THEN '20 to 22'
        ELSE '23 or Older'
    END AS age_group
FROM students;
```

### Simple CASE

একটি expression-এর value-এর সঙ্গে বিভিন্ন value তুলনা করা হয়।

```sql
SELECT
    student_name,
    department_id,
    CASE department_id
        WHEN 1 THEN 'Computer Science'
        WHEN 2 THEN 'Business'
        WHEN 3 THEN 'English'
        WHEN 4 THEN 'Mathematics'
        ELSE 'Unknown Department'
    END AS department_label
FROM students;
```

পার্থক্য:

- `CASE department_id WHEN 1 THEN ...` একটি expression-এর value মিলিয়ে দেখে।
- `CASE WHEN marks >= 80 THEN ...` যেকোনো condition পরীক্ষা করে।
- Range, `AND`, `OR`, `BETWEEN` বা `IS NULL` দরকার হলে searched CASE বেশি উপযোগী।

## 6. ELSE বাদ দিলে কী হয়?

`ELSE` optional। কিন্তু কোনো `WHEN` condition সত্য না হলে এবং `ELSE` না থাকলে result হয় `NULL`।

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
    END AS marks_category
FROM students;
```

Marks 60-এর কম হলে `marks_category` হবে `NULL`। Report-এ অপ্রত্যাশিত NULL এড়াতে প্রয়োজন অনুযায়ী `ELSE` লিখবে।

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END AS marks_category
FROM students;
```

## 7. CASE-এর মধ্যে NULL condition

`NULL`-এর সঙ্গে `= NULL` ব্যবহার করা সঠিক নয়। `NULL` পরীক্ষা করতে `IS NULL` বা `IS NOT NULL` ব্যবহার করো।

```sql
SELECT
    student_name,
    department_id,
    CASE
        WHEN department_id IS NULL THEN 'Not Assigned'
        ELSE 'Assigned'
    END AS department_status
FROM students;
```

Marks নেই কি না পরীক্ষা করতে:

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks IS NULL THEN 'Marks Missing'
        WHEN marks >= 40 THEN 'Pass'
        ELSE 'Fail'
    END AS exam_status
FROM students;
```

`marks IS NULL` আগে রাখা হয়েছে, যাতে missing marks-কে সরাসরি Fail বলা না হয়।

## 8. CASE-এর সঙ্গে AND, OR ও BETWEEN

`WHEN` condition-এর মধ্যে সাধারণ SQL condition ব্যবহার করা যায়।

### AND

```sql
SELECT
    student_name,
    age,
    marks,
    CASE
        WHEN age >= 20 AND marks >= 80 THEN 'Eligible'
        ELSE 'Not Eligible'
    END AS eligibility
FROM students;
```

দুটি condition-ই সত্য হতে হবে।

### OR

```sql
SELECT
    student_name,
    city,
    marks,
    CASE
        WHEN city = 'Dhaka' OR marks >= 90 THEN 'Priority'
        ELSE 'Standard'
    END AS student_category
FROM students;
```

যেকোনো একটি condition সত্য হলেই `Priority` হবে।

### BETWEEN

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 90 THEN 'Excellent'
        WHEN marks >= 80 THEN 'Very Good'
        WHEN marks >= 70 THEN 'Good'
        WHEN marks >= 60 THEN 'Average'
        ELSE 'Needs Support'
    END AS marks_band
FROM students;
```

এখানে বড় threshold আগে রাখা হয়েছে। এই pattern সাধারণত decimal marks-এর জন্য আলাদা range লেখার চেয়ে সহজ।

## 9. CASE দিয়ে category তৈরি করা

### Age category

```sql
SELECT
    student_name,
    age,
    CASE
        WHEN age < 20 THEN 'Under 20'
        WHEN age <= 22 THEN '20 to 22'
        ELSE '23 or Older'
    END AS age_category
FROM students;
```

### Marks category

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 90 THEN 'Excellent'
        WHEN marks >= 80 THEN 'Very Good'
        WHEN marks >= 70 THEN 'Good'
        WHEN marks >= 60 THEN 'Average'
        ELSE 'Needs Support'
    END AS marks_category
FROM students;
```

এই labels শেখার উদাহরণ। বাস্তব প্রতিষ্ঠানে grade boundary তাদের policy অনুযায়ী ঠিক করতে হবে।

## 10. CASE-এর সঙ্গে ORDER BY

কখনও category-কে alphabetic order-এ নয়, নিজের পছন্দের ক্রমে সাজাতে হয়।

```sql
SELECT
    student_name,
    marks,
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END AS marks_category
FROM students
ORDER BY
    CASE
        WHEN marks >= 80 THEN 1
        WHEN marks >= 60 THEN 2
        ELSE 3
    END,
    marks DESC;
```

এখানে High প্রথমে, Medium পরে, Low শেষে আসবে। একই category-তে marks বেশি থেকে কম সাজানো হবে।

## 11. CASE-এর সঙ্গে GROUP BY

CASE দিয়ে row-গুলোকে category-তে ভাগ করে `GROUP BY` দিয়ে প্রতিটি category-র সংখ্যা গণনা করা যায়।

```sql
SELECT
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END AS marks_category,
    COUNT(*) AS total_students
FROM students
GROUP BY
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END;
```

`COUNT(*)` প্রতিটি category-তে কয়টি row আছে তা গণনা করে।

## 12. CASE দিয়ে conditional aggregation

### 80 বা তার বেশি marks পাওয়া শিক্ষার্থী কতজন?

```sql
SELECT
    SUM(
        CASE
            WHEN marks >= 80 THEN 1
            ELSE 0
        END
    ) AS students_with_80_or_more
FROM students;
```

Condition সত্য হলে `1`, অন্যথায় `0`। `SUM()` সবগুলো যোগ করে qualifying row-এর সংখ্যা দেয়।

### Pass, fail ও missing marks count

```sql
SELECT
    SUM(CASE WHEN marks >= 40 THEN 1 ELSE 0 END) AS pass_count,
    SUM(CASE WHEN marks < 40 THEN 1 ELSE 0 END) AS fail_count,
    SUM(CASE WHEN marks IS NULL THEN 1 ELSE 0 END) AS missing_marks_count
FROM students;
```

এখানে pass mark 40 শুধু উদাহরণ হিসেবে নেওয়া হয়েছে।

## 13. CASE-এর সঙ্গে UPDATE

`CASE` দিয়ে `UPDATE` query-তে condition অনুযায়ী একাধিক row-এর value আলাদা করে update করা যায়।

প্রথমে column তৈরি করো—শুধু যদি column-টি আগে থেকে না থাকে:

```sql
ALTER TABLE students
ADD COLUMN performance_label VARCHAR(30);
```

তারপর:

```sql
UPDATE students
SET performance_label =
    CASE
        WHEN marks >= 90 THEN 'Excellent'
        WHEN marks >= 80 THEN 'Very Good'
        WHEN marks >= 70 THEN 'Good'
        WHEN marks >= 60 THEN 'Average'
        ELSE 'Needs Support'
    END;
```

Result যাচাই করো:

```sql
SELECT student_name, marks, performance_label
FROM students;
```

**সতর্কতা:** `UPDATE` data পরিবর্তন করে। আগে একই CASE expression দিয়ে `SELECT` চালিয়ে কোন row কী value পাবে তা যাচাই করো। Production database-এ update করার আগে backup ও অনুমতি নিশ্চিত করো।

## 14. CASE-এর সঙ্গে WHERE

`WHERE`-এর মধ্যে CASE expression ব্যবহার করা যায়, কিন্তু অনেক সাধারণ ক্ষেত্রে সরাসরি condition লেখা সহজ।

```sql
SELECT student_name, marks
FROM students
WHERE
    CASE
        WHEN marks IS NULL THEN 0
        WHEN marks >= 80 THEN 1
        ELSE 0
    END = 1;
```

এটি 80 বা তার বেশি marks পাওয়া শিক্ষার্থীদের দেখাবে। একই কাজ সহজভাবে:

```sql
SELECT student_name, marks
FROM students
WHERE marks >= 80;
```

শুধু filter করার জন্য সরল `WHERE` condition যথেষ্ট হলে সেটিই ব্যবহার করো।

## 15. CASE বনাম IF()

MySQL-এ `IF()` function-ও condition অনুযায়ী value ফেরত দিতে পারে।

```sql
SELECT
    student_name,
    marks,
    IF(marks >= 40, 'Pass', 'Fail') AS result_if,
    CASE
        WHEN marks >= 40 THEN 'Pass'
        ELSE 'Fail'
    END AS result_case
FROM students;
```

- `IF(condition, true_value, false_value)` সাধারণত একটি condition-এর জন্য সংক্ষিপ্ত।
- `CASE` একাধিক condition ও range-এর জন্য বেশি readable।
- `CASE` SQL-এর standard expression এবং বিভিন্ন SQL database-এ বহুল ব্যবহৃত।

## 16. সাধারণ ভুল

### ভুল 1: END বাদ দেওয়া

প্রতিটি CASE expression `END` দিয়ে শেষ করতে হবে।

### ভুল 2: THEN বাদ দেওয়া

প্রতিটি `WHEN` condition-এর পরে `THEN` দিতে হবে।

### ভুল 3: Condition-এর order ভুল

`marks >= 60` প্রথমে লিখলে 90 marks-ও সেই condition-এ match করবে। Overlapping threshold থাকলে বড় threshold আগে লেখো।

### ভুল 4: NULL-এর জন্য `= NULL` লেখা

ভুল: `CASE WHEN department_id = NULL THEN ...`

সঠিক:

```sql
CASE
    WHEN department_id IS NULL THEN 'Missing'
    ELSE 'Present'
END
```

### ভুল 5: ELSE বাদ দিয়ে NULL result পাওয়া

কোনো condition match না করলে এবং `ELSE` না থাকলে result `NULL` হয়।

### ভুল 6: SELECT alias-কে WHERE-এ ব্যবহার করা

একই query-তে `SELECT`-এর alias সাধারণত `WHERE` clause-এ ব্যবহার করা যায় না, কারণ query processing-এর order আলাদা। প্রয়োজন হলে expression আবার লেখো অথবা derived table/CTE ব্যবহার করো।

---

## 17. Practice tasks — নিজে করো

প্রথমে উত্তর না দেখে চেষ্টা করো।

1. 80 বা বেশি marks হলে `High`, 60 বা বেশি হলে `Medium`, অন্যথায় `Low` দেখাও।
2. বয়স 20-এর কম হলে `Under 20`, 20 থেকে 22 হলে `20 to 22`, অন্যথায় `23 or Older` দেখাও।
3. `department_id` NULL হলে `Not Assigned`, অন্যথায় `Assigned` দেখাও।
4. Simple CASE ব্যবহার করে department ID-কে department name-এ রূপান্তর করো।
5. Marks অনুযায়ী `Excellent`, `Very Good`, `Good`, `Average`, `Needs Support` category তৈরি করো।
6. High, Medium, Low category-র custom order-এ শিক্ষার্থীদের সাজাও।
7. Marks category অনুযায়ী শিক্ষার্থীর সংখ্যা গণনা করো।
8. 80 বা বেশি marks পাওয়া শিক্ষার্থীর সংখ্যা গণনা করো।
9. Pass, fail এবং missing marks-এর সংখ্যা এক query-তে বের করো।
10. `performance_label` column তৈরি করে CASE দিয়ে update করো। আগে SELECT দিয়ে ফল যাচাই করো।
11. `CASE` ও `IF()` দিয়ে একই Pass/Fail result তৈরি করো।
12. কোনো condition match না করলে `ELSE 'Unknown'` দেখায় এমন query লেখো।

## 18. Practice tasks — উত্তর

### উত্তর 1

```sql
SELECT student_name, marks,
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END AS marks_category
FROM students;
```

### উত্তর 2

```sql
SELECT student_name, age,
    CASE
        WHEN age < 20 THEN 'Under 20'
        WHEN age <= 22 THEN '20 to 22'
        ELSE '23 or Older'
    END AS age_category
FROM students;
```

### উত্তর 3

```sql
SELECT student_name, department_id,
    CASE
        WHEN department_id IS NULL THEN 'Not Assigned'
        ELSE 'Assigned'
    END AS department_status
FROM students;
```

### উত্তর 4

```sql
SELECT student_name, department_id,
    CASE department_id
        WHEN 1 THEN 'Computer Science'
        WHEN 2 THEN 'Business'
        WHEN 3 THEN 'English'
        WHEN 4 THEN 'Mathematics'
        ELSE 'Unknown Department'
    END AS department_name
FROM students;
```

### উত্তর 5

```sql
SELECT student_name, marks,
    CASE
        WHEN marks >= 90 THEN 'Excellent'
        WHEN marks >= 80 THEN 'Very Good'
        WHEN marks >= 70 THEN 'Good'
        WHEN marks >= 60 THEN 'Average'
        ELSE 'Needs Support'
    END AS performance_label
FROM students;
```

### উত্তর 6

```sql
SELECT student_name, marks
FROM students
ORDER BY
    CASE
        WHEN marks >= 80 THEN 1
        WHEN marks >= 60 THEN 2
        ELSE 3
    END,
    marks DESC;
```

### উত্তর 7

```sql
SELECT
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END AS marks_category,
    COUNT(*) AS total_students
FROM students
GROUP BY
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Low'
    END;
```

### উত্তর 8

```sql
SELECT SUM(CASE WHEN marks >= 80 THEN 1 ELSE 0 END)
    AS students_with_80_or_more
FROM students;
```

### উত্তর 9

```sql
SELECT
    SUM(CASE WHEN marks >= 40 THEN 1 ELSE 0 END) AS pass_count,
    SUM(CASE WHEN marks < 40 THEN 1 ELSE 0 END) AS fail_count,
    SUM(CASE WHEN marks IS NULL THEN 1 ELSE 0 END) AS missing_marks_count
FROM students;
```

### উত্তর 10

Column আগে থেকে না থাকলেই কেবল এটি চালাবে:

```sql
ALTER TABLE students
ADD COLUMN performance_label VARCHAR(30);
```

তারপর:

```sql
UPDATE students
SET performance_label =
    CASE
        WHEN marks >= 90 THEN 'Excellent'
        WHEN marks >= 80 THEN 'Very Good'
        WHEN marks >= 70 THEN 'Good'
        WHEN marks >= 60 THEN 'Average'
        ELSE 'Needs Support'
    END;
```

### উত্তর 11

```sql
SELECT
    student_name,
    IF(marks >= 40, 'Pass', 'Fail') AS result_if,
    CASE
        WHEN marks >= 40 THEN 'Pass'
        ELSE 'Fail'
    END AS result_case
FROM students;
```

### উত্তর 12

```sql
SELECT student_name, marks,
    CASE
        WHEN marks >= 80 THEN 'High'
        WHEN marks >= 60 THEN 'Medium'
        ELSE 'Unknown'
    END AS category
FROM students;
```

---

## 19. ছোট Quiz

1. `CASE` expression-এর কাজ কী?
2. `WHEN` ও `THEN`-এর কাজ কী?
3. `ELSE` না থাকলে কোনো condition match না করলে কী result হয়?
4. CASE-এর condition কোন order-এ পরীক্ষা করা হয়?
5. `CASE department_id WHEN 1 THEN ...` কোন ধরনের CASE?
6. `CASE WHEN marks >= 80 THEN ...` কোন ধরনের CASE?
7. NULL পরীক্ষা করতে `= NULL` নাকি `IS NULL` ব্যবহার করবে?
8. CASE দিয়ে category অনুযায়ী row count করতে কোন aggregate function ব্যবহার করা যায়?
9. CASE দিয়ে UPDATE করার আগে SELECT চালানো কেন ভালো?
10. একাধিক condition-এর ক্ষেত্রে CASE কেন উপকারী?

### Quiz-এর উত্তর

1. Condition অনুযায়ী value ফেরত দেয়।
2. `WHEN` condition দেয়, `THEN` condition সত্য হলে result দেয়।
3. `NULL`।
4. উপর থেকে নিচে; প্রথম সত্য condition-এর result ফেরত দেয়।
5. Simple CASE।
6. Searched CASE।
7. `IS NULL`।
8. `COUNT()` বা `SUM()`-এর সঙ্গে CASE ব্যবহার করা যায়।
9. কোন row কী value পাবে তা আগে যাচাই করতে এবং ভুল update এড়াতে।
10. একাধিক condition স্পষ্টভাবে ও ধারাবাহিকভাবে লেখা যায়।

---

## 20. Phase 13 Completion Checklist

- [ ] `CASE`, `WHEN`, `THEN`, `ELSE`, `END` বুঝি।
- [ ] Simple CASE ও searched CASE লিখতে পারি।
- [ ] একাধিক condition-এর order ঠিক রাখতে পারি।
- [ ] NULL পরীক্ষা করতে `IS NULL` ব্যবহার করি।
- [ ] `SELECT` ও `ORDER BY`-এর মধ্যে CASE ব্যবহার করতে পারি।
- [ ] `GROUP BY` এবং `SUM()` / `COUNT()`-এর সঙ্গে CASE ব্যবহার করতে পারি।
- [ ] `UPDATE`-এ CASE ব্যবহারের আগে data যাচাই করি।
- [ ] অন্তত 8টি practice task নিজে সমাধান করেছি।

## Quick Reference

| Syntax | কাজ |
|---|---|
| `CASE WHEN condition THEN value END` | Condition সত্য হলে value |
| `ELSE value` | কোনো condition match না করলে default value |
| `CASE column WHEN value THEN result END` | নির্দিষ্ট value match করা |
| `CASE WHEN column IS NULL THEN ...` | NULL value পরীক্ষা |
| `SUM(CASE WHEN condition THEN 1 ELSE 0 END)` | Condition মেলা row গোনা |
| `ORDER BY CASE ... END` | Custom order তৈরি |

---

## Roadmap অনুযায়ী পরের Phase

**Phase 14 — Constraints**

পরের Phase-এ `NOT NULL`, `UNIQUE`, `PRIMARY KEY`, `FOREIGN KEY`, `CHECK` এবং `DEFAULT` constraints শিখবে। এগুলো database-এ valid ও consistent data রাখার নিয়ম নির্ধারণ করে।



// IN ==> mane database row te age exactly ei 3ta value er majhe jekuno ektar sathe match korle result e asbe
SELECT *
FROM students
WHERE age IN (20, 25, 30); // age = 20 OR age = 25 OR age = 30;


Column-এর Value যদি IN-এর মধ্যে দেওয়া যেকোনো 1টি Value-এর সঙ্গে মিলে যায়, তাহলে সেই Row Result-এ আসবে।
IN Operator একাধিক OR Condition-কে সংক্ষিপ্তভাবে লেখার সুযোগ দেয়।


// NOT IN  ==> IN - এর বিপরীত কাজ করে
SELECT *
FROM students
WHERE age NOT IN (20, 25, 30);



// IN-এর সঙ্গে AND ও OR ব্যবহার
SELECT *
FROM students
WHERE age IN (20, 25, 30)
  AND city = 'Dhaka';

SELECT *
FROM students
WHERE age IN (20, 25, 30)
   OR city = 'Khulna';


// IN-এর ভেতরে Subquery ব্যবহার
SELECT *
FROM students
WHERE id IN (
    SELECT student_id
    FROM scholarship_students
);


// ভুল: IN-কে Range মনে করা
// যদি 20 থেকে 30 পর্যন্ত সব Age নির্বাচন করতে চাও, তাহলে
SELECT *
FROM students
WHERE age BETWEEN 20 AND 30;

// ভুল: NULL-কে সাধারণ Value মনে করা
// এটি age IS NULL-এর সমান নয়। NULL থাকা Row খুঁজতে
SELECT *
FROM students
WHERE age IS NULL;


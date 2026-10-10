
// GROUP BY
SELECT age, COUNT(*) AS total_students
FROM students
GROUP BY age;


// COUNT(*) হলো একটি Aggregate Function। এটি প্রতিটি Group-এর মোট Row গণনা করে।
/*
id	name	age	marks
++++++++++++++++++++++
1	Rahim	20	80
2	Karim	21	70
3	Sumaiya	20	90
4	Nabila	22	60
5	Hasan	21	85
6	Fahim	20	75
*/

// GROUP BY-এর মূল শক্তি হলো Group অনুযায়ী Aggregate Calculation করা, যেমন COUNT(), SUM() এবং AVG()
SELECT age, MIN(marks) AS lowest_marks
FROM students
GROUP BY age; // 75



// একাধিক Column দিয়ে GROUP BY
SELECT address, age, COUNT(*) AS total_students
FROM students
GROUP BY address, age;


// WHERE বনাম GROUP BY
WHERE → Group তৈরি হওয়ার আগে কোন Row রাখা হবে, তা নির্ধারণ করে।
GROUP BY → বাছাই করা Row-গুলোকে Group করে।


// HAVING কী এবং কেন লাগে?
WHERE ==> Group করার আগে Row Filter করে
GROUP BY ==> Row-গুলোকে Group করে
HAVING ==> Group তৈরি হওয়ার পরে Group Filter করে

SELECT age, COUNT(*) AS total_students
FROM students
GROUP BY age
HAVING COUNT(*) >= 3;










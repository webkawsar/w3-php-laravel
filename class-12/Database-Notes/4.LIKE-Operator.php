
// LIKE Operator
SELECT *
FROM students
WHERE name LIKE 'K%'; // mane K diye suru, '%Ahmed' mane Ahmed diye ses, '%ah%' mane jekuno jaygay ah.


LIKE হলো SQL-এর একটি Operator, যা কোনো Column-এর Value একটি নির্দিষ্ট Text Pattern-এর সঙ্গে মেলে কি না, তা পরীক্ষা করে।

// Percent Wildcard
SELECT *
FROM students
WHERE name LIKE 'K%';

SELECT *
FROM students
WHERE name LIKE '%K';

SELECT *
FROM students
WHERE name LIKE '%ah%';


// Underscore Wildcard
SELECT *
FROM students
WHERE name LIKE 'K_'; // mane total 2ta character er kujbe but K diye suru hote hobe

SELECT *
FROM students
WHERE name LIKE 'K__'; // mane total 3ta character er kujbe but K diye suru hote hobe

SELECT *
FROM students
WHERE name LIKE '___'; // mane total 3ta character er kujbe but K diye suru hote hobe

SELECT *
FROM students
WHERE name LIKE 'K___'; // mane total 4ta character er kujbe but K diye suru hote hobe

SELECT *
FROM students
WHERE name LIKE 'S_a%'; // S diye suru hote hoobe, 2nd char jekono 1ta hobe, 3rd char a hote hobe then jekono text



// NOT LIKE
SELECT *
FROM students
WHERE name NOT LIKE 'K%';





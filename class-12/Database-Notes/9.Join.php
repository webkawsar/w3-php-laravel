

// 1. INNER JOIN

// Alias ব্যবহার করা
SELECT s.name, c.course_name
FROM students AS s
INNER JOIN courses AS c
ON s.id = c.student_id;

SELECT s.name, c.course_name
FROM students s
INNER JOIN courses c
ON s.id = c.student_id
WHERE s.id >= 1
ORDER BY s.name ASC;


// 2. LEFT JOIN
SELECT s.name, c.course_name
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id;


// 3. Right Join
SELECT s.name, c.course_name
FROM students s
RIGHT JOIN courses c
ON s.id = c.student_id;


// JOIN + COUNT()
SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name;


SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2;


// Multiple JOIN
SELECT
    s.name AS student_name,
    c.course_name,
    t.name AS teacher_name
FROM students s
INNER JOIN courses c
    ON s.id = c.student_id
INNER JOIN teachers t
    ON c.teacher_id = t.id;


// JOIN + WHERE + GROUP BY + HAVING + ORDER BY
SELECT
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
    ON s.id = c.student_id
WHERE s.age >= 18
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2
ORDER BY total_courses DESC;
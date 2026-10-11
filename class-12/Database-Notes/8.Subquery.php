
// Subquery
SELECT *
FROM students
WHERE age = (
    SELECT MAX(age)
    FROM students
);

SELECT *
FROM students
WHERE id IN (
    SELECT student_id
    FROM courses
    WHERE course_name = 'MySQL'
);

SELECT
    s.id,
    s.name,
    COUNT(c.id) AS total_courses
FROM students s
LEFT JOIN courses c
ON s.id = c.student_id
GROUP BY s.id, s.name
HAVING COUNT(c.id) >= 2;


// EXISTS
SELECT *
FROM students s
WHERE EXISTS (
    SELECT 1
    FROM courses c
    WHERE c.student_id = s.id
);


// NOT EXISTS
SELECT *
FROM students s
WHERE NOT EXISTS (
    SELECT 1
    FROM courses c
    WHERE c.student_id = s.id
);


// CASE WHEN
SELECT
    name,
    age,
    CASE
        WHEN age < 18 THEN 'Minor'
        WHEN age BETWEEN 18 AND 25 THEN 'Young'
        ELSE 'Adult'
    END AS age_group
FROM students;
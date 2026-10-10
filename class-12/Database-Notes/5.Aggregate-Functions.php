// Aggregate Functions
SELECT COUNT(*) FROM students; // students table-এ মোট কতটি row আছে তা দেখাবে।
SELECT AVG(age) FROM students; // student-দের বয়সের গড় বের করবে। যেসব row-তে age-এর value NULL, সেগুলো গণনা করবে না

SUM() — মোট যোগফল।
MIN() — সর্বনিম্ন value।
MAX()

SELECT
    COUNT(*) AS total_students,
    SUM(age) AS total_age,
    AVG(age) AS average_age,
    MIN(age) AS minimum_age,
    MAX(age) AS maximum_age
FROM students;









🗺️ MySQL Learning Roadmap
✅ Level 1 — Database Fundamentals
Database কী
Table, Row, Column
Database তৈরি — CREATE DATABASE
Database select — USE
Table তৈরি — CREATE TABLE
Data Types
INT
TINYINT
VARCHAR
TEXT
DATE
BOOLEAN
AUTO_INCREMENT
PRIMARY KEY
NULL / NOT NULL
DEFAULT
UNIQUE
CHECK
✅ Level 2 — CRUD
INSERT
SELECT
UPDATE
DELETE
✅ Level 3 — Filtering & Sorting
WHERE
AND
OR
IN
NOT IN
BETWEEN
LIKE
% এবং _ wildcard
ORDER BY
LIMIT
OFFSET
✅ Level 4 — Aggregate & Grouping
COUNT()
SUM()
AVG()
MIN()
MAX()
GROUP BY
HAVING
✅ Level 5 — Relationships
FOREIGN KEY
Referential Integrity
ON DELETE
ON UPDATE
One-to-One Relationship
One-to-Many Relationship
Many-to-Many Relationship
✅ Level 6 — JOIN
INNER JOIN
LEFT JOIN
RIGHT JOIN
Multiple JOIN
JOIN + WHERE
JOIN + GROUP BY
JOIN + Aggregate Functions
JOIN + HAVING
✅ Level 7 — Subqueries
Subquery
Scalar Subquery
Multi-row Subquery
Correlated Subquery
IN + Subquery
EXISTS
NOT EXISTS
✅ Level 8 — Conditional & Combining Data
CASE WHEN
Simple CASE
Searched CASE
UNION
UNION ALL
INTERSECT / alternatives depending on MySQL version/use case
🟡 Level 9 — String Functions
CONCAT()
CONCAT_WS()
UPPER()
LOWER()
LENGTH()
CHAR_LENGTH()
SUBSTRING()
LEFT()
RIGHT()
TRIM()
REPLACE()
🟡 Level 10 — Date & Time
CURDATE()
CURTIME()
NOW()
DATE()
YEAR()
MONTH()
DAY()
DATEDIFF()
DATE_ADD()
DATE_SUB()
Date filtering
🟠 Level 11 — Database Design
Normalization
1NF
2NF
3NF
Denormalization
Primary Key design
Foreign Key design
Relationship design
Junction/Pivot tables
🟠 Level 12 — Indexing & Performance
Index কী
CREATE INDEX
DROP INDEX
Single-column Index
Composite Index
Unique Index
How indexes affect SELECT
EXPLAIN
Query optimization
Full Table Scan
Index usage
🔵 Level 13 — Advanced SQL
Common Table Expressions — WITH
Recursive CTE
Window Functions
ROW_NUMBER()
RANK()
DENSE_RANK()
PARTITION BY
Running totals
LAG()
LEAD()
🔵 Level 14 — Views & Stored Logic
VIEW
CREATE VIEW
ALTER VIEW
DROP VIEW
Stored Procedure
Parameters
Stored Function
User-defined functions
🔵 Level 15 — Transactions
Transaction কী
START TRANSACTION
COMMIT
ROLLBACK
SAVEPOINT
ACID
Transaction isolation
🔴 Level 16 — Advanced Database Concepts
Isolation Levels
Deadlocks
Locking
Row-level locking
Optimistic vs pessimistic locking
Concurrency
Race conditions
🔴 Level 17 — MySQL Administration
Users
CREATE USER
GRANT
REVOKE
Permissions
Database backup
Database restore
Import / Export
MySQL configuration
Basic server monitoring
🚀 Level 18 — Real-World Projects

শেষে theory বাদ দিয়ে real project বানাব:

Project 1 — Student Management System

students
courses
enrollments
teachers

Project 2 — E-commerce Database

users
products
categories
orders
order_items
payments

Project 3 — Blog/CMS Database

users
posts
categories
tags
comments

Project 4 — Music/Royalty Database

তোমার কাজের সাথে মিল রেখে:

artists
labels
releases
tracks
aggregators
royalties
royalty_reports

এখানে আমরা real-world reporting query লিখব।


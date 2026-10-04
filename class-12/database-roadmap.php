MYSQL COMPLETE LEARNING ROADMAP
===============================

LEVEL 1 — DATABASE FUNDAMENTALS
--------------------------------
1. Database কী
2. Table, Row, Column
3. CREATE DATABASE
4. USE Database
5. CREATE TABLE
6. Data Types
   - INT
   - TINYINT
   - SMALLINT
   - BIGINT
   - VARCHAR
   - TEXT
   - DATE
   - DATETIME
   - BOOLEAN
7. AUTO_INCREMENT
8. PRIMARY KEY
9. NULL
10. NOT NULL
11. DEFAULT
12. UNIQUE
13. CHECK
14. SHOW DATABASES
15. SHOW TABLES
16. DESCRIBE / DESC


LEVEL 2 — CRUD
--------------
17. INSERT
18. SELECT
19. UPDATE
20. DELETE
21. INSERT Multiple Rows
22. UPDATE Multiple Rows
23. DELETE Multiple Rows
24. Safe UPDATE / DELETE Practices


LEVEL 3 — FILTERING & SORTING
-----------------------------
25. WHERE
26. AND
27. OR
28. NOT
29. IN
30. NOT IN
31. BETWEEN
32. NOT BETWEEN
33. LIKE
34. NOT LIKE
35. % Wildcard
36. _ Wildcard
37. ORDER BY
38. ASC
39. DESC
40. LIMIT
41. OFFSET


LEVEL 4 — AGGREGATE FUNCTIONS
------------------------------
42. COUNT()
43. COUNT(column)
44. COUNT(DISTINCT)
45. SUM()
46. AVG()
47. MIN()
48. MAX()
49. Aggregate Functions with WHERE
50. Aggregate Functions with GROUP BY


LEVEL 5 — GROUPING & REPORTING
------------------------------
51. GROUP BY
52. GROUP BY Multiple Columns
53. HAVING
54. WHERE vs HAVING
55. GROUP BY + COUNT()
56. GROUP BY + SUM()
57. GROUP BY + AVG()
58. GROUP BY + MIN()
59. GROUP BY + MAX()
60. GROUP BY + ORDER BY
61. GROUP BY + HAVING


LEVEL 6 — CONSTRAINTS
---------------------
62. PRIMARY KEY
63. FOREIGN KEY
64. NOT NULL
65. UNIQUE
66. DEFAULT
67. CHECK
68. Composite PRIMARY KEY
69. Composite UNIQUE
70. Constraint Naming
71. Adding Constraints with ALTER TABLE
72. Removing Constraints


LEVEL 7 — TABLE RELATIONSHIPS
-----------------------------
73. Relationship কী
74. One-to-One
75. One-to-Many
76. Many-to-Many
77. Parent Table
78. Child Table
79. Foreign Key
80. Referential Integrity
81. ON DELETE
82. ON UPDATE
83. CASCADE
84. RESTRICT
85. SET NULL
86. Junction / Pivot Table


LEVEL 8 — JOIN
--------------
87. INNER JOIN
88. LEFT JOIN
89. RIGHT JOIN
90. CROSS JOIN
91. SELF JOIN
92. Multiple JOIN
93. JOIN + WHERE
94. JOIN + ORDER BY
95. JOIN + GROUP BY
96. JOIN + COUNT()
97. JOIN + SUM()
98. JOIN + AVG()
99. JOIN + HAVING
100. JOIN with Multiple Tables
101. JOIN vs Subquery


LEVEL 9 — SUBQUERY
------------------
102. Subquery কী
103. Scalar Subquery
104. Multi-row Subquery
105. Subquery with WHERE
106. Subquery with IN
107. Subquery with NOT IN
108. Subquery with EXISTS
109. Subquery with NOT EXISTS
110. Correlated Subquery
111. Nested Subquery
112. Subquery vs JOIN


LEVEL 10 — CONDITIONAL LOGIC
----------------------------
113. CASE
114. WHEN
115. THEN
116. ELSE
117. END
118. Simple CASE
119. Searched CASE
120. CASE + WHERE
121. CASE + GROUP BY
122. CASE + ORDER BY
123. CASE + Aggregate Functions


LEVEL 11 — COMBINING QUERY RESULTS
----------------------------------
124. UNION
125. UNION ALL
126. UNION vs UNION ALL
127. Combining Multiple SELECT Queries
128. INTERSECT / Alternatives in MySQL
129. EXCEPT / Alternatives in MySQL


LEVEL 12 — STRING FUNCTIONS
---------------------------
130. CONCAT()
131. CONCAT_WS()
132. UPPER()
133. LOWER()
134. LENGTH()
135. CHAR_LENGTH()
136. TRIM()
137. LTRIM()
138. RTRIM()
139. SUBSTRING()
140. SUBSTR()
141. LEFT()
142. RIGHT()
143. REPLACE()
144. LOCATE()
145. INSTR()
146. String Functions with SELECT
147. String Functions with WHERE


LEVEL 13 — DATE & TIME
----------------------
148. DATE Data Type
149. DATETIME Data Type
150. TIMESTAMP
151. CURDATE()
152. CURTIME()
153. NOW()
154. CURRENT_DATE()
155. CURRENT_TIME()
156. CURRENT_TIMESTAMP()
157. DATE()
158. TIME()
159. YEAR()
160. MONTH()
161. DAY()
162. HOUR()
163. MINUTE()
164. SECOND()
165. DATEDIFF()
166. TIMEDIFF()
167. DATE_ADD()
168. DATE_SUB()
169. INTERVAL
170. Date Filtering
171. Date Grouping
172. Date-based Reporting


LEVEL 14 — NULL & DATA HANDLING
------------------------------
173. NULL কী
174. IS NULL
175. IS NOT NULL
176. NULL vs 0
177. NULL vs Empty String
178. COALESCE()
179. IFNULL()
180. NULLIF()
181. Handling Missing Data


LEVEL 15 — DATABASE DESIGN & NORMALIZATION
------------------------------------------
182. Database Design কী
183. Normalization কী
184. First Normal Form (1NF)
185. Second Normal Form (2NF)
186. Third Normal Form (3NF)
187. BCNF
188. Denormalization
189. Primary Key Design
190. Foreign Key Design
191. Relationship Design
192. Avoiding Duplicate Data
193. Database Schema Design
194. ER Diagram
195. Junction Tables


LEVEL 16 — INDEXING
-------------------
196. Index কী
197. Why Index is Important
198. CREATE INDEX
199. DROP INDEX
200. Single-column Index
201. Composite Index
202. Unique Index
203. Primary Key Index
204. Index on Foreign Key
205. Index Selection
206. Index vs Full Table Scan
207. Index Trade-offs
208. When NOT to Use Index


LEVEL 17 — QUERY PERFORMANCE
----------------------------
209. EXPLAIN
210. EXPLAIN ANALYZE
211. Query Execution Plan
212. Full Table Scan
213. Index Scan
214. Index Usage
215. Slow Queries
216. Query Optimization
217. WHERE Optimization
218. JOIN Optimization
219. GROUP BY Optimization
220. ORDER BY Optimization
221. LIMIT Optimization
222. Avoiding N+1 Query Problems


LEVEL 18 — COMMON TABLE EXPRESSIONS
-----------------------------------
223. CTE কী
224. WITH
225. Basic CTE
226. Multiple CTE
227. CTE with JOIN
228. CTE with GROUP BY
229. CTE with Aggregate Functions
230. Recursive CTE


LEVEL 19 — WINDOW FUNCTIONS
---------------------------
231. Window Functions কী
232. OVER()
233. PARTITION BY
234. ORDER BY inside Window Function
235. ROW_NUMBER()
236. RANK()
237. DENSE_RANK()
238. NTILE()
239. LAG()
240. LEAD()
241. FIRST_VALUE()
242. LAST_VALUE()
243. Running Total
244. Ranking
245. Percentage / Distribution Analysis


LEVEL 20 — VIEWS
----------------
246. VIEW কী
247. CREATE VIEW
248. SELECT from VIEW
249. UPDATE VIEW
250. ALTER VIEW
251. DROP VIEW
252. VIEW with JOIN
253. VIEW with Aggregate Functions


LEVEL 21 — STORED PROCEDURES & FUNCTIONS
----------------------------------------
254. Stored Procedure কী
255. CREATE PROCEDURE
256. Procedure Parameters
257. IN Parameter
258. OUT Parameter
259. INOUT Parameter
260. CALL Procedure
261. DROP PROCEDURE
262. Stored Function
263. CREATE FUNCTION
264. Function Parameters
265. RETURN
266. DROP FUNCTION


LEVEL 22 — TRIGGERS
-------------------
267. Trigger কী
268. BEFORE INSERT
269. AFTER INSERT
270. BEFORE UPDATE
271. AFTER UPDATE
272. BEFORE DELETE
273. AFTER DELETE
274. Trigger Use Cases
275. Trigger Risks


LEVEL 23 — TRANSACTIONS
----------------------
276. Transaction কী
277. START TRANSACTION
278. COMMIT
279. ROLLBACK
280. SAVEPOINT
281. ROLLBACK TO SAVEPOINT
282. ACID
283. Atomicity
284. Consistency
285. Isolation
286. Durability


LEVEL 24 — TRANSACTION ISOLATION & CONCURRENCY
----------------------------------------------
287. Concurrency কী
288. Isolation Levels
289. READ UNCOMMITTED
290. READ COMMITTED
291. REPEATABLE READ
292. SERIALIZABLE
293. Dirty Read
294. Non-repeatable Read
295. Phantom Read
296. Locking
297. Row-level Lock
298. Deadlock
299. Race Condition
300. SELECT ... FOR UPDATE


LEVEL 25 — MYSQL USERS & PERMISSIONS
------------------------------------
301. Database Users
302. CREATE USER
303. ALTER USER
304. DROP USER
305. GRANT
306. REVOKE
307. SHOW GRANTS
308. User Privileges
309. Database-level Permissions
310. Table-level Permissions


LEVEL 26 — BACKUP & RESTORE
---------------------------
311. Database Backup
312. mysqldump
313. Database Restore
314. Import SQL File
315. Export SQL File
316. CSV Import
317. CSV Export
318. Backup Strategy


LEVEL 27 — MYSQL ADMINISTRATION
-------------------------------
319. MySQL Server
320. MySQL Configuration
321. Database Storage
322. Connection Management
323. Processlist
324. Server Status
325. Slow Query Log
326. Error Log
327. Basic Monitoring


LEVEL 28 — SECURITY
-------------------
328. SQL Injection কী
329. SQL Injection Prevention
330. Prepared Statements
331. Parameterized Queries
332. Password Storage Concepts
333. Least Privilege
334. User Permissions
335. Secure Database Design


LEVEL 29 — MYSQL WITH PHP / APPLICATION
---------------------------------------
336. PHP + MySQL Connection
337. PDO
338. MySQLi
339. Prepared Statements
340. INSERT from PHP
341. SELECT from PHP
342. UPDATE from PHP
343. DELETE from PHP
344. Fetching Multiple Rows
345. JOIN Queries from PHP
346. Transactions from PHP
347. Error Handling


LEVEL 30 — REAL-WORLD DATABASE PROJECTS
---------------------------------------

PROJECT 1 — STUDENT MANAGEMENT SYSTEM

Tables:
- students
- courses
- enrollments
- teachers
- departments

Practice:
- CRUD
- JOIN
- GROUP BY
- HAVING
- Foreign Keys
- Reports


PROJECT 2 — E-COMMERCE DATABASE

Tables:
- users
- products
- categories
- orders
- order_items
- payments
- addresses

Practice:
- Product management
- Order management
- Customer reports
- Sales reports
- JOIN
- Transactions
- Indexing


PROJECT 3 — BLOG / CMS DATABASE

Tables:
- users
- posts
- categories
- tags
- post_tags
- comments

Practice:
- Many-to-Many
- JOIN
- Search
- Filtering
- Reporting


PROJECT 4 — MUSIC / ROYALTY DATABASE

Tables:
- artists
- labels
- releases
- tracks
- aggregators
- royalty_reports
- royalty_transactions
- territories
- platforms

Practice:
- Large datasets
- Aggregation
- JOIN
- CTE
- Window Functions
- Reporting
- Indexing
- Query Optimization


FINAL STAGE — DATABASE ANALYTICS
--------------------------------
- Complex SQL Queries
- Advanced JOIN
- Advanced Subqueries
- CTE
- Window Functions
- Data Cleaning
- Data Aggregation
- Reporting Queries
- Performance Optimization
- Large Dataset Handling
- Real-world Database Design
- SQL Interview Problems
- SQL Practice Problems
- Database Project Design
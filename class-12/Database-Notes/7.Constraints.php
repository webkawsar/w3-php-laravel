
// Constraints
PRIMARY KEY
NOT NULL
UNIQUE
DEFAULT
CHECK
FOREIGN KEY


CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    age TINYINT UNSIGNED CHECK (age <= 99),
    status VARCHAR(20) DEFAULT 'active'
);


// Existing Table-এ Constraint যোগ করা
ALTER TABLE students
ADD UNIQUE (email);



// Foreign Key
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_name VARCHAR(100),
    FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE CASCADE
);



// MySQL Transaction


START TRANSACTION ==> INSERT/UPDATE/DELETE ==> COMMIT/COMMIT

Transaction-এর ACID Properties:
Atomicity
Consistency
Isolation
Durability

CREATE TABLE transaction_demo (
    id INT PRIMARY KEY,
    name VARCHAR(50),
    age INT
) ENGINE = InnoDB;

INSERT INTO transaction_demo (id, name, age)
VALUES (1, 'Rahim', 20);











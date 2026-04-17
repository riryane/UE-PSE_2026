CREATE DATABASE db_pse;

CREATE TABLE employee (
    id              INT           AUTO_INCREMENT PRIMARY KEY,
    employee_number VARCHAR(255)  NOT NULL UNIQUE,
    employee_name   VARCHAR(255)  NOT NULL,
    department_name VARCHAR(255)  NOT NULL,
    date_hired      DATE          NOT NULL,
    employment_type VARCHAR(255)  NOT NULL,
    daily_rate      DECIMAL(10,2) NOT NULL
);
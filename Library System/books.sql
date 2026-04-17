CREATE DATABASE db_pse;

CREATE TABLE books (
    id      INT           AUTO_INCREMENT PRIMARY KEY,
    book_id VARCHAR(255)  NOT NULL UNIQUE,
    title   VARCHAR(255)  NOT NULL,
    author  VARCHAR(255)  NOT NULL,
    genre   VARCHAR(255)  NOT NULL,
    copies  INT           NOT NULL
);

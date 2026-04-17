CREATE DATABASE db_pse;

CREATE TABLE items (
    id               INT           AUTO_INCREMENT PRIMARY KEY,
    item_description VARCHAR(255)  NOT NULL,
    price            DECIMAL(10,2) NOT NULL
);

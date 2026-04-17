CREATE DATABASE db_pse;

CREATE TABLE drugs (
    id               INT           AUTO_INCREMENT PRIMARY KEY,
    drug_id          VARCHAR(255)  NOT NULL UNIQUE,
    drug_description VARCHAR(255)  NOT NULL,
    dosage           VARCHAR(255)  NOT NULL,
    batch_date       DATE          NOT NULL,
    expiration_date  DATE          NOT NULL,
    price            DECIMAL(10,2) NOT NULL
);

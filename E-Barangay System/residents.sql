CREATE DATABASE db_pse;

CREATE TABLE residents (
    id            INT          AUTO_INCREMENT PRIMARY KEY,
    number        VARCHAR(255) NOT NULL UNIQUE,
    last_name     VARCHAR(255) NOT NULL,
    first_name    VARCHAR(255) NOT NULL,
    middle_name   VARCHAR(255) NULL,
    date_of_birth DATE         NOT NULL,
    house_number  INT          NOT NULL,
    street_name   VARCHAR(255) NOT NULL,
    barangay_name VARCHAR(255) NOT NULL,
    zip_code      INT          NOT NULL,
    city_name     VARCHAR(255) NOT NULL,
    type          VARCHAR(255) NOT NULL
);

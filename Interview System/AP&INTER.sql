CREATE DATABASE db_pse;

CREATE TABLE applicants (
    id             INT          AUTO_INCREMENT PRIMARY KEY,
    application_no VARCHAR(255) NOT NULL UNIQUE,
    last_name      VARCHAR(255) NOT NULL,
    first_name     VARCHAR(255) NOT NULL,
    middle_name    VARCHAR(255) NULL,
    position       VARCHAR(255) NOT NULL,
    department     VARCHAR(255) NOT NULL,
    date_applied   DATE         NOT NULL,
    contact_no     VARCHAR(255) NULL,
    email          VARCHAR(255) NULL,
    status         VARCHAR(255) NOT NULL DEFAULT 'Pending'
);

CREATE TABLE interviews (
    id                  INT          AUTO_INCREMENT PRIMARY KEY,
    application_no      VARCHAR(255) NOT NULL,
    interview_date_time DATETIME     NOT NULL,
    interview_type      VARCHAR(255) NOT NULL,
    interviewer_name    VARCHAR(255) NOT NULL,
    round               VARCHAR(255) NOT NULL,
    result              VARCHAR(255) NOT NULL,
    remarks             TEXT         NOT NULL,
    bg_check            VARCHAR(255) NOT NULL,
    docs_verified       VARCHAR(255) NOT NULL,
    FOREIGN KEY (application_no) REFERENCES applicants(application_no)
);

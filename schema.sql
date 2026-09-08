CREATE DATABASE IF NOT EXISTS helpdesk;

use helpdesk;

CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL ,
    email VARCHAR(255) NOT NULL
);
<?php

$create_database = "CREATE DATABASE quanlybansach";

$create_table = "CREATE TABLE products(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    price INT,
    avatar VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP
)";
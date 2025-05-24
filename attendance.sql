CREATE DATABASE IF NOT EXISTS attendance_system;
USE attendance_system;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE,
    status ENUM('present', 'absent'),
    FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Default login: admin / admin123
INSERT INTO users (username, password) VALUES ('admin', MD5('admin123'));

INSERT INTO students (name) VALUES
('Alice Johnson'),
('Bob Smith'),
('Charlie Lee'),
('Diana Patel'),
('Ethan Brown');
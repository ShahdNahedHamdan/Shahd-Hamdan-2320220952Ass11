

CREATE DATABASE student_db;
USE student_db;
CREATE TABLE students (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
major VARCHAR(100) NOT NULL
);
INSERT INTO students (name, email, major) VALUES
('أحمد مصطفى', 'ahmed@example.com', 'هندسة أنظمة ذكية'),
('سارة علي', 'sara@example.com', 'علم الحاسوب'),
('محمود حسن', 'mahmoud@example.com', 'هندسة البرمجيات'),
('محمد خضر', 'mohmmad@example.com','تكنولوجيا  المعلوماتْ');
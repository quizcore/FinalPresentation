DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS admin;

CREATE TABLE IF NOT EXISTS questions (
    question_id INT AUTO_INCREMENT,
    difficulty INT NOT NULL,
    question_body VARCHAR(500) NOT NULL,
    answer_1 VARCHAR(200) NOT NULL,
    answer_2 VARCHAR(200) NOT NULL,
    answer_3 VARCHAR(200) NOT NULL,
    answer_4 VARCHAR(200) NOT NULL,
    question_answer INT NOT NULL,
    PRIMARY KEY (question_id)
);

CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT NOT NULL,
    sid VARCHAR(20),
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    date_quiz_taken DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    expected_term VARCHAR(20),
    previous_education VARCHAR(100),
    previous_classes VARCHAR(300),
    score INT,
    recommendation INT,
    PRIMARY KEY (student_id)
);

CREATE TABLE IF NOT EXISTS quiz (
    quiz_id INT AUTO_INCREMENT,
    student_id INT NOT NULL,
    question_id INT NOT NULL,
    PRIMARY KEY (quiz_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);

CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT NOT NULL,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(60) NOT NULL,
    PRIMARY KEY (admin_id)
);

CREATE TABLE IF NOT EXISTS contact (
    contact_id INT AUTO_INCREMENT NOT NULL,
    contact_name VARCHAR(80) NOT NULL,
    contact_email VARCHAR(40) NOT NULL,
    contact_message VARCHAR(300) NOT NULL,
    PRIMARY KEY (contact_id)
);

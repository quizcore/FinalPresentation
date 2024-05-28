-- -- Query quiz answers of student with student_id = 1
-- SELECT q.question_id, 
--        q.question_body, 
--        q.answer_1, 
--        q.answer_2, 
--        q.answer_3, 
--        q.answer_4, 
--        q.question_answer, 
--        quiz.selected_answer
-- FROM quiz
-- INNER JOIN questions q ON quiz.question_id = q.question_id
-- WHERE quiz.student_id = 1
-- ORDER BY q.difficulty, q.question_id;

DROP 
  TABLE IF EXISTS quiz;
DROP 
  TABLE IF EXISTS questions;
DROP 
  TABLE IF EXISTS students;
DROP 
  TABLE IF EXISTS contact;
DROP 
  TABLE IF EXISTS admin;
-- questions.
CREATE TABLE IF NOT EXISTS questions(
  question_id INT AUTO_INCREMENT NOT NULL, 
  difficulty INT NOT NULL, 
  question_body VARCHAR(500) NOT NULL, 
  answer_1 VARCHAR(200) NOT NULL, 
  answer_2 VARCHAR(200) NOT NULL, 
  answer_3 VARCHAR(200) NOT NULL, 
  answer_4 VARCHAR(200) NOT NULL, 
  question_answer INT NOT NULL, 
  PRIMARY KEY(question_id)
);
-- students.
CREATE TABLE IF NOT EXISTS students(
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
  PRIMARY KEY(student_id)
);
-- quiz.
CREATE TABLE IF NOT EXISTS quiz(
  quiz_id INT AUTO_INCREMENT NOT NULL, 
  student_id INT NOT NULL, 
  question_id INT NOT NULL, 
  selected_answer INT NOT NULL, 
  PRIMARY KEY(quiz_id), 
  FOREIGN KEY(student_id) REFERENCES students(student_id), 
  FOREIGN KEY(question_id) REFERENCES questions(question_id)
);
-- admin.
CREATE TABLE IF NOT EXISTS admin(
  admin_id INT AUTO_INCREMENT NOT NULL, 
  first_name VARCHAR(40) NOT NULL, 
  last_name VARCHAR(50) NOT NULL, 
  email VARCHAR(100) UNIQUE NOT NULL, 
  PASSWORD VARCHAR(60) NOT NULL, 
  PRIMARY KEY(admin_id)
);
-- contact.
CREATE TABLE IF NOT EXISTS contact(
  contact_id INT AUTO_INCREMENT NOT NULL, 
  contact_name VARCHAR(80) NOT NULL, 
  contact_email VARCHAR(40) NOT NULL, 
  contact_message VARCHAR(300) NOT NULL, 
  PRIMARY KEY(contact_id)
);
-- Add admins.
INSERT INTO admin(
  first_name, last_name, email, PASSWORD
) 
VALUES 
  (
    "admin", 1, "admin@mail.com", "admin"
  ), 
  (
    "admin", 2, "admin2@mail.com", "admin"
  );
-- Add contacts.
INSERT INTO contact(
  contact_name, contact_email, contact_message
) 
VALUES 
  (
    'Emily White', 'emilywhite@example.com', 
    'I got power outage when taking the test. Can I redo it?'
  ), 
  (
    'Michael Green', 'michaelgreen@example.com', 
    'I entered the wrong student ID. How can I fix it?'
  ), 
  (
    'Laura Red', 'laurared@example.com', 
    'Where can I view my test result?'
  );
-- Add questions.
INSERT INTO questions(
  question_id, difficulty, question_body, 
  answer_1, answer_2, answer_3, answer_4, 
  question_answer
) 
VALUES 
  (
    1, 1, "What will be the output of the following Java code snippet?
```java
int x = 5;
int y = 3;
System.out.println(x + y * 2);
```", 
    "11", "16", "13", "15", 0
  ), 
  (
    2, 1, "What does the following Java code snippet do?
```java
int i = 0;
while (i < 5) {
  System.out.print(i + "" "");
  i++;
}
```", 
    "Prints numbers from 0 to 4 with space separation", 
    "Prints numbers from 1 to 5 with space separation", 
    " Prints numbers from 0 to 5 with space separation ", 
    "Infinite loop", 0
  ), 
  (
    3, 1, "What is the output of the following Java code snippet?
```java
int num = -5;
if (num > 0) {
  System.out.println(""Positive"");
} else {
  System.out.println(""Negative"");
}
```", 
    "Positive", "Negative", "-5", "Error", 
    1
  ), 
  (
    4, 1, "What does the following Java code snippet do?
```java
for (int i = 0; i < 5; i++) {
  System.out.println(i * 2 + "" "");
}
```", 
    "Prints even numbers from 0 to 8 with space seraration", 
    "Prints odd numbers from 1 to 9 with space separation", 
    "Prints numbers from 0 to 8 with space separation", 
    "Infinite loop", 0
  ), 
  (
    5, 1, "What will be the value of **result** in the following Java code snippet?
```java
int x = 5;
int y = 2;
int result = x % y;
```", 
    "1", "2", "3", "0", 0
  ), 
  (
    6, 2, "Which of the following Java code snippets correctly computes the sum of two integers a and b?", 
    "`int sum = a - b;`", "`int sum = a * b;`", 
    "`int sum = a / b;`", "`int sum = a + b;`", 
    3
  ), 
  (
    7, 2, "What is the result of the following Java code snippet?
```java
int x = 10;
int y = 3;
int result = x % y;
```", 
    "1", "2", "3", "0", 0
  ), 
  (
    8, 2, "Which Java code snippet correctly implements a conditional structure to determine if a number num is even?", 
    "```java
if (num % 2 == 0) {
  System.out.println(""Even"");
} else {
  System.out.println(""Odd"");
}
```", 
    "```java
if (num / 2 == 0) {
  System.out.println(""Even"");
} else {
  System.out.println(""Odd"");
}
```", 
    "```java
if (num == 0) {
  System.out.println(""Even"");
} else {
  System.out.println(""Odd"");
}
```", 
    "```java
if (num % 2 != 0) {
  System.out.println(""Even"");
} else {
  System.out.println(""Odd"");
}
```", 
    0
  ), 
  (
    9, 2, "Which Java code snippet correctly implements a loop to print numbers from 1 to 5?", 
    "```java
for (int i = 1; i <= 5; i++) {
  System.out.print(i + "" "");
}
```", 
    "```java
for (int i = 0; i < 5; i++) {
  System.out.print(i + "" "");
}
```", 
    "```java
for (int i = 1; i <= 6; i++) {
  System.out.print(i + "" "");
}
```", 
    "```java
for (int i = 0; i <= 5; i++) {
  System.out.print(i + "" "");
}
```", 
    0
  ), 
  (
    10, 2, "What does the following Java code snippet do?
```java
int i = 0;
while (i < 5) {
  System.out.print(i * 2 + "" "");
  i++;
}
```", 
    "Prints numbers from 0 to 4 with space separation", 
    "Prints even numbers from 0 to 8 with space separation", 
    "Prints numbers from 0 to 8 with space separation", 
    "Infinite loop", 1
  ), 
  (
    11, 3, "Which keyword is used to define a class in Java?", 
    "class", "void", "public", "static", 
    0
  ), 
  (
    12, 3, "What is the purpose of a constructor in Java?", 
    "To create objects", "To initialize variables", 
    "To define methods", "To perform arithmetic operations", 
    0
  ), 
  (
    13, 3, "Which of the following statements is true about Java constructors?", 
    "Constructors can have a return type", 
    "Constructors can be inherited", 
    "Constructors can be overloaded", 
    "Constructors can be declared static", 
    2
  ), 
  (
    14, 3, "Which of the following correctly defines a method named calculateArea in a Java class?", 
    "`int calculateArea() { }`", "`void calculateArea() { }`", 
    "`calculateArea() { }`", "`public int calculateArea() { }`", 
    3
  ), 
  (
    15, 3, "What does the following Java code snippet do?
```java
public class Rectangle {
  int length;
  int width;

  public Rectangle(int l, int w) {
    length = l;
    width = w;
  }

  public int calculateArea() {
    return length * width;
  }
}
```", 
    "Defines a class named Rectangle with length and width attributes and a method to calculate the area", 
    "Defines a method named Rectangle with parameters length and width", 
    "Creates an object of the Rectangle class", 
    "Initializes length and width variables", 
    0
  ), 
  (
    16, 4, "Which of the following correctly declares an array of integers named numbers in Java?", 
    "int[] numbers;", "numbers[];", 
    "int numbers[];", "array<int> numbers;", 
    0
  ), 
  (
    17, 4, "What is the correct syntax to access the third element of an array named arr in Java?", 
    "arr[2];", "arr[3];", "arr(3);", 
    "arr.get(3);", 0
  ), 
  (
    18, 4, "What does the following Java code snippet do?
```java
int[] numbers = {1, 2, 3, 4, 5};
int sum = 0;
for (int i = 0; i < numbers.length; i++) {
  sum += numbers[i];
}
```", 
    "Finds the average of the numbers in the array", 
    "Computes the product of the numbers in the array", 
    "Calculates the sum of the numbers in the array", 
    "Prints the length of the array", 
    2
  ), 
  (
    19, 4, "Which of the following statements correctly creates an array of String objects named names in Java?", 
    "`String[] names = new String();`", 
    "`String names[] = new String();`", 
    "`String[] names = new String[5];`", 
    "`String names[] = new String[5];`", 
    0
  ), 
  (
    20, 4, "What is the purpose of the length property of an array in Java?", 
    "It stores the number of elements in the array", 
    "It stores the capacity of the array", 
    "It stores the size of the array", 
    "It stores the index of the last element in the array", 
    2
  ), 
  (
    21, 5, "Which of the following best describes inheritance in Java?", 
    "Inheritance allows a class to inherit properties and behaviors from another class", 
    "Inheritance allows a class to have multiple parent classes", 
    "Inheritance allows a class to override all methods of the superclass", 
    "Inheritance allows a subclass to access private members of the superclass", 
    0
  ), 
  (
    22, 5, "What is the purpose of encapsulation in Java?", 
    "Encapsulation allows a class to inherit properties and behaviors from another class", 
    "Encapsulation allows data to be hidden and accessed only through the methods of a class", 
    "Encapsulation allows a class to have multiple parent classes", 
    "Encapsulation allows a subclass to access private members of the superclass", 
    1
  ), 
  (
    23, 5, "Which of the following statements is true about polymorphism in Java?", 
    "Polymorphism allows a class to have multiple parent classes", 
    "Polymorphism allows a subclass to access private members of the superclass", 
    "Polymorphism allows a method to have multiple implementations based on the object it is called with", 
    "Polymorphism allows a class to inherit properties and behaviors from another class", 
    2
  ), 
  (
    24, 5, "What is method overriding in Java?", 
    "Method overriding allows a subclass to provide a specific implementation of a method that is already defined in its superclass", 
    "Method overriding allows a subclass to hide a method from its superclass", 
    "Method overriding allows a subclass to access private members of its superclass", 
    "Method overriding allows a subclass to have multiple parent classes", 
    0
  ), 
  (
    25, 5, "Which keyword is used to indicate that a method can be overridden by a subclass in Java?", 
    "override", "virtual", "extends", 
    "inherit", 2
  ), 
  (
    26, 6, "What Java library is commonly used for creating graphical user interfaces (GUIs)?", 
    "JavaFX", "Swing", "AWT", "JavaGUI", 
    0
  ), 
  (
    27, 6, "What is an event-driven program?", 
    "A program that runs continuously without any user interaction", 
    "A program that responds to user actions or events", 
    "A program that executes only once and terminates", 
    "A program that generates random events", 
    1
  ), 
  (
    28, 6, "Which of the following components is commonly used to handle user input in a Java GUI?", 
    "JLabel", "JButton", "JTable", "JTextArea", 
    3
  ), 
  (
    29, 6, "What is the purpose of an ActionListener in Java GUI programming?", 
    "To define the layout of the GUI components", 
    "To handle mouse events such as clicks", 
    "To handle keyboard events such as key presses", 
    "To define the appearance of the GUI components", 
    1
  ), 
  (
    30, 6, "Which of the following statements is true about event handling in Java GUI programming?", 
    "Each GUI component handles its own events", 
    "All events in a Java GUI program are handled by a single event handler", 
    "Events in Java GUI programming are handled asynchronously", 
    "Event handling in Java GUI programming is not supported", 
    2
  ), 
  (
    31, 7, "What is the purpose of file handling in Java?", 
    "To store data in memory", "To retrieve data from databases", 
    "To read and write data to external files", 
    "To perform arithmetic operations", 
    2
  ), 
  (
    32, 7, "Which Java class is commonly used for reading text from external files?", 
    "FileReader", "FileWriter", "BufferedReader", 
    "BufferedWriter", 2
  ), 
  (
    33, 7, "What is the purpose of the File class in Java file handling?", 
    "To create a new file", "To delete a file", 
    "To represent a file or directory path", 
    "To open a file for reading", 2
  ), 
  (
    34, 7, "Which Java code snippet correctly opens a file named ""data.txt"" for reading?", 
    "`File file = new File(""data.txt"");`", 
    "`FileReader fileReader = new FileReader(""data.txt"");`", 
    "`BufferedReader reader = new BufferedReader(new FileReader(""data.txt""));`", 
    "`FileInputStream fis = new FileInputStream(""data.txt"");`", 
    3
  ), 
  (
    35, 7, "What is the purpose of the write method in the BufferedWriter class in Java?", 
    "To read data from a file", "To write data to a file", 
    "To delete a file", "To close a file", 
    1
  );
-- Insert student 1.
INSERT INTO students(
  sid, first_name, last_name, dob, date_quiz_taken, 
  email, expected_term, previous_education, 
  previous_classes, score, recommendation
) 
VALUES 
  (
    '123456', 'John', 'Doe', '2000-01-01', 
    '2024-05-28', 'john.doe@example.com', 
    'Summer2024', 'Highline College', 
    'CS110', 0, 101
  );
-- Insert quiz attempts in CS110.
INSERT INTO quiz(
  student_id, question_id, selected_answer
) 
VALUES 
  -- Level 1.
  (1, 1, 2), 
  (1, 2, 3), 
  (1, 3, 1), 
  (1, 4, 0), 
  (1, 5, 2), 
  -- Level 2.
  (1, 6, 1), 
  (1, 7, 3), 
  (1, 8, 2), 
  (1, 9, 0), 
  (1, 10, 1), 
-- Level 3.
  (1, 11, 2), 
  (1, 12, 0), 
  (1, 13, 3), 
  (1, 14, 1), 
  (1, 15, 2);
-- Insert quiz attempts in CS111.
INSERT INTO quiz(
  student_id, question_id, selected_answer
) 
VALUES  
  -- Level 4.
  (1, 16, 1), 
  (1, 17, 2), 
  (1, 18, 3), 
  (1, 19, 0), 
  (1, 20, 1), 
  -- Level 5.
  (1, 21, 3), 
  (1, 22, 2), 
  (1, 23, 0), 
  (1, 24, 1), 
  (1, 25, 3), 
  -- Level 6
  (1, 26, 0), 
  (1, 27, 3), 
  (1, 28, 2), 
  (1, 29, 1), 
  (1, 30, 0), 
  -- Level 7.
  (1, 31, 1), 
  (1, 32, 2), 
  (1, 33, 3), 
  (1, 34, 0), 
  (1, 35, 1);

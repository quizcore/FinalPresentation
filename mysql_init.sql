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
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    1,
    1,
    "What will be the output of the following Java code snippet?
```java
int x = 5;
int y = 3;
System.out.println(x + y * 2);
```",
    "11",
    "16",
    "13",
    "15",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    2,
    1,
    "What does the following Java code snippet do?
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
    "Infinite loop",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    3,
    1,
    "What is the output of the following Java code snippet?
```java
int num = -5;
if (num > 0) {
	System.out.println(""Positive"");
} else {
	System.out.println(""Negative"");
}
```",
    "Positive",
    "Negative",
    "-5",
    "Error",
    1
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    4,
    1,
    "What does the following Java code snippet do?
```java
for (int i = 0; i < 5; i++) {
	System.out.println(i * 2 + "" "");
}
```",
    "Prints even numbers from 0 to 8 with space seraration",
    "Prints odd numbers from 1 to 9 with space separation",
    "Prints numbers from 0 to 8 with space separation",
    "Infinite loop",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    5,
    1,
    "What will be the value of **result** in the following Java code snippet?
```java
int x = 5;
int y = 2;
int result = x % y;
```",
    "1",
    "2",
    "3",
    "0",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    6,
    2,
    "Which of the following Java code snippets correctly computes the sum of two integers a and b?",
    "`int sum = a - b;`",
    "`int sum = a * b;`",
    "`int sum = a / b;`",
    "`int sum = a + b;`",
    3
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    7,
    2,
    "What is the result of the following Java code snippet?
```java
int x = 10;
int y = 3;
int result = x % y;
```",
    "1",
    "2",
    "3",
    "0",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    8,
    2,
    "Which Java code snippet correctly implements a conditional structure to determine if a number num is even?",
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
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    9,
    2,
    "Which Java code snippet correctly implements a loop to print numbers from 1 to 5?",
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
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    10,
    2,
    "What does the following Java code snippet do?
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
    "Infinite loop",
    1
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    11,
    3,
    "Which keyword is used to define a class in Java?",
    "class",
    "void",
    "public",
    "static",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    12,
    3,
    "What is the purpose of a constructor in Java?",
    "To create objects",
    "To initialize variables",
    "To define methods",
    "To perform arithmetic operations",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    13,
    3,
    "Which of the following statements is true about Java constructors?",
    "Constructors can have a return type",
    "Constructors can be inherited",
    "Constructors can be overloaded",
    "Constructors can be declared static",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    14,
    3,
    "Which of the following correctly defines a method named calculateArea in a Java class?",
    "`int calculateArea() { }`",
    "`void calculateArea() { }`",
    "`calculateArea() { }`",
    "`public int calculateArea() { }`",
    3
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    15,
    3,
    "What does the following Java code snippet do?
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
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    16,
    4,
    "Which of the following correctly declares an array of integers named numbers in Java?",
    "int[] numbers;",
    "numbers[];",
    "int numbers[];",
    "array<int> numbers;",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    17,
    4,
    "What is the correct syntax to access the third element of an array named arr in Java?",
    "arr[2];",
    "arr[3];",
    "arr(3);",
    "arr.get(3);",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    18,
    4,
    "What does the following Java code snippet do?
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
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    19,
    4,
    "Which of the following statements correctly creates an array of String objects named names in Java?",
    "`String[] names = new String();`",
    "`String names[] = new String();`",
    "`String[] names = new String[5];`",
    "`String names[] = new String[5];`",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    20,
    4,
    "What is the purpose of the length property of an array in Java?",
    "It stores the number of elements in the array",
    "It stores the capacity of the array",
    "It stores the size of the array",
    "It stores the index of the last element in the array",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    21,
    5,
    "Which of the following best describes inheritance in Java?",
    "Inheritance allows a class to inherit properties and behaviors from another class",
    "Inheritance allows a class to have multiple parent classes",
    "Inheritance allows a class to override all methods of the superclass",
    "Inheritance allows a subclass to access private members of the superclass",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    22,
    5,
    "What is the purpose of encapsulation in Java?",
    "Encapsulation allows a class to inherit properties and behaviors from another class",
    "Encapsulation allows data to be hidden and accessed only through the methods of a class",
    "Encapsulation allows a class to have multiple parent classes",
    "Encapsulation allows a subclass to access private members of the superclass",
    1
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    23,
    5,
    "Which of the following statements is true about polymorphism in Java?",
    "Polymorphism allows a class to have multiple parent classes",
    "Polymorphism allows a subclass to access private members of the superclass",
    "Polymorphism allows a method to have multiple implementations based on the object it is called with",
    "Polymorphism allows a class to inherit properties and behaviors from another class",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    24,
    5,
    "What is method overriding in Java?",
    "Method overriding allows a subclass to provide a specific implementation of a method that is already defined in its superclass",
    "Method overriding allows a subclass to hide a method from its superclass",
    "Method overriding allows a subclass to access private members of its superclass",
    "Method overriding allows a subclass to have multiple parent classes",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    25,
    5,
    "Which keyword is used to indicate that a method can be overridden by a subclass in Java?",
    "override",
    "virtual",
    "extends",
    "inherit",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    26,
    6,
    "What Java library is commonly used for creating graphical user interfaces (GUIs)?",
    "JavaFX",
    "Swing",
    "AWT",
    "JavaGUI",
    0
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    27,
    6,
    "What is an event-driven program?",
    "A program that runs continuously without any user interaction",
    "A program that responds to user actions or events",
    "A program that executes only once and terminates",
    "A program that generates random events",
    1
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    28,
    6,
    "Which of the following components is commonly used to handle user input in a Java GUI?",
    "JLabel",
    "JButton",
    "JTable",
    "JTextArea",
    3
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    29,
    6,
    "What is the purpose of an ActionListener in Java GUI programming?",
    "To define the layout of the GUI components",
    "To handle mouse events such as clicks",
    "To handle keyboard events such as key presses",
    "To define the appearance of the GUI components",
    1
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    30,
    6,
    "Which of the following statements is true about event handling in Java GUI programming?",
    "Each GUI component handles its own events",
    "All events in a Java GUI program are handled by a single event handler",
    "Events in Java GUI programming are handled asynchronously",
    "Event handling in Java GUI programming is not supported",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    31,
    7,
    "What is the purpose of file handling in Java?",
    "To store data in memory",
    "To retrieve data from databases",
    "To read and write data to external files",
    "To perform arithmetic operations",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    32,
    7,
    "Which Java class is commonly used for reading text from external files?",
    "FileReader",
    "FileWriter",
    "BufferedReader",
    "BufferedWriter",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    33,
    7,
    "What is the purpose of the File class in Java file handling?",
    "To create a new file",
    "To delete a file",
    "To represent a file or directory path",
    "To open a file for reading",
    2
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    34,
    7,
    "Which Java code snippet correctly opens a file named ""data.txt"" for reading?",
    "`File file = new File(""data.txt"");`",
    "`FileReader fileReader = new FileReader(""data.txt"");`",
    "`BufferedReader reader = new BufferedReader(new FileReader(""data.txt""));`",
    "`FileInputStream fis = new FileInputStream(""data.txt"");`",
    3
);
INSERT INTO questions(
    question_id,
    difficulty,
    question_body,
    answer_1,
    answer_2,
    answer_3,
    answer_4,
    question_answer
)
VALUES(
    35,
    7,
    "What is the purpose of the write method in the BufferedWriter class in Java?",
    "To read data from a file",
    "To write data to a file",
    "To delete a file",
    "To close a file",
    1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	1,
	NULL,
	"Aspen",
	"Fred",
	"2006-05-17",
	"2024-05-10",
	"aspen.fred@mail.com",
	"Fall2024",
	"UW",
	"CS100, CS110",
	9,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	2,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	3,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	4,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	5,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	6,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	8,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	11,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	1,
	15,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	2,
	"05401318",
	"Frank",
	"Tank",
	"2006-01-04",
	"2024-03-24",
	"frank.tank@mail.com",
	"Winter2024",
	NULL,
	NULL,
	4,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	1,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	3,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	4,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	5,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	6,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	7,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	8,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	9,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	10,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	12,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	13,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	14,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	2,
	15,
	3
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	3,
	"24302590",
	"Bob",
	"Bird",
	"2006-04-12",
	"2023-12-19",
	"bob.bird@mail.com",
	"Fall2024",
	"Green River College",
	"CS100",
	3,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	2,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	4,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	5,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	6,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	7,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	8,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	10,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	11,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	12,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	13,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	14,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	3,
	15,
	3
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	4,
	"96497622",
	"Ashley",
	"Green",
	"2005-06-14",
	"2024-05-03",
	"ashley.green@mail.com",
	"Fall2024",
	"WSU",
	"CS100, CS111",
	2,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	3,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	4,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	5,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	6,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	7,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	8,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	9,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	10,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	11,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	12,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	13,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	14,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	4,
	15,
	2
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	5,
	"51953727",
	"Bear",
	"Glassman",
	"2006-01-21",
	"2022-08-28",
	"bear.glassman@mail.com",
	"Fall2024",
	NULL,
	NULL,
	1,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	1,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	2,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	3,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	4,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	5,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	6,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	8,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	9,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	10,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	11,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	12,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	13,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	14,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	5,
	15,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	6,
	"88485906",
	"Jon",
	"Greg",
	"2006-05-04",
	"2024-03-11",
	"jon.greg@mail.com",
	"Fall2024",
	NULL,
	NULL,
	4,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	1,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	2,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	3,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	4,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	6,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	7,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	8,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	9,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	12,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	14,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	6,
	15,
	2
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	7,
	NULL,
	"Ava",
	"Wilson",
	"2004-11-04",
	"2022-12-05",
	"ava.wilson@mail.com",
	"Fall2023",
	NULL,
	NULL,
	9,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	2,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	4,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	6,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	8,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	9,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	10,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	11,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	7,
	15,
	0
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	8,
	NULL,
	"Olivia",
	"Walker",
	"2006-05-04",
	"2024-01-20",
	"olivia.walker@mail.com",
	"Fall2024",
	NULL,
	NULL,
	30,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	4,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	6,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	8,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	15,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	16,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	17,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	18,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	19,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	20,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	21,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	22,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	23,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	24,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	25,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	26,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	27,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	28,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	29,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	30,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	31,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	32,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	33,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	34,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	8,
	35,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	9,
	NULL,
	"Emily",
	"Chen",
	"2003-07-16",
	"2024-02-01",
	"emily.chen@mail.com",
	"Fall2025",
	"UW",
	"CS100, CS110, CS111",
	28,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	4,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	6,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	8,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	15,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	16,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	17,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	18,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	19,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	20,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	21,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	22,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	23,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	24,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	25,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	26,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	27,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	28,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	29,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	30,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	31,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	32,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	33,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	34,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	9,
	35,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	10,
	NULL,
	"Theo",
	"Johnson",
	"2004-02-11",
	"2023-11-11",
	"theo.johnson@mail.com",
	"Fall2024",
	"Highline College",
	"CS100, CS101",
	21,
	111
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	4,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	6,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	7,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	8,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	15,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	16,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	17,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	18,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	19,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	20,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	21,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	22,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	23,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	24,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	25,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	26,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	27,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	28,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	29,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	30,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	31,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	32,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	33,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	34,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	10,
	35,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	11,
	"12212486",
	"Marcus",
	"Nguyen",
	"2002-06-05",
	"2022-04-20",
	"marcus.nguyen@mail.com",
	"Spring2023",
	NULL,
	NULL,
	20,
	111
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	1,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	4,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	6,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	7,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	8,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	15,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	16,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	17,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	18,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	19,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	20,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	21,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	22,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	23,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	24,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	25,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	26,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	27,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	28,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	29,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	30,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	31,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	32,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	33,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	34,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	11,
	35,
	1
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	12,
	NULL,
	"Elijah",
	"Ramirez",
	"2004-10-12",
	"2024-03-10",
	"elijah.ramirez@mail.com",
	"Fall2024",
	"UW Tacoma",
	"CS100, CS110",
	2,
	110
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	1,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	2,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	4,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	5,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	6,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	7,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	8,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	9,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	10,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	11,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	12,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	13,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	14,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	12,
	15,
	3
);
INSERT INTO students (
	student_id,
	sid,
	first_name,
	last_name,
	dob,
	date_quiz_taken,
	email,
	expected_term,
	previous_education,
	previous_classes,
	score,
	recommendation)
VALUES (
	13,
	"14675465",
	"Sophie",
	"Reynolds",
	"2001-02-28",
	"2022-07-07",
	"sophie.reynolds@mail.com",
	"Fall2023",
	NULL,
	NULL,
	31,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	1,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	2,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	3,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	4,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	5,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	6,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	7,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	8,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	9,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	10,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	11,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	12,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	13,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	14,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	15,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	16,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	17,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	18,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	19,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	20,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	21,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	22,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	23,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	24,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	25,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	26,
	0
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	27,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	28,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	29,
	1
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	30,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	31,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	32,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	33,
	2
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	34,
	3
);
INSERT INTO quiz(
	student_id,
	question_id,
	selected_answer
) 
VALUES (
	13,
	35,
	1
);

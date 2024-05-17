CREATE TABLE IF NOT EXISTS questions(
    question_id INT UNIQUE NOT NULL,
    difficulty INT NOT NULL,
    question_body VARCHAR(500) NOT NULL,
    answer_1 VARCHAR(200) NOT NULL,
    answer_2 VARCHAR(200) NOT NULL,
    answer_3 VARCHAR(200) NOT NULL,
    answer_4 VARCHAR(200) NOT NULL,
    question_answer VARCHAR(200) NOT NULL,
    PRIMARY KEY(question_id)
); CREATE TABLE IF NOT EXISTS students(
    student_id INT AUTO_INCREMENT NOT NULL,
    sid INT,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    date_quiz_taken DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    expected_term VARCHAR(20),
    previous_education VARCHAR(100),
    previous_classes VARCHAR(300),
    question_1 VARCHAR(100),
    question_2 VARCHAR(100),
    question_3 VARCHAR(100),
    question_4 VARCHAR(100),
    question_5 VARCHAR(100),
    question_6 VARCHAR(100),
    question_7 VARCHAR(100),
    question_8 VARCHAR(200),
    question_9 VARCHAR(100),
    question_10 VARCHAR(100),
    question_11 VARCHAR(100),
    question_12 VARCHAR(100),
    question_13 VARCHAR(100),
    question_14 VARCHAR(100),
    question_15 VARCHAR(100),
    question_16 VARCHAR(100),
    question_17 VARCHAR(100),
    question_18 VARCHAR(100),
    question_19 VARCHAR(100),
    question_20 VARCHAR(100),
    question_21 VARCHAR(100),
    question_22 VARCHAR(100),
    question_23 VARCHAR(100),
    question_24 VARCHAR(100),
    question_25 VARCHAR(100),
    question_26 VARCHAR(100),
    question_27 VARCHAR(100),
    question_28 VARCHAR(100),
    question_29 VARCHAR(100),
    question_30 VARCHAR(100),
    question_31 VARCHAR(100),
    question_32 VARCHAR(100),
    question_33 VARCHAR(100),
    question_34 VARCHAR(100),
    question_35 VARCHAR(100),
    score INT,
    recommendation INT,
    PRIMARY KEY(student_id)
); CREATE TABLE IF NOT EXISTS admin(
    admin_id INT AUTO_INCREMENT NOT NULL,
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    PASSWORD VARCHAR(60) NOT NULL,
    students INT,
    PRIMARY KEY(admin_id)
); CREATE TABLE IF NOT EXISTS contact(
    contact_id INT AUTO_INCREMENT NOT NULL,
    contact_name VARCHAR(80) NOT NULL,
    contact_email VARCHAR(40) NOT NULL,
    contact_message VARCHAR(300) NOT NULL,
    PRIMARY KEY(contact_id)
); INSERT INTO admin(
    first_name,
    last_name,
    email,
    PASSWORD
)
VALUES(
    "admin",
    1,
    "admin@mail.com",
    "admin"
);
INSERT INTO admin(
    first_name,
    last_name,
    email,
    PASSWORD
)
VALUES(
    "admin",
    2,
    "admin2@mail.com",
    "admin"
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
    "What will be the output of the following Java code snippet?<br>int x = 5;<br>int y = 3;<br>System.out.println(x + y * 2);",
    "11",
    "16",
    "13",
    "15",
    "11"
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
    "What does the following Java code snippet do?<br>int i = 0;<br>while (i < 5) {<br>&emsp;System.out.print(I + &quot; &quot;);<br>&emsp;i++;<br>}",
    "Prints numbers from 0 to 4 with space separation",
    "Prints numbers from 1 to 5 with space separation",
    " Prints numbers from 0 to 5 with space separation ",
    "Infinite loop",
    "Prints numbers from 0 to 4 with space separation"
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
    "What is the output of the following Java code snippet?<br>int num = -5;<br>if (num > 0) {<br>&emsp;System.out.println(&quot;Positive&quot;);<br>} else {<br>&emsp;System.out.println(&quot;Negative&quot;);<br>}",
    "Positive",
    "Negative",
    "-5",
    "Error",
    "Negative"
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
    "What does the following Java code snippet do?<br>for (int i = 0; i < 5; i++) {<br>&emsp;System.out.println(i * 2 + &quot; &quot;);<br>}",
    "Prints even numbers from 0 to 8 with space seraration",
    "Prints odd numbers from 1 to 9 with space separation",
    "Prints numbers from 0 to 8 with space separation",
    "Infinite loop",
    "Prints even numbers from 0 to 8 with space seraration"
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
    "What will be the value of <em>result</em> in the following Java code snippet?<br>int x = 5;<br>int y = 2;<br>int result = x % y;",
    "1",
    "2",
    "3",
    "0",
    "1"
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
    "int sum = a - b;",
    "int sum = a * b;",
    "int sum = a / b;",
    "int sum = a + b;",
    "int sum = a + b;"
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
    "What is the result of the following Java code snippet?<br>int x = 10;<br>int y = 3;<br>int result = x % y;",
    "1",
    "2",
    "3",
    "0",
    "1"
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
    "if (num % 2 == 0) {<br>&emsp;System.out.println(&quot;Even&quot;);<br>} else {<br>&emsp;System.out.println(&quot;Odd&quot;);<br>}<br>",
    "if (num / 2 == 0) {<br>&emsp;System.out.println(&quot;Even&quot;);<br>} else {<br>&emsp;System.out.println(&quot;Odd&quot;);<br>}<br>",
    "if (num == 0) {<br>&emsp;System.out.println(&quot;Even&quot;);<br>} else {<br>&emsp;System.out.println(&quot;Odd&quot;);<br>}<br>",
    "if (num % 2 == 0) {<br>&emsp;System.out.println(&quot;Even&quot;);<br>} else {<br>&emsp;System.out.println(&quot;Odd&quot;);<br>}<br>",
    "1"
); -- Assuming the correct answer is answer_1 (indexing from 1)
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
    "for (int i = 1; i <= 5; i++) {<br>&emsp;System.out.print(i + &quot; &quot;);<br>}<br>",
    "for (int i = 0; i < 5; i++) {<br>&emsp;System.out.print(i + &quot; &quot;);<br>}<br>",
    "for (int i = 1; i < 6; i++) {<br>&emsp;System.out.print(i + &quot; &quot;);<br>}<br>",
    "for (int i = 0; i <= 5; i++) {<br>&emsp;System.out.print(i + &quot; &quot;);<br>}<br>",
    "1"
); -- Assuming the correct answer is answer_1 (indexing from 1)
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
    "What does the following Java code snippet do?<br>int i = 0;<br>while (i < 5) {<br>&emsp;System.out.print(i * 2 + &quot; &quot;);<br>&emsp;i++;<br>}",
    "Prints numbers from 0 to 4 with space separation",
    "Prints even numbers from 0 to 8 with space separation",
    "Prints numbers from 0 to 8 with space separation",
    "Infinite loop",
    "Prints even numbers from 0 to 8 with space separation"
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
    "class"
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
    "To create objects"
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
    "Constructors can be overloaded"
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
    "int calculateArea() { }",
    "void calculateArea() { }",
    "calculateArea() { }",
    "public int calculateArea() { }",
    "public int calculateArea() { }"
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
    "What does the following Java code snippet do?<br>public class Rectangle {<br>&emsp;int length;<br>&emsp;int width;<br><br>&emsp;public Rectangle(int l, int w) {<br>&emsp;&emsp;length = l;<br>&emsp;&emsp;width = w;<br>&emsp;}<br><br>&emsp;public int calculateArea() {<br>&emsp;&emsp;return length * width;<br>&emsp;}<br>}",
    "Defines a class named Rectangle with length and width attributes and a method to calculate the area",
    "Defines a method named Rectangle with parameters length and width",
    "Creates an object of the Rectangle class",
    "Initializes length and width variables",
    "Defines a class named Rectangle with length and width attributes and a method to calculate the area"
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
    "int[] numbers"
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
    "arr[2];"
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
    "Whatdoes the following Java code snippet do?<br>int[] numbers = {1, 2, 3, 4, 5};<br>int sum = 0;<br>for (int i = 0; i < numbers.length; i++) {<br>&emsp;sum += numbers[i];<br>}",
    "Finds the average of the numbers in the array",
    "Computes the product of the numbers in the array",
    "Calculates the sum of the numbers in the array",
    "Prints the length of the array",
    "Calculates the sum of the numbers in the array"
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
    "String[] names = new String();",
    "String names[] = new String();",
    "String[] names = new String[5];",
    "String names[] = new String[5];",
    "String[] names = new String();"
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
    "It stores the size of the array"
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
    "Inheritance allows a class to inherit properties and behaviors from another class"
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
    "Encapsulation allows data to be hidden and accessed only through the methods of a class"
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
    "Polymorphism allows a method to have multiple implementations based on the object it is called with"
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
    "Method overriding allows a subclass to provide a specific implementation of a method that is already defined in its superclass"
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
    "extends"
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
    "JavaFX"
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
    "A program that responds to user actions or events"
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
    "JTextArea"
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
    "To handle mouse events such as clicks"
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
    "Events in Java GUI programming are handled asynchronously"
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
    "To read and write data to external files"
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
    "BufferedReader"
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
    "To represent a file or directory path"
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
    "Which Java code snippet correctly opens a file named &quot;data.txt&quot; for reading?",
    "File file = new File(&quot;data.txt&quot;);",
    "FileReader fileReader = new FileReader(&quot;data.txt&quot;);",
    "BufferedReader reader = new BufferedReader(new FileReader(&quot;data.txt&quot;));",
    "FileInputStream fis = new FileInputStream(&quot;data.txt&quot;);",
    "FileInputStream fis = new FileInputStream(&quot;data.txt&quot;);"
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
    "To write data to a file"
);
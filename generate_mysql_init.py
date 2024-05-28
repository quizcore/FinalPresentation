from __future__ import annotations, division
from dataclasses import dataclass
import datetime
import random


PREAMBLE = """-- -- Query quiz answers of student with student_id = 1
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
"""


@dataclass
class Question:
    difficulty: int
    body: str
    answers: tuple[str, str, str, str]
    solution: int


QUESTIONS: list[Question] = [
    # Level 1.
    Question(
        difficulty=1,
        body="""What will be the output of the following Java code snippet?
```java
int x = 5;
int y = 3;
System.out.println(x + y * 2);
```""",
        answers=(
            "11",
            "16",
            "13",
            "15",
        ),
        solution=0,
    ),
    Question(
        difficulty=1,
        body="""What does the following Java code snippet do?
```java
int i = 0;
while (i < 5) {
\tSystem.out.print(i + " ");
\ti++;
}
```""",
        answers=(
            "Prints numbers from 0 to 4 with space separation",
            "Prints numbers from 1 to 5 with space separation",
            " Prints numbers from 0 to 5 with space separation ",
            "Infinite loop",
        ),
        solution=0,
    ),
    Question(
        difficulty=1,
        body="""What is the output of the following Java code snippet?
```java
int num = -5;
if (num > 0) {
\tSystem.out.println("Positive");
} else {
\tSystem.out.println("Negative");
}
```""",
        answers=(
            "Positive",
            "Negative",
            "-5",
            "Error",
        ),
        solution=1,
    ),
    Question(
        difficulty=1,
        body="""What does the following Java code snippet do?
```java
for (int i = 0; i < 5; i++) {
\tSystem.out.println(i * 2 + " ");
}
```""",
        answers=(
            "Prints even numbers from 0 to 8 with space seraration",
            "Prints odd numbers from 1 to 9 with space separation",
            "Prints numbers from 0 to 8 with space separation",
            "Infinite loop",
        ),
        solution=0,
    ),
    Question(
        difficulty=1,
        body="""What will be the value of **result** in the following Java code snippet?
```java
int x = 5;
int y = 2;
int result = x % y;
```""",
        answers=(
            "1",
            "2",
            "3",
            "0",
        ),
        solution=0,
    ),
    # Level 2.
    Question(
        difficulty=2,
        body="""Which of the following Java code snippets correctly computes the sum of two integers a and b?""",
        answers=(
            "`int sum = a - b;`",
            "`int sum = a * b;`",
            "`int sum = a / b;`",
            "`int sum = a + b;`",
        ),
        solution=3,
    ),
    Question(
        difficulty=2,
        body="""What is the result of the following Java code snippet?
```java
int x = 10;
int y = 3;
int result = x % y;
```""",
        answers=(
            "1",
            "2",
            "3",
            "0",
        ),
        solution=0,
    ),
    Question(
        difficulty=2,
        body="""Which Java code snippet correctly implements a conditional structure to determine if a number num is even?""",
        answers=(
            """```java
if (num % 2 == 0) {
\tSystem.out.println("Even");
} else {
\tSystem.out.println("Odd");
}
```""",
            """```java
if (num / 2 == 0) {
\tSystem.out.println("Even");
} else {
\tSystem.out.println("Odd");
}
```""",
            """```java
if (num == 0) {
\tSystem.out.println("Even");
} else {
\tSystem.out.println("Odd");
}
```""",
            """```java
if (num % 2 != 0) {
\tSystem.out.println("Even");
} else {
\tSystem.out.println("Odd");
}
```""",
        ),
        solution=0,
    ),
    Question(
        difficulty=2,
        body="""Which Java code snippet correctly implements a loop to print numbers from 1 to 5?""",
        answers=(
            """```java
for (int i = 1; i <= 5; i++) {
\tSystem.out.print(i + " ");
}
```""",
            """```java
for (int i = 0; i < 5; i++) {
\tSystem.out.print(i + " ");
}
```""",
            """```java
for (int i = 1; i <= 6; i++) {
\tSystem.out.print(i + " ");
}
```""",
            """```java
for (int i = 0; i <= 5; i++) {
\tSystem.out.print(i + " ");
}
```""",
        ),
        solution=0,
    ),
    Question(
        difficulty=2,
        body="""What does the following Java code snippet do?
```java
int i = 0;
while (i < 5) {
\tSystem.out.print(i * 2 + " ");
\ti++;
}
```""",
        answers=(
            "Prints numbers from 0 to 4 with space separation",
            "Prints even numbers from 0 to 8 with space separation",
            "Prints numbers from 0 to 8 with space separation",
            "Infinite loop",
        ),
        solution=1,
    ),
    # Level 3.
    Question(
        difficulty=3,
        body="Which keyword is used to define a class in Java?",
        answers=(
            "class",
            "void",
            "public",
            "static",
        ),
        solution=0,
    ),
    Question(
        difficulty=3,
        body="What is the purpose of a constructor in Java?",
        answers=(
            "To create objects",
            "To initialize variables",
            "To define methods",
            "To perform arithmetic operations",
        ),
        solution=0,
    ),
    Question(
        difficulty=3,
        body="Which of the following statements is true about Java constructors?",
        answers=(
            "Constructors can have a return type",
            "Constructors can be inherited",
            "Constructors can be overloaded",
            "Constructors can be declared static",
        ),
        solution=2,
    ),
    Question(
        difficulty=3,
        body="Which of the following correctly defines a method named calculateArea in a Java class?",
        answers=(
            "`int calculateArea() { }`",
            "`void calculateArea() { }`",
            "`calculateArea() { }`",
            "`public int calculateArea() { }`",
        ),
        solution=3,
    ),
    Question(
        difficulty=3,
        body="""What does the following Java code snippet do?
```java
public class Rectangle {
\tint length;
\tint width;

\tpublic Rectangle(int l, int w) {
\t\tlength = l;
\t\twidth = w;
\t}

\tpublic int calculateArea() {
\t\treturn length * width;
\t}
}
```""",
        answers=(
            "Defines a class named Rectangle with length and width attributes and a method to calculate the area",
            "Defines a method named Rectangle with parameters length and width",
            "Creates an object of the Rectangle class",
            "Initializes length and width variables",
        ),
        solution=0,
    ),
    # Level 4.
    Question(
        difficulty=4,
        body="Which of the following correctly declares an array of integers named numbers in Java?",
        answers=(
            "int[] numbers;",
            "numbers[];",
            "int numbers[];",
            "array<int> numbers;",
        ),
        solution=0,
    ),
    Question(
        difficulty=4,
        body="What is the correct syntax to access the third element of an array named arr in Java?",
        answers=(
            "arr[2];",
            "arr[3];",
            "arr(3);",
            "arr.get(3);",
        ),
        solution=0,
    ),
    Question(
        difficulty=4,
        body="""What does the following Java code snippet do?
```java
int[] numbers = {1, 2, 3, 4, 5};
int sum = 0;
for (int i = 0; i < numbers.length; i++) {
\tsum += numbers[i];
}
```""",
        answers=(
            "Finds the average of the numbers in the array",
            "Computes the product of the numbers in the array",
            "Calculates the sum of the numbers in the array",
            "Prints the length of the array",
        ),
        solution=2,
    ),
    Question(
        difficulty=4,
        body="Which of the following statements correctly creates an array of String objects named names in Java?",
        answers=(
            "`String[] names = new String();`",
            "`String names[] = new String();`",
            "`String[] names = new String[5];`",
            "`String names[] = new String[5];`",
        ),
        solution=0,
    ),
    Question(
        difficulty=4,
        body="What is the purpose of the length property of an array in Java?",
        answers=(
            "It stores the number of elements in the array",
            "It stores the capacity of the array",
            "It stores the size of the array",
            "It stores the index of the last element in the array",
        ),
        solution=2,
    ),
    # Level 5.
    Question(
        difficulty=5,
        body="Which of the following best describes inheritance in Java?",
        answers=(
            "Inheritance allows a class to inherit properties and behaviors from another class",
            "Inheritance allows a class to have multiple parent classes",
            "Inheritance allows a class to override all methods of the superclass",
            "Inheritance allows a subclass to access private members of the superclass",
        ),
        solution=0,
    ),
    Question(
        difficulty=5,
        body="What is the purpose of encapsulation in Java?",
        answers=(
            "Encapsulation allows a class to inherit properties and behaviors from another class",
            "Encapsulation allows data to be hidden and accessed only through the methods of a class",
            "Encapsulation allows a class to have multiple parent classes",
            "Encapsulation allows a subclass to access private members of the superclass",
        ),
        solution=1,
    ),
    Question(
        difficulty=5,
        body="Which of the following statements is true about polymorphism in Java?",
        answers=(
            "Polymorphism allows a class to have multiple parent classes",
            "Polymorphism allows a subclass to access private members of the superclass",
            "Polymorphism allows a method to have multiple implementations based on the object it is called with",
            "Polymorphism allows a class to inherit properties and behaviors from another class",
        ),
        solution=2,
    ),
    Question(
        difficulty=5,
        body="What is method overriding in Java?",
        answers=(
            "Method overriding allows a subclass to provide a specific implementation of a method that is already defined in its superclass",
            "Method overriding allows a subclass to hide a method from its superclass",
            "Method overriding allows a subclass to access private members of its superclass",
            "Method overriding allows a subclass to have multiple parent classes",
        ),
        solution=0,
    ),
    Question(
        difficulty=5,
        body="Which keyword is used to indicate that a method can be overridden by a subclass in Java?",
        answers=(
            "override",
            "virtual",
            "extends",
            "inherit",
        ),
        solution=2,
    ),
    # Level 6.
    Question(
        difficulty=6,
        body="What Java library is commonly used for creating graphical user interfaces (GUIs)?",
        answers=(
            "JavaFX",
            "Swing",
            "AWT",
            "JavaGUI",
        ),
        solution=0,
    ),
    Question(
        difficulty=6,
        body="What is an event-driven program?",
        answers=(
            "A program that runs continuously without any user interaction",
            "A program that responds to user actions or events",
            "A program that executes only once and terminates",
            "A program that generates random events",
        ),
        solution=1,
    ),
    Question(
        difficulty=6,
        body="Which of the following components is commonly used to handle user input in a Java GUI?",
        answers=(
            "JLabel",
            "JButton",
            "JTable",
            "JTextArea",
        ),
        solution=3,
    ),
    Question(
        difficulty=6,
        body="What is the purpose of an ActionListener in Java GUI programming?",
        answers=(
            "To define the layout of the GUI components",
            "To handle mouse events such as clicks",
            "To handle keyboard events such as key presses",
            "To define the appearance of the GUI components",
        ),
        solution=1,
    ),
    Question(
        difficulty=6,
        body="Which of the following statements is true about event handling in Java GUI programming?",
        answers=(
            "Each GUI component handles its own events",
            "All events in a Java GUI program are handled by a single event handler",
            "Events in Java GUI programming are handled asynchronously",
            "Event handling in Java GUI programming is not supported",
        ),
        solution=2,
    ),
    # Level 7.
    Question(
        difficulty=7,
        body="What is the purpose of file handling in Java?",
        answers=(
            "To store data in memory",
            "To retrieve data from databases",
            "To read and write data to external files",
            "To perform arithmetic operations",
        ),
        solution=2,
    ),
    Question(
        difficulty=7,
        body="Which Java class is commonly used for reading text from external files?",
        answers=(
            "FileReader",
            "FileWriter",
            "BufferedReader",
            "BufferedWriter",
        ),
        solution=2,
    ),
    Question(
        difficulty=7,
        body="What is the purpose of the File class in Java file handling?",
        answers=(
            "To create a new file",
            "To delete a file",
            "To represent a file or directory path",
            "To open a file for reading",
        ),
        solution=2,
    ),
    Question(
        difficulty=7,
        body="""Which Java code snippet correctly opens a file named "data.txt" for reading?""",
        answers=(
            """`File file = new File("data.txt");`""",
            """`FileReader fileReader = new FileReader("data.txt");`""",
            """`BufferedReader reader = new BufferedReader(new FileReader("data.txt"));`""",
            """`FileInputStream fis = new FileInputStream("data.txt");`""",
        ),
        solution=3,
    ),
    Question(
        difficulty=7,
        body="What is the purpose of the write method in the BufferedWriter class in Java?",
        answers=(
            "To read data from a file",
            "To write data to a file",
            "To delete a file",
            "To close a file",
        ),
        solution=1,
    ),
]


def all_correct_questions() -> list[bool | None]:
    return [True] * len(QUESTIONS)


def cs110_all_correct(wrong_indexes: list[int]) -> list[bool | None]:
    result: list[bool | None] = [True] * 15
    for i in wrong_indexes:
        result[i] = False
    return result


def cs110_all_wrong(correct_indexes: list[int]) -> list[bool | None]:
    result: list[bool | None] = [False] * 15
    for i in correct_indexes:
        result[i] = True
    return result


def cs111_all_correct(wrong_indexes: list[int]) -> list[bool | None]:
    result: list[bool | None] = [True] * 20
    for i in wrong_indexes:
        result[i] = False
    return result


def cs111_all_wrong(correct_indexes: list[int]) -> list[bool | None]:
    result: list[bool | None] = [False] * 20
    for i in correct_indexes:
        result[i] = True
    return result


@dataclass
class Student:
    sid: str | None
    first_name: str
    last_name: str
    dob: datetime.datetime
    taken_date: datetime.datetime
    email: str
    expected_term: str | None
    prev_education: str | None
    prev_classes: str | None
    cs110: list[bool | None]
    cs111: list[bool | None]


STUDENTS: list[Student] = [
    Student(
        sid=None,
        first_name="Aspen",
        last_name="Fred",
        dob=datetime.datetime(2006, 5, 17),
        taken_date=datetime.datetime(2024, 5, 10),
        email="aspen.fred@mail.com",
        expected_term="Fall2024",
        prev_education="UW",
        prev_classes="CS100, CS110",
        cs110=cs110_all_correct([1, 2, 3, 4, 10, 14]),
        cs111=[],
    ),
    Student(
        sid="05401318",
        first_name="Frank",
        last_name="Tank",
        dob=datetime.datetime(2006, 1, 4),
        taken_date=datetime.datetime(2024, 3, 24),
        email="frank.tank@mail.com",
        expected_term="Winter2024",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_wrong([1, 5, 7, 10]),
        cs111=[],
    ),
    Student(
        sid="24302590",
        first_name="Bob",
        last_name="Bird",
        dob=datetime.datetime(2006, 4, 12),
        taken_date=datetime.datetime(2023, 12, 19),
        email="bob.bird@mail.com",
        expected_term="Fall2024",
        prev_education="Green River College",
        prev_classes="CS100",
        cs110=cs110_all_wrong([0, 2, 8]),
        cs111=[],
    ),
    Student(
        sid="96497622",
        first_name="Ashley",
        last_name="Green",
        dob=datetime.datetime(2005, 6, 14),
        taken_date=datetime.datetime(2024, 5, 3),
        email="ashley.green@mail.com",
        expected_term="Fall2024",
        prev_education="WSU",
        prev_classes="CS100, CS111",
        cs110=cs110_all_wrong([0, 1]),
        cs111=[],
    ),
    Student(
        sid="51953727",
        first_name="Bear",
        last_name="Glassman",
        dob=datetime.datetime(2006, 1, 21),
        taken_date=datetime.datetime(2022, 8, 28),
        email="bear.glassman@mail.com",
        expected_term="Fall2024",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_wrong([6]),
        cs111=[],
    ),
    Student(
        sid="88485906",
        first_name="Jon",
        last_name="Greg",
        dob=datetime.datetime(2006, 5, 4),
        taken_date=datetime.datetime(2024, 3, 11),
        email="jon.greg@mail.com",
        expected_term="Fall2024",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_wrong([4, 9, 10, 12]),
        cs111=[],
    ),
    Student(
        sid=None,
        first_name="Ava",
        last_name="Wilson",
        dob=datetime.datetime(2004, 11, 4),
        taken_date=datetime.datetime(2022, 12, 5),
        email="ava.wilson@mail.com",
        expected_term="Fall2023",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_correct([1, 5, 7, 8, 9, 10]),
        cs111=[],
    ),
    Student(
        sid=None,
        first_name="Olivia",
        last_name="Walker",
        dob=datetime.datetime(2006, 5, 4),
        taken_date=datetime.datetime(2024, 1, 20),
        email="olivia.walker@mail.com",
        expected_term="Fall2024",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_correct([]),
        cs111=cs111_all_correct([1, 5, 6, 8, 10]),
    ),
    Student(
        sid=None,
        first_name="Emily",
        last_name="Chen",
        dob=datetime.datetime(2003, 7, 16),
        taken_date=datetime.datetime(2024, 2, 1),
        email="emily.chen@mail.com",
        expected_term="Fall2025",
        prev_education="UW",
        prev_classes="CS100, CS110, CS111",
        cs110=cs110_all_correct([3, 5]),
        cs111=cs111_all_correct([2, 4, 7, 9, 11]),
    ),
    Student(
        sid=None,
        first_name="Theo",
        last_name="Johnson",
        dob=datetime.datetime(2004, 2, 11),
        taken_date=datetime.datetime(2023, 11, 11),
        email="theo.johnson@mail.com",
        expected_term="Fall2024",
        prev_education="Highline College",
        prev_classes="CS100, CS101",
        cs110=cs110_all_correct([3, 5, 6, 7]),
        cs111=cs111_all_correct([1, 2, 4, 7, 9, 11, 12, 13, 14, 15]),
    ),
    Student(
        sid="12212486",
        first_name="Marcus",
        last_name="Nguyen",
        dob=datetime.datetime(2002, 6, 5),
        taken_date=datetime.datetime(2022, 4, 20),
        email="marcus.nguyen@mail.com",
        expected_term="Spring2023",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_correct([3, 5, 6, 7]),
        cs111=cs111_all_correct([1, 2, 3, 6, 7, 9, 11, 12, 13, 14, 15]),
    ),
    Student(
        sid=None,
        first_name="Elijah",
        last_name="Ramirez",
        dob=datetime.datetime(2004, 10, 12),
        taken_date=datetime.datetime(2024, 3, 10),
        email="elijah.ramirez@mail.com",
        expected_term="Fall2024",
        prev_education="UW Tacoma",
        prev_classes="CS100, CS110",
        cs110=cs110_all_wrong([2, 8]),
        cs111=[],
    ),
    Student(
        sid="14675465",
        first_name="Sophie",
        last_name="Reynolds",
        dob=datetime.datetime(2001, 2, 28),
        taken_date=datetime.datetime(2022, 7, 7),
        email="sophie.reynolds@mail.com",
        expected_term="Fall2023",
        prev_education=None,
        prev_classes=None,
        cs110=cs110_all_correct([0, 8]),
        cs111=cs111_all_correct([0, 11]),
    ),
]


def escape_mysql_string(s: str) -> str:
    escaped_chars = {
        "'": "''",
        '"': '""',
        "\\": "\\\\",
    }
    escaped_string = ""
    for char in s:
        if char in escaped_chars:
            escaped_string += escaped_chars[char]
        else:
            escaped_string += char
    return escaped_string


def add_questions_to_buf(buf: list[str], questions: list[Question]) -> None:
    for i, q in enumerate(questions, start=1):
        buf.append(
            f"""INSERT INTO questions(
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
    {i},
    {q.difficulty},
    "{escape_mysql_string(q.body)}",
    "{escape_mysql_string(q.answers[0])}",
    "{escape_mysql_string(q.answers[1])}",
    "{escape_mysql_string(q.answers[2])}",
    "{escape_mysql_string(q.answers[3])}",
    {q.solution}
);
"""
        )


def optional_str_to_sql(string: str | None) -> str:
    if string is None:
        return "NULL"
    return f'"{string}"'


def optional_int_to_sql(num: int | None) -> str:
    if num is None:
        return "NULL"
    return str(num)


def datetime_to_sql_str(my_date: datetime.datetime) -> str:
    return my_date.strftime("%Y-%m-%d")


def random_solution_excluding(exclude: int) -> int:
    if exclude not in range(4):
        raise ValueError("The number to exclude must be between 0 and 3 inclusive.")
    numbers = [0, 1, 2, 3]
    numbers.remove(exclude)
    return random.choice(numbers)


def analyze_st_answers(
    questions: list[Question], cs110: list[bool | None], cs111: list[bool | None]
) -> tuple[list[int | None], int, int]:
    score = cs110.count(True)
    recommendation = 110
    st_answers: list[int | None] = [None] * len(questions)
    for i, b in enumerate(cs110):
        q = questions[i]
        st_answers[i] = q.solution if b else random_solution_excluding(q.solution)
    if score >= 11:
        offset = 15
        for i, b in enumerate(cs111):
            q = questions[offset + i]
            st_answers[offset + i] = (
                q.solution if b else random_solution_excluding(q.solution)
            )
        score += cs111.count(True)
        if score >= 25:
            recommendation = 1
        elif score > 11:
            recommendation = 111
    return st_answers, score, recommendation


def add_students_to_buf(buf: list[str], students: list[Student]) -> None:
    for i, st in enumerate(students, start=1):
        buf.append(
            """INSERT INTO students (
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
"""
        )
        st_answers, score, recommendation = analyze_st_answers(
            QUESTIONS, st.cs110, st.cs111
        )
        buf.append(
            f"""\t{i},
\t{optional_str_to_sql(st.sid)},
\t"{st.first_name}",
\t"{st.last_name}",
\t"{datetime_to_sql_str(st.dob)}",
\t"{datetime_to_sql_str(st.taken_date)}",
\t"{st.email}",
\t{optional_str_to_sql(st.expected_term)},
\t{optional_str_to_sql(st.prev_education)},
\t{optional_str_to_sql(st.prev_classes)},
\t{score},
\t{recommendation}
);
"""
        )
        for j, a in enumerate(st_answers, start=1):
            if a is None:
                continue
            buf.append(
                f"""INSERT INTO quiz(
\tstudent_id,
\tquestion_id,
\tselected_answer
) 
VALUES (
\t{i},
\t{j},
\t{optional_int_to_sql(a)}
);
"""
            )


def main() -> None:
    buf = [PREAMBLE]
    add_questions_to_buf(buf, QUESTIONS)
    add_students_to_buf(buf, STUDENTS)
    with open("mysql_init.sql", "w") as f:
        f.write("".join(buf))


if __name__ == "__main__":
    main()

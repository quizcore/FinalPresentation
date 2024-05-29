<?php
// In the individual PHP files, check if the constant indicating the application is defined.
if (!defined('MY_APP')) {
    // If the constant is not defined, redirect the user to the homepage and terminate the script.
    header('Location: index.php');
    exit;
}

// functions.php

function prepareScriptInput($text)
{
    return str_replace('`', '\\`', $text);
}

function displayQuestions($rows)
{
    // Store the question IDs in the session variable
    $questionIDs = [];

    // output data of each row
    foreach ($rows as $row) {
        $questionIDs[] = $row['question_id'];

        echo '<div class="container shadow p-3 my-5 bg-body-tertiary rounded fs-5">';
        echo '<div id="question-body-' . $row["question_id"] . '">';
        echo '  <script>document.getElementById("question-body-'  . $row["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($row["question_body"]) . '`);</script>';
        echo '</div>';

        $answers = ['0' => $row["answer_1"], '1' => $row["answer_2"], '2' => $row["answer_3"], '3' => $row["answer_4"]];
        foreach ($answers as $key => $answer) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="' . $row["question_id"] . '-' . $key . '" name="' . $row["question_id"] . '" value="' . $key . '" required>';
            echo '<div id="display-' . $row["question_id"] . '-' . $key . '">';
            echo '  <script>document.getElementById("display-'  . $row["question_id"] . '-' . $key . '").innerHTML=marked.parse(`' . prepareScriptInput($answer) . '`);</script>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    }

    $_SESSION['quiz_question_ids'] = $questionIDs;
}

// Function to generate a Bootstrap progress bar
function generateProgressBar($width = 25)
{
    $progressBar = "
        <div class='container shadow p-3 my-5 bg-body-tertiary rounded'>
            <div class='progress' role='progressbar' aria-label='Animated striped example' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>
                <div id='progressBars' class='progress-bar progress-bar-striped progress-bar-animated bg-danger' style='width: {$width}%'></div>
            </div>
        </div>
    ";

    return $progressBar;
}

function processStudentAnswers($conn)
{
    $email = $_COOKIE['student'];
    $studentIDSelect = "SELECT student_id FROM students WHERE email = '$email'";
    $studentIDResult = $conn->query($studentIDSelect);
    $studentID = intval($studentIDResult->fetch_assoc()["student_id"]);

    $questionIDs = $_SESSION['quiz_question_ids'];

    // Prepare the SQL statement with placeholders.
    $sql  = "INSERT INTO quiz(student_id, question_id, selected_answer) VALUES (?, ?, ?)";
    $i = 0;

    foreach ($questionIDs as $questionID) {
        // Initialize a prepared statement.
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $selectedAnswer = $_POST[$questionID];

        // Bind the parameters to the placeholders.
        $stmt->bind_param('iii', $studentID, $questionID, $selectedAnswer);

        // Execute the prepared statement.
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
        $i++;
    }
}

function checkExamSectionDone($conn, $difficulty)
{
    $studentID = getStudentID($conn);

    $diffCountQuery = "SELECT COUNT(*) AS quiz_count FROM quiz q JOIN questions qs ON q.question_id = qs.question_id WHERE q.student_id = ? AND qs.difficulty = ?";
    $diffCountStmt = $conn->prepare($diffCountQuery);
    if ($diffCountStmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $diffCountStmt->bind_param('ii', $studentID, $difficulty);
    if (!$diffCountStmt->execute()) {
        die('Execute failed: ' . $diffCountStmt->error);
    }
    $diffCountResult = $diffCountStmt->get_result();
    $diffCountStmt->close();
    $diffCount = $diffCountResult->fetch_assoc()["quiz_count"];

    if ($diffCount == 0) {
        return true;
    }

    return false;
}

function getStudentID($conn)
{
    $email = $_COOKIE['student'];
    $studentIDSelect = "SELECT student_id FROM students WHERE email = '$email'";
    $studentIDResult = $conn->query($studentIDSelect);
    return intval($studentIDResult->fetch_assoc()["student_id"]);
}

function getStudentScore($conn)
{
    $email = $_COOKIE['student'];
    $studentIDSelect = "SELECT student_id FROM students WHERE email = '$email'";
    $studentIDResult = $conn->query($studentIDSelect);
    $studentID = intval($studentIDResult->fetch_assoc()["student_id"]);

    $scoreQuery = "SELECT 
    s.student_id,
    s.first_name,
    s.last_name,
    COUNT(CASE WHEN q.selected_answer = qs.question_answer THEN 1 END) AS score
FROM 
    students s
JOIN 
    quiz q ON s.student_id = q.student_id
JOIN 
    questions qs ON q.question_id = qs.question_id
WHERE 
    s.student_id = ?
GROUP BY 
    s.student_id, s.first_name, s.last_name
";

    $scoreStmt = $conn->prepare($scoreQuery);
    if ($scoreStmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $scoreStmt->bind_param('i', $studentID);
    if (!$scoreStmt->execute()) {
        die('Execute failed: ' . $scoreStmt->error);
    }
    $scoreResult = $scoreStmt->get_result();
    $scoreStmt->close();

    $score = 0;
    while ($row = $scoreResult->fetch_assoc()) {
        $score = $row["score"];
    }

    return $score;
}

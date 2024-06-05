<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Start the session.
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}
require_once 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Sanitize the input to prevent SQL injection
    $question_id = mysqli_real_escape_string($conn, $_GET["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM questions WHERE question_id = '$question_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Output data of each row
        $row = $result->fetch_assoc();
        $question_details = array(
            'question_id' => $row['question_id'],
            'difficulty' => $row['difficulty'],
            'old_difficulty' => $row['old_difficulty'],
            'question_body' => $row['question_body'],
            'answer_1' => $row['answer_1'],
            'answer_2' => $row['answer_2'],
            'answer_3' => $row['answer_3'],
            'answer_4' => $row['answer_4'],
            'question_answer' => $row['question_answer']
        );
    } else {
        echo "Question not found";
    }
}

//disable_question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['disable_question'])) {
    $question_id = mysqli_real_escape_string($conn, $_GET["id"]);

    // Save the old difficulty in a session variable
    $_SESSION['old_difficulty'] = $question_details['difficulty'];

    $updateQuery = "UPDATE questions SET old_difficulty = difficulty, difficulty = 0 WHERE question_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $question_id);

    if ($stmt->execute()) {
        // Success message if the update is successful
        $_SESSION['success_message'] = "Question disabled successfully!";
        // Redirect to a success page
        $_SESSION['id'] = $question_id;
        $_SESSION['question-href'] = "question.php?id=";
        // Flag to indicate question has been disabled
        $_SESSION['question_disabled'] = true;
        header("Location: success.php");
        exit();
    } else {
        // Error message if the update fails
        echo "Error disabling question: " . $conn->error;
    }

    $stmt->close();
}

//enable_question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enable_question'])) {
    $question_id = mysqli_real_escape_string($conn, $_GET["id"]);

    // Set difficulty equal to old_difficulty and old_difficulty to zero
    $updateQuery = "UPDATE questions SET difficulty = old_difficulty, old_difficulty = 0 WHERE question_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $question_id);

    if ($stmt->execute()) {
        // Success message if the update is successful
        $_SESSION['success_message'] = "Question enabled successfully!";
        // Redirect to a success page
        $_SESSION['id'] = $question_id;
        $_SESSION['question-href'] = "question.php?id=";
        // Flag to indicate question has been enabled
        $_SESSION['question_enabled'] = true;
        header("Location: success.php");
        exit();
    } else {
        // Error message if the update fails
        echo "Error enabling question: " . $conn->error;
    }

    $stmt->close();
}



$pageTitle = "Question";
require_once 'header.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Question Details</h1>
    </div>
    <!-- Display Question Details -->
    <?php
    // Display the status as "Disabled" if the difficulty is zero
    $status = ($question_details['difficulty'] == 0) ? 'Disabled' : 'Enabled';

    echo "<p><strong>Status:</strong> $status</p>";

    if ($status === 'Disabled') {
        echo "<p><strong>Old Difficulty:</strong> " . $question_details['old_difficulty'] . "</p>";
    }
    echo "<p><strong>Question ID:</strong> " . $question_details['question_id'] . "</p>";
    if ($status !== 'Disabled') {
    echo "<p><strong>Difficulty:</strong> " . $question_details['difficulty'] . "</p>";
    }
    echo "<p><strong>Question Body:</strong> " . $question_details['question_body'] . "</p>";
    echo "<p><strong>Answer 1:</strong> " . $question_details['answer_1'] . "</p>";
    echo "<p><strong>Answer 2:</strong> " . $question_details['answer_2'] . "</p>";
    echo "<p><strong>Answer 3:</strong> " . $question_details['answer_3'] . "</p>";
    echo "<p><strong>Answer 4:</strong> " . $question_details['answer_4'] . "</p>";
    echo "<p><strong>Correct Answer:</strong> " . "Answer " . ($question_details['question_answer'] + 1) . "</p>";

    if ($status !== 'Disabled') {
        echo "
        <form method='POST'>
            <div class='container d-grid gap-2 d-md-grid justify-content-md-center'>
                <button type='submit' name='disable_question' class='btn btn-lg btn-bd-red'>Disable Question</button>
            </div>
        </form>";
    } else {
        echo "
        <form method='POST'>
            <div class='container d-grid gap-2 d-md-grid justify-content-md-center'>
                <button type='submit' name='enable_question' class='btn btn-lg btn-bd-red'>Enable Question</button>
            </div>
        </form>";
    }
    ?>


</main>
<?php
include_once 'footer.php'
?>
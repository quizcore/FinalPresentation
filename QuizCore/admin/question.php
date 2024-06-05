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

$pageTitle = "Question";
require_once 'header.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Question</h1>
    </div>
                <!-- Display Question Details -->
                <form id="myForm" method="post">
                    <div class="mb-3">
                        <label for="question_id" class="form-label">Question ID:</label>
                        <input type="text" class="form-control" id="question_id" name="question_id" value="<?php echo $question_details['question_id']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="question_body" class="form-label">Question Body:</label>
                        <textarea class="form-control" id="question_body" name="question_body" rows="4" required><?php echo $question_details['question_body']; ?></textarea>

                    </div>

                    <div class="mb-3">
                        <label for="answer_1" class="form-label">Answer 1:</label>
                        <input type="text" class="form-control" id="answer_1" name="answer_1" value="<?php echo $question_details['answer_1'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="answer_2" class="form-label">Answer 2:</label>
                        <input type="text" class="form-control" id="answer_2" name="answer_2" value="<?php echo $question_details['answer_2'] ?>" required>
                    </div>


                    <div class="mb-3">
                        <label for="answer_3" class="form-label">Answer 3:</label>
                        <input type="text" class="form-control" id="answer_3" name="answer_3" value="<?php echo $question_details['answer_3'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="answer_4" class="form-label">Answer 4:</label>
                        <input type="text" class="form-control" id="answer_4" name="answer_4" value="<?php echo $question_details['answer_4'] ?>" required>
                    </div>
                    <div class="mb-3">
    <label for="question_answer" class="form-label">Correct Answer:</label>
    <select class="form-select" id="question_answer" name="question_answer" required>
        <option value="1" <?php if ($question_details['question_answer'] == 0) echo "selected"; ?>>Answer 1</option>
        <option value="2" <?php if ($question_details['question_answer'] == 1) echo "selected"; ?>>Answer 2</option>
        <option value="3" <?php if ($question_details['question_answer'] == 2) echo "selected"; ?>>Answer 3</option>
        <option value="4" <?php if ($question_details['question_answer'] == 3) echo "selected"; ?>>Answer 4</option>
    </select>
</div>


                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <input type="number" class="form-control" id="difficulty" name="difficulty"  value="<?php echo $question_details['difficulty'] ?>" required>
                    </div><br />

                    <div class="container d-grid gap-2 d-md-grid justify-content-md-center">
                        <input type="submit" value="Edit" class="btn btn-lg btn-bd-red">
                    </div>

                </form>
</main>
<?php
include_once 'footer.php'
?>
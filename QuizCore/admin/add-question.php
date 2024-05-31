<?php
// // In the individual PHP files, check if the constant indicating the application is defined.
// if (!defined('MY_APP')) {
//   // If the constant is not defined, redirect the user to the homepage and terminate the script.
//   header('Location: index.php');
//   exit;
// }
?>


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

// Include the database connection file.
include_once 'dbconnection.php';

// Initialize variables with empty values
$question_body = "";
$question_body_code = "";
$answer_1 = "";
$answer_2 = "";
$answer_3 = "";
$answer_4 = "";
$question_answer = "";
$difficulty = 1; // Set default difficulty to 1

$errors = array(); // Array to store any errors

// Processing form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["question_body"]) && isset($_POST["question_body_code"]) && isset($_POST["answer_1"]) && isset($_POST["answer_2"]) && isset($_POST["answer_3"]) && isset($_POST["answer_4"])) {
  // Sanitize user input to prevent SQL injection
  $question_body = mysqli_real_escape_string($conn, $_POST["question_body"]);
  // Check if question_body_code is not empty and set it accordingly
  if (!empty($_POST["question_body_code"])) {
    $question_body_code = "\n```java\n" . mysqli_real_escape_string($conn, $_POST["question_body_code"]) . "\n```";
  } else {
    $question_body_code = "";
  }
  $answer_1 = mysqli_real_escape_string($conn, $_POST["answer_1"]);
  $answer_2 = mysqli_real_escape_string($conn, $_POST["answer_2"]);
  $answer_3 = mysqli_real_escape_string($conn, $_POST["answer_3"]);
  $answer_4 = mysqli_real_escape_string($conn, $_POST["answer_4"]);
  $question_answer = mysqli_real_escape_string($conn, $_POST["question_answer"]);
  $difficulty = isset($_POST["difficulty"]) ? (int) $_POST["difficulty"] : 1; // Set default if not set

  // Check if the checkboxes are checked and wrap answers with backticks accordingly
  $answer_1_code = isset($_POST["answer_1_code"]) ? true : false;
  $answer_2_code = isset($_POST["answer_2_code"]) ? true : false;
  $answer_3_code = isset($_POST["answer_3_code"]) ? true : false;
  $answer_4_code = isset($_POST["answer_4_code"]) ? true : false;

  // Wrap answers with backticks if checkboxes are checked
  if ($answer_1_code) {
    $answer_1 = "`" . $answer_1 . "`";
  }
  if ($answer_2_code) {
    $answer_2 = "`" . $answer_2 . "`";
  }
  if ($answer_3_code) {
    $answer_3 = "`" . $answer_3 . "`";
  }
  if ($answer_4_code) {
    $answer_4 = "`" . $answer_4 . "`";
  }

  // Check if question_body_code is not empty and append it to question_body
  if (!empty($question_body_code)) {
    $question_body .= " " . $question_body_code;
  }
  // Validate form input
  if (empty($question_body)) {
    array_push($errors, "Question body is required.");
  }
  if (trim($answer_1) === '' || trim($answer_2) === '' || trim($answer_3) === '' || trim($answer_4) === '') {
    array_push($errors, "Please provide all answer choices.");
  }
  if (empty($question_answer)) {
    array_push($errors, "Please select the correct answer.");
  }
  if (empty($difficulty)) {
    array_push($errors, "Please select the difficulty.");
  }

  // If no errors, insert question into database
  if (count($errors) == 0) {
    $sql = "INSERT INTO questions (difficulty, question_body, answer_1, answer_2, answer_3, answer_4, question_answer) VALUES ('$difficulty', '$question_body', '$answer_1', '$answer_2', '$answer_3', '$answer_4', '$question_answer')";

    if ($conn->query($sql) === TRUE) {
      $message = "Question added successfully!";
      // Clear form fields after successful submission
      $question_body = $question_body_code = $answer_1 = $answer_2 = $answer_3 = $answer_4 = $question_answer = "";
      $difficulty = 1; // Reset form values

    } else {
      array_push($errors, "Error adding question: " . $conn->error);
    }
  }
}

$pageTitle = "Add Question";
require_once 'header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Question</h1>
  </div>

  <?php
  // Display any errors
  if (count($errors) > 0) {
    echo "<div class='alert alert-danger'>";
    foreach ($errors as $error) {
      echo $error . "<br>";
    }
    echo "</div>";
  }
  ?>

  <?php
  // Display success message (if any)
  if (isset($message)) {
    echo "<div class='alert alert-success alert-dismissible show' role='alert'>" . $message . "
      <button type='button' class='btn-close' data-bs-dismiss='alert'
      aria-label='Close'></button>
      </div>";
  }
  ?>

  <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="mb-3">
      <label for="question_body" class="form-label">Question Body:</label>
      <textarea class="form-control" id="question_body" name="question_body" rows="2" required><?php echo $question_body; ?></textarea>
    </div>
    <div class="mb-3">
      <label for="question_body_code" class="form-label">Question Body Code:</label>
      <textarea class="form-control" id="question_body_code" name="question_body_code" rows="4"><?php echo $question_body_code; ?></textarea>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="answer_1_code" name="answer_1_code">
      <label class="form-check-label" for="answer_1_code">Answer 1 in code format</label>
    </div>
    <div class="mb-3">
      <label for="answer_1" class="form-label">Answer 1:</label>
      <input type="text" class="form-control" id="answer_1" name="answer_1" required>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="answer_2_code" name="answer_2_code">
      <label class="form-check-label" for="answer_2_code">Answer 2 in code format</label>
    </div>
    <div class="mb-3">
      <label for="answer_2" class="form-label">Answer 2:</label>
      <input type="text" class="form-control" id="answer_2" name="answer_2" required>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="answer_3_code" name="answer_3_code">
      <label class="form-check-label" for="answer_3_code">Answer 3 in code format</label>
    </div>
    <div class="mb-3">
      <label for="answer_3" class="form-label">Answer 3:</label>
      <input type="text" class="form-control" id="answer_3" name="answer_3" required>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="answer_4_code" name="answer_4_code">
      <label class="form-check-label" for="answer_4_code">Answer 4 in code format</label>
    </div>
    <div class="mb-3">
      <label for="answer_4" class="form-label">Answer 4:</label>
      <input type="text" class="form-control" id="answer_4" name="answer_4" required>
    </div>
    <div class="mb-3">
      <label for="question_answer" class="form-label">Correct Answer:</label>

      <select class="form-select" id="question_answer" name="question_answer" required>
        <option disabled value="">Select Correct Answer</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="difficulty" class="form-label">Difficulty:</label>
      <input type="number" class="form-control" id="difficulty" name="difficulty" value="<?php echo $difficulty; ?>" required>
    </div><br />

    <div class="container d-grid gap-2 d-md-grid justify-content-md-center">
      <input type="submit" value="Add Question" class="btn btn-lg btn-bd-red">
    </div>

  </form>
</main>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Get the input elements for Answer 1 to Answer 4
    var answerInput1 = document.getElementById("answer_1");
    var answerInput2 = document.getElementById("answer_2");
    var answerInput3 = document.getElementById("answer_3");
    var answerInput4 = document.getElementById("answer_4");

    // Get the select element
    var selectElement = document.getElementById("question_answer");

    // Event listener for Answer 1 input field
    answerInput1.addEventListener("input", function() {
      updateSelectOptions();
    });

    // Event listener for Answer 2 input field
    answerInput2.addEventListener("input", function() {
      updateSelectOptions();
    });

    // Event listener for Answer 3 input field
    answerInput3.addEventListener("input", function() {
      updateSelectOptions();
    });

    // Event listener for Answer 4 input field
    answerInput4.addEventListener("input", function() {
      updateSelectOptions();
    });

    // Function to update select options based on input field values
    function updateSelectOptions() {
      var answers = [
        answerInput1.value,
        answerInput2.value,
        answerInput3.value,
        answerInput4.value
      ];

      // Clear existing options
      selectElement.innerHTML = "<option disabled value=''>Select Correct Answer</option>";

      // Loop through answers and create options
      answers.forEach(function(answer, index) {
        var option = document.createElement("option");
        option.value = index;
        option.text = "Answer " + (index + 1) + ": " + answer;
        selectElement.appendChild(option);
      });
    }
  });
</script>

<?php
// Include footer.
require_once './footer.php';
?>
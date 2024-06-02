<?php
define('MY_APP', true);
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

require_once 'dbconnection.php';

// Default student ID
$id = isset($_GET['id']) ? $_GET['id'] : 1;
// Prepare the SQL statement with placeholders.
$select = "SELECT * FROM students WHERE student_id = ?;";
// Initialize a prepared statement.
$stmt = $conn->prepare($select);
// Bind the parameters to the placeholders.
$stmt->bind_param("i", $id);
// Execute the prepared statement.
$stmt->execute();
// Get the result
$result = $stmt->get_result();
// Close statement.
$stmt->close();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  die("Student (id = " . $id . ") not found");
}

$pageTitle = "Student Details";
require_once 'header.php';
?>

<!--main-->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student</h1>
    <a href="edit-student.php?id=<?php echo $row['student_id']; ?>" class="btn btn-lg btn-bd-red">Edit</a>
  </div>
  <!-- Student Profile Card -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card shadow-lg p-3 mb-5 rounded">
          <div class="card-body">
            <h5 class="card-title text-center"><?= htmlspecialchars($row["first_name"], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row["last_name"], ENT_QUOTES, 'UTF-8') ?></h5>
            <hr>
            <p class="card-text text-center">Student details</p>
            <div class="row">
              <?php
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';
              echo '<li class="list-group-item"><strong>ID: </strong>' . htmlspecialchars($row["student_id"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>First Name: </strong>' . htmlspecialchars($row["first_name"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>Last Name: </strong>' . htmlspecialchars($row["last_name"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>Email: </strong>' . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>Date Of Birth: </strong>' . htmlspecialchars($row["dob"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '</ul>';
              echo '</div>';
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';

              // Recommendation check and display
              if ($row["recommendation"] == 1) {
                echo '<li class="list-group-item"><strong>Recommendation: </strong>' . '111++' . '</li>';
              } else {
                echo '<li class="list-group-item"><strong>Recommendation: </strong>' . htmlspecialchars($row["recommendation"], ENT_QUOTES, 'UTF-8') . '</li>'; // Display actual recommendation value otherwise
              }

              echo '<li class="list-group-item"><strong>Date Taken: </strong>' . htmlspecialchars($row["date_quiz_taken"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>Start Term: </strong>' . htmlspecialchars($row["expected_term"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>CWU ID: </strong>';
              if ($row["sid"] > 0) {
                echo htmlspecialchars($row["sid"], ENT_QUOTES, 'UTF-8');
              } else {
                echo 'No SID';
              }
              echo '</li>';
              echo '<li class="list-group-item"><strong>Previous College: </strong>' . htmlspecialchars($row["previous_education"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '<li class="list-group-item"><strong>Relevant CS Courses: </strong>' . htmlspecialchars($row["previous_classes"], ENT_QUOTES, 'UTF-8') . '</li>';
              echo '</ul>';
              echo '</div>';
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <h2>Exam Results</h2>
  <div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Question details</th>
          <th scope="col">Student Answer</th>
          <th scope="col">Corrected Answer</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="4" class="text-center">CS110</th>
        </tr>
        <hr>
        <?php
        function prepareScriptInput($text)
        {
          return str_replace('`', '\\`', $text);
        }

        $cs110 = true; // Flag to indicate we're currently in CS110 section

        $qSelect = "SELECT q.question_id, q.question_body, q.answer_1, q.answer_2, q.answer_3, q.answer_4, q.question_answer, quiz.selected_answer FROM quiz INNER JOIN questions q ON quiz.question_id = q.question_id WHERE quiz.student_id = ? ORDER BY q.difficulty, q.question_id;
 ";
        // Initialize a prepared statement.
        $qStmt = $conn->prepare($qSelect);
        // Bind the parameters to the placeholders.
        $qStmt->bind_param("i", $id);
        // Execute the prepared statement.
        $qStmt->execute();
        // Get the result
        $qResult = $qStmt->get_result();
        // Close statement.
        $qStmt->close();

        $questionNum = 1;

        while ($qRow = $qResult->fetch_assoc()) {
          $number = 'question_' . $qRow["question_id"];

          // Insert subsection title and line only if changing sections (after CS110)
          if ($cs110 && $questionNum > 15) {
            echo '<tr>';
            echo '<th colspan="4" class="text-center">CS111</th>';
            echo '</tr>';
            echo '<hr>';
            $cs110 = false; // Update flag after first CS110 section
          }

          $rowClass = (strval($qRow["question_answer"]) === strval($qRow["selected_answer"])) ? 'table-success' : 'table-danger'; // Set row class based on answer
          echo '<tr class="' . $rowClass . '"">';
          echo '<td>' . $questionNum . '</td>';
          // Question Body.
          echo '<td id="question-body-' . $qRow["question_id"] . '">';
          echo '  <script>document.getElementById("question-body-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($qRow["question_body"]) . '`);</script>';
          echo '</td>';
          // Student Answer.
          echo '<td id="student-answer-' . $qRow["question_id"] . '">';
          $student_answer_text = $qRow['answer_' . (intval($qRow["selected_answer"]) + 1)];
          echo '  <script>document.getElementById("student-answer-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($student_answer_text) . '`);</script>';
          echo '</td>';
          // Correct Answer.
          echo '<td id="correct-answer-' . $qRow["question_id"] . '">';
          $correct_answer = $qRow['question_answer'];
          $correct_answer_text = $qRow['answer_' . ($correct_answer + 1)];
          echo '  <script>document.getElementById("correct-answer-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($correct_answer_text) . '`);</script>';
          echo '</td>';
          echo '</tr>';

          $questionNum++;
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<?php
require_once './footer.php';
$conn->close();
?>
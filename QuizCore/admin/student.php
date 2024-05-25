<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

// Start the session.
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

// Include the database connection file.
include_once 'dbconnection.php';

// Default student ID
$id = isset($_GET['id']) ? $_GET['id'] : 1;
// Prepare the SQL statement
$select = "SELECT * FROM students WHERE student_id = ?;";
$stmt = $conn->prepare($select);
// Bind parameters
$stmt->bind_param("i", $id);
// Execute the statement
$stmt->execute();
// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  // Display student data using $row (existing logic)
} else {
  echo "Student not found.";  // Handle case where default student is not found
}

// Rest of your code to display student information using $row

$pageTitle = "Student Details";
require_once 'header.php';
?>

<!--main-->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student</h1>
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
        <?php
        function prepareScriptInput($text)
        {
          return str_replace('`', '\\`', $text);
        }

        $cs110 = true; // Flag to indicate we're currently in CS110 section

        // Display CS110 header before the loop (guaranteed)
        echo '<tr>';
        echo '<th colspan="4" class="text-center">CS110</th>';
        echo '</tr>';
        echo '<hr>'; // Add horizontal line for separation

        $qSelect = "SELECT * FROM questions";
        $qResults = $conn->query($qSelect);

        while ($qRow = $qResults->fetch_assoc()) {
          $number = 'question_' . $qRow["question_id"];
          $questionId = $qRow["question_id"];

          // Determine subsection (CS110 or CS111) based on question ID range
          if ($questionId <= 15) {
            $subsection = "CS110";
          } else {
            $subsection = "CS111";
          }

          // Insert subsection title and line only if changing sections (after CS110)
          if ($cs110 && $subsection === "CS111") {
            echo '<tr>';
            echo '<th colspan="4" class="text-center">' . $subsection . '</th>';
            echo '</tr>';
            echo '<hr>'; // Add horizontal line for separation
            $cs110 = false; // Update flag after first CS110 section
          }

          if (strlen($row[$number]) > 0) {
            $rowClass = (strval($row[$number]) === strval($qRow["question_answer"])) ? 'table-success' : 'table-danger'; // Set row class based on answer
            echo '<tr class="' . $rowClass . '"">';
            echo '<td>' . htmlspecialchars($qRow["question_id"], ENT_QUOTES, 'UTF-8') . '</td>';
            // Question Body.
            echo '<td id="question-body-' . $qRow["question_id"] . '">';
            echo '  <script>document.getElementById("question-body-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($qRow["question_body"]) . '`);</script>';
            echo '</td>';
            // Student Answer.
            echo '<td id="student-answer-' . $qRow["question_id"] . '">';
            $student_answer = $row[$number];
            $student_answer_text = $qRow['answer_' . ($student_answer + 1)];
            echo '  <script>document.getElementById("student-answer-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($student_answer_text) . '`);</script>';
            echo '</td>';
            // Correct Answer.
            echo '<td id="correct-answer-' . $qRow["question_id"] . '">';
            $correct_answer = $qRow['question_answer'];
            $correct_answer_text = $qRow['answer_' . ($correct_answer + 1)];
            echo '  <script>document.getElementById("correct-answer-'  . $qRow["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($correct_answer_text) . '`);</script>';
            echo '</td>';
            echo '</tr>';
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</main>
</div>
</div>

<?php
// Include footer.
require_once './footer.php';

// Close the database connection
$conn->close();
?>
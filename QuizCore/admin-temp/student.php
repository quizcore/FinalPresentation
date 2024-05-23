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

if (isset($_GET['id'])) {
  // Get student_id from index.php (existing logic)
  $id = $_GET['id'];
  $select = "SELECT * FROM students WHERE student_id = $id;";
} else {
  // Display default student with ID 1
  $id = 1;  // Set the default student ID
  $select = "SELECT * FROM students WHERE student_id = $id;";
}

$result = $conn->query($select);

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
            <h5 class="card-title text-center"> <?php echo $row["first_name"] . " " . $row["last_name"] ?> </h5>
            <hr>
            <p class="card-text text-center">Student details</p>
            <div class="row">
              <?php
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';
              echo '<li class="list-group-item"><strong>ID: </strong>' . $row["student_id"] . '</li>';
              echo '<li class="list-group-item"><strong>First Name: </strong>' . $row["first_name"] . '</li>';
              echo '<li class="list-group-item"><strong>Last Name: </strong>' . $row["last_name"] . '</li>';
              echo '<li class="list-group-item"><strong>Email: </strong>' . $row["email"] . '</li>';
              echo '<li class="list-group-item"><strong>Date Of Birth: </strong>' . $row["dob"] . '</li>';
              echo '</ul>';
              echo '</div>';
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';

              // Recommendation check and display
              if ($row["recommendation"] == 1) {

                echo '<li class="list-group-item"><strong>Recommendation: </strong>' . '111++' . '</li>';
              } else {
                echo '<li class="list-group-item"><strong>Recommendation: </strong>' . $row["recommendation"] . '</li>'; // Display actual recommendation value otherwise
              }

              echo '<li class="list-group-item"><strong>Date Taken: </strong>' . $row["date_quiz_taken"] . '</li>';
              echo '<li class="list-group-item"><strong>Start Term: </strong>' . $row["expected_term"] . '</li>';
              echo '<li class="list-group-item"><strong>CWU ID: </strong>';
              if ($row["sid"] > 0) {
                echo $row["sid"];
              } else {
                echo 'No SID';
              }
              echo '</li>';
              echo '<li class="list-group-item"><strong>Previous College: </strong>' . $row["previous_education"] . '</li>';
              echo '<li class="list-group-item"><strong>Relevant CS Courses: </strong>' . $row["previous_classes"] . '</li>';
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
          <th scope="col">Question number</th>
          <th scope="col">Question details</th>
          <th scope="col">Student Answer</th>
          <th scope="col">Corrected Answer</th>
        </tr>
      </thead>
      <tbody>
        <?php
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
            $rowClass = ($row[$number] === $qRow["question_answer"]) ? 'table-success' : 'table-danger'; // Set row class based on answer
            echo '<tr class="' . $rowClass . '"">';
            echo '<td>' . $qRow["question_id"] . '</td>';
            echo '<td>' . $qRow["question_body"] . '</td>';
            echo '<td>' . $row[$number] . '</td>';
            echo '<td>' . $qRow["question_answer"] . '</td>';
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

<script>
  function redirectToStudentPage(studentId) {
    window.location.href = 'students_page?id=' + studentId;
  }
</script>

<?php
// Include footer.
require_once './footer.php';
?>
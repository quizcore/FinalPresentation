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

require_once 'dbconnection.php';

$result = $conn->query("SELECT * FROM students");

$pageTitle = "All Students";
require_once 'header.php';
?>

<!--main-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">List of all students</h1>
  </div>

  <!--Data table-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Students</h3>
          </div>
          <div class="card-body">

            <!-- table entry-->
            <table id="quizcore-students-table" class="table table-striped table-sm" cellspacing="0" width="100%">

              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Date Of Birth</th>
                  <th scope="col">Date Taken</th>
                  <th scope="col">Recommendation</th>
                  <th scope="col">Start Term</th>
                  <th scope="col">CWU ID</th>
                  <th scope="col">Previous College</th>
                  <th scope="col">Relevant CS Courses</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Function to build table rows
                function buildTableRow(array $row): void
                {
                  // Get the student ID
                  $student_id  = htmlspecialchars($row["student_id"], ENT_QUOTES, 'UTF-8');
                  echo '<tr
                        data-bs-toggle="' . "tooltip" . '"
                        data-bs-placement="' . "top" . '"
                        data-bs-title="' . "Tooltip on top" . '"
                        data-student-id="' . $student_id . '"
                      >';

                  // add a tag on student_id
                  echo '<td>' . htmlspecialchars($row["student_id"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["first_name"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["last_name"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["dob"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["date_quiz_taken"], ENT_QUOTES, 'UTF-8') . '</td>';

                  // Recommendation check and display
                  if ($row["recommendation"] == 1) {
                    echo '<td>111++</td>'; // Show "111+" when recommendation is 1
                  } else {
                    echo '<td>' . htmlspecialchars($row["recommendation"], ENT_QUOTES, 'UTF-8') . '</td>'; // Display actual recommendation value otherwise
                  }

                  echo '<td>' . htmlspecialchars($row["expected_term"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . ($row["sid"] > 0 ? htmlspecialchars($row["sid"], ENT_QUOTES, 'UTF-8') : 'No SID') . '</td>';
                  echo '<td>' . htmlspecialchars($row["previous_education"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["previous_classes"], ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '</tr>';
                }

                // Loop through the result set
                foreach ($result as $row) {
                  buildTableRow($row);
                }

                // Free result set
                $result->free();
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  // Students table.
  document.addEventListener('DOMContentLoaded', function() {
    /** @type {HTMLElement} */
    const quizcoreStudentsTable = document.querySelector('#quizcore-students-table');

    new DataTable(quizcoreStudentsTable, {
      scrollY: "100vh",
      scrollX: true,
      scrollCollapse: true,
    });
  });

  // redirectToStudentPage
  /** @type {NodeListOf<HTMLTableRowElement>} */
  const tableRows = document.querySelectorAll('tr[data-student-id]'); // Select rows with data-student-id attribute

  tableRows.forEach(row => {
    row.addEventListener('click', (event) => {
      // Get the student ID from the data attribute
      /** @type {string} */
      const studentId = row.dataset.studentId;

      // Redirect to student info page with ID parameter
      window.location.href = `student.php?id=${studentId}`;
    });
  });
</script>

<?php
// Include footer.
require_once 'footer.php';

// Close the database connection
$conn->close();
?>
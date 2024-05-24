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

// Define the date range for the last 7 days
$today = date("Y-m-d");
$sevenDaysAgo = date('Y-m-d', strtotime($today . '- 7 days'));

// Store Count of students recommended to 110, 111, and 112
$count110 = 0;
$count111 = 0;
$count1 = 0;

$select = "SELECT * FROM students";
$result = $conn->query($select);

//$newStudents = 0;
$total = 0;
while ($row = $result->fetch_assoc()) {
  $total++;
  // if ($row["expected_term"] === "Fall2024") {
  //   $newStudents++;
  // }
  if ($row["recommendation"] == 110) {
    $count110++;
  } else if ($row["recommendation"] == 111) {
    $count111++;
  } else if ($row["recommendation"] == 1) {
    $count1++;
  }
}

// Count students who took exam in the last 7 days
$lastWeekStudents_query = "SELECT COUNT(*) as number_of_students FROM students WHERE date_quiz_taken >= '$sevenDaysAgo' AND date_quiz_taken <= '$today'";
$lastWeekStudents_result = $conn->query($lastWeekStudents_query);

$lastWeekStudents = 0;
if ($lastWeekStudents_result->num_rows > 0) {
  $row = $lastWeekStudents_result->fetch_assoc();
  $lastWeekStudents = $row['number_of_students'];
}

// Count date and students.
$dates_students_query = "SELECT date_quiz_taken, COUNT(*) as number_of_students FROM students GROUP BY date_quiz_taken";
$dates_students_result = $conn->query($dates_students_query);

$dates = array();
$number_of_students = array();

if ($dates_students_result->num_rows > 0) {
  while ($row = $dates_students_result->fetch_assoc()) {
    $dates[] = $row['date_quiz_taken'];
    $number_of_students[] = $row['number_of_students'];
  }
}

// Count students attending each quarter.
$terms_students_query = "SELECT expected_term, COUNT(*) as number_of_students FROM students GROUP BY expected_term";
$terms_students_result = $conn->query($terms_students_query);

$terms = array();
$term_student_counts = array();

if ($terms_students_result->num_rows > 0) {
  while ($row = $terms_students_result->fetch_assoc()) {
    $terms[] = $row['expected_term'];
    $term_student_counts[] = $row['number_of_students'];
  }
}

$pageTitle = "Dashboard";
require_once 'header.php';
?>

<!--main-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  </div>

  <!--Boxes-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-6 col-xxl-6 col-sm-6 mb-4">
        <div class="card border-primary text-center border-2">
          <div class="card-header fs-5">
            Total Students
          </div> <!-- card-header -->
          <div class="card-body">
            <h2> <?= $total ?></h2>
          </div> <!-- card-body -->
          <div class="card-footer text-muted">
            <span class="ml-3 align-self-center">
              <i class="bi bi-people" style="font-size: 1.75rem;"></i>
            </span>
          </div> <!-- card-footer -->
        </div> <!-- card -->
      </div> <!-- col -->
      <div class="col-xl-6 col-xxl-6 col-sm-6 mb-4">
        <div class="card border-warning text-center border-2">
          <div class="card-header fs-5">
            Students Signed Up Last Week
          </div> <!-- card-header -->
          <div class="card-body">
            <h2> <?= $lastWeekStudents ?></h2>
          </div>
          <div class="card-footer text-muted">
            <span class="ml-3 align-self-center">
              <i class="bi bi-pen" style="font-size: 1.75rem;"></i>
            </span>
          </div> <!-- card-footer -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!--Data table-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Students</h3>
          </div> <!-- card-header -->
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
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Course Description. -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Course Recommendation Criteria</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <ol class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">CS110</div>
                  Students are recommended to enroll in CS110 if they score less than 11 on the first three sections of the placement exam.
                </div>
              </li> <!-- list-group-item -->
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">CS111</div>
                  Students are recommended to enroll in CS111 if they score between 11 and 24, inclusive, on the placement exam.
                </div>
              </li> <!-- list-group-item -->
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">CS111++</div>
                  Students have met the learning requirements for CS110 and CS111 if they score 25 or higher on the placement exam.
                </div>
              </li> <!-- list-group-item -->
            </ol> <!-- list-group -->
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Pie chart -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Course Recommendations</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <canvas class="my-4 w-100" id="quizcore-doughnut-chart" style="max-height: 300px"></canvas>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Bar chart: Date Taken vs Number of Students (Taking Exam)-->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Number of Students Taking Exam</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <canvas class="my-4 w-100" id="quizcore-date-taken-bar-chart" style="max-height: 300px"></canvas>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Bar chart: Date Taken vs Number of Students (Attending Each Term)-->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Number of Students Attending Each Term</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <canvas class="my-4 w-100" id="quizcore-expected-term-bar-chart" style="max-height: 300px"></canvas>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->
</main>
</div>
</div>

<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<!-- Chart -->
<script>
  // Doughnut Chart.
  new Chart(document.getElementById("quizcore-doughnut-chart").getContext("2d"), {
    type: "doughnut",
    data: {
      labels: ["CS110", "CS111", "CS111++"],
      datasets: [{
        data: [<?= $count110 ?>, <?= $count111 ?>, <?= $count1 ?>],
        backgroundColor: [
          "rgba(171, 0, 50, 1)", // Madder
          "rgba(140, 94, 88, 1)", // Rose
          "rgba(25, 50, 60, 1)", // Gunmetal
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)",
          "rgba(138, 35, 50, 255)",
          "rgba(0, 0, 0, 255)",
        ],
        borderWidth: 1,
      }, ],
    },
    options: {
      // Add a legend to the chart.
      legend: {
        position: "right", // Adjust position as needed.
      },
      // Add labels inside the doughnut chart.
      plugins: {
        labels: {
          render: "percentage", // Display percentages
          precision: 0, // Number of decimal places for percentages
          fontSize: 14, // Font size of labels
          fontColor: "#fff", // Font color of labels
          fontStyle: "bold", // Font style of labels
          fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif", // Font family of labels
        },
      },
      // Customize hover effects
      hover: {
        mode: "nearest", // Highlight nearest item on hover
        animationDuration: 500, // Adjusted animation duration on hover (increased to 500ms)
        intersect: true, // Enable hover interactions with all elements at the same index
      },
    },
  });


  // Date Taken vs Number of Students Bar Chart. (Taking Exam)
  new Chart(document.getElementById("quizcore-date-taken-bar-chart").getContext("2d"), {
    type: 'bar',
    data: {
      labels: <?= json_encode($dates) ?>.map(date => new Date(date).toLocaleDateString('en-US', {
        timeZone: 'UTC'
      })),
      datasets: [{
        label: 'Number of Students',
        data: <?= json_encode($number_of_students) ?>,
        backgroundColor: [
          "rgba(171, 0, 50, 1)"
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)"
        ],
      }]
    },
    options: {
      borderWidth: 0,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Date Taken',
            font: {
              size: 18,
            },
          },
          ticks: {
            maxRotation: 45,
            minRotation: 45,
            autoSkip: false
          },
          grid: {
            display: false // Hide the x-grid lines
          },
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Students',
            font: {
              size: 18,
            },
          },
          ticks: {
            beginAtZero: true,
            callback: function(value) {
              if (value % 1 === 0) {
                return value;
              }
            }
          },
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw}`;
            }
          }
        }
      }
    }
  });

  // Date Taken vs Number of Students Bar Chart (Attending Each Term).
  new Chart(document.getElementById("quizcore-expected-term-bar-chart").getContext("2d"), {
    type: 'bar',
    data: {
      labels: <?= json_encode($terms) ?>,
      datasets: [{
        label: 'Number of Students',
        data: <?= json_encode($term_student_counts) ?>,
        backgroundColor: [
          "rgba(171, 0, 50, 1)"
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)"
        ],
      }]
    },
    options: {
      borderWidth: 0,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Expected Term',
            font: {
              size: 18,
            },
          },
          ticks: {
            maxRotation: 45, // x labels Rotation
            minRotation: 45, // x labels Rotation
            autoSkip: false
          },
          grid: {
            display: false // Hide the x-grid lines
          },
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Students',
            font: {
              size: 18,
            },
          },
          ticks: {
            beginAtZero: true,
            callback: function(value) {
              if (value % 1 === 0) {
                return value;
              }
            }
          },
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw}`;
            }
          }
        }
      }
    }
  });

  // Students table.
  document.addEventListener('DOMContentLoaded', function() {
    new DataTable('#quizcore-students-table', {
      scrollY: "100vh",
      scrollX: true,
      scrollCollapse: true,
    });
  });
</script>

<!-- redirect To Student Page -->
<script>
  // redirectToStudentPage
  const tableRows = document.querySelectorAll('tr[data-student-id]'); // Select rows with data-student-id attribute

  tableRows.forEach(row => {
    row.addEventListener('click', (event) => {
      // Get the student ID from the data attribute
      const studentId = row.dataset.studentId;

      // Redirect to student info page with ID parameter
      window.location.href = `student.php?id=${studentId}`;
    });
  });
</script>

<?php
// Include footer.
require_once './footer.php';
?>
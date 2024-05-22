<?php
// Include the database connection file.
include_once 'dbconnection.php';

// Start the session.
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

// Define the date range for the last 7 days
$today = date("Y-m-d");
$sevenDaysAgo = date('Y-m-d', strtotime($today . '- 7 days'));

// Store Count of students recommended to 110, 111, and 112
$count110 = 0;
$count111 = 0;
$count1 = 0;

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
$numberOfStudents = array();

if ($dates_students_result->num_rows > 0) {
  while ($row = $dates_students_result->fetch_assoc()) {
    $dates[] = $row['date_quiz_taken'];
    $numberOfStudents[] = $row['number_of_students'];
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
      <div class="col-xl-6 col-xxl-6 col-sm-6">
        <div class="widget-stat card bg-primary">
          <div class="card-body">
            <div class="media">
              <span class="mr-3">
                <i class="la la-users"></i>
              </span>
              <div class="media-body text-white">
                <p class="mb-1">Total Students</p>
                <?php
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
                echo '<h3 class="text-white">' . $total . '</h3>';
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-xxl-6 col-sm-6">
        <div class="widget-stat card bg-warning">
          <div class="card-body">
            <div class="media">
              <span class="mr-3">
                <i class="la la-user"></i>
              </span>
              <div class="media-body text-white">
                <p class="mb-1">Last Week Students</p>
                <?php
                echo '<h3 class="text-white">' . $lastWeekStudents . '</h3>';
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br /><br />

  <!--Data table-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Table</h3>
          </div>
          <div class="card-body">

            <!-- table entry-->
            <table id="dtBasicExample" class="table table-striped table-sm" cellspacing="0" width="100%">

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
                $select = "SELECT * FROM students";
                $result = $conn->query($select);

                while ($row = $result->fetch_assoc()) {
                  // Get the student ID
                  $student_id  = $row["student_id"];
                  echo '<tr
                        data-bs-toggle="' . "tooltip" . '"
                        data-bs-placement="' . "top" . '"
                        data-bs-title="' . "Tooltip on top" . '"
                        data-student-id="' . $student_id . '"
                      >';

                  // add a tag on student_id
                  echo '<td>' . $row["student_id"] . '</td>';
                  echo '<td>' . $row["first_name"] . '</td>';
                  echo '<td>' . $row["last_name"] . '</td>';
                  echo '<td>' . $row["email"] . '</td>';
                  echo '<td>' . $row["dob"] . '</td>';
                  echo '<td>' . $row["date_quiz_taken"] . '</td>';

                  // Recommendation check and display
                  if ($row["recommendation"] == 1) {
                    echo '<td>111++</td>'; // Show "111+" when recommendation is 1
                  } else {
                    echo '<td>' . $row["recommendation"] . '</td>'; // Display actual recommendation value otherwise
                  }

                  echo '<td>' . $row["expected_term"] . '</td>';
                  if ($row["sid"] > 0) {
                    echo '<td>' . $row["sid"] . '</td>';
                  } else {
                    echo '<td>No SID</td>';
                  }
                  echo '<td>' . $row["previous_education"] . '</td>';
                  echo '<td>' . $row["previous_classes"] . '</td>';
                  echo '</tr>';
                }

                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>


  <br /><br />
  <!-- Pie chart-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Course Recommendations</h3>
          </div>
          <div class="card-body">
            <canvas class="my-4 w-100" id="myChart" style="max-height: 300px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>


  <br /><br />
  <!-- Bar chart: Date Taken vs Number of Students -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Number of Students Taking Exam</h3>
          </div>
          <div class="card-body">
            <canvas class="my-4 w-100" id="dateTakenBarChart" style="max-height: 300px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>


  <br /><br />
  <!-- Bar chart: Date Taken vs Number of Students -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Number of Students Attending Each Term</h3>
          </div>
          <div class="card-body">
            <canvas class="my-4 w-100" id="termBarChart" style="max-height: 300px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br /><br />
</main>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<!-- Chart -->
<script>
  // Get the canvas element
  var ctx = document.getElementById("myChart").getContext("2d");

  // Define the data
  var data = {
    labels: ["CS110", "CS111", "CS111++"],
    datasets: [{
      data: [<?php echo $count110 ?>, <?php echo $count111 ?>, <?php echo $count1 ?>], // Sample data, you can replace with your own values
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
  };

  // Define options
  var options = {
    // Add a legend to the chart
    legend: {
      position: "right", // Adjust position as needed
    },
    // Add labels inside the doughnut chart
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
  };

  // Create the doughnut chart
  var myChart = new Chart(ctx, {
    type: "doughnut",
    data: data,
    options: options,
  });


  // Date Taken vs Number of Students Bar Chart.
  var dateTakenBarChartCTX = document.getElementById("dateTakenBarChart").getContext("2d");
  const dates = <?php echo json_encode($dates); ?>;
  const numberOfStudents = <?php echo json_encode($numberOfStudents); ?>;

  const formattedDates = dates.map(date => new Date(date).toLocaleDateString('en-US', {
    timeZone: 'UTC'
  }));

  const studentChart = new Chart(dateTakenBarChartCTX, {
    type: 'bar',
    data: {
      labels: formattedDates,
      datasets: [{
        label: 'Number of Students',
        data: numberOfStudents,
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
            maxRotation: 90,
            minRotation: 90,
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
  // End of Date Taken vs Number of Students Bar Chart.


  // Date Taken vs Number of Students Bar Chart.
  var termBarChartCTX = document.getElementById("termBarChart").getContext("2d");
  const terms = <?php echo json_encode($terms); ?>;
  const term_student_counts = <?php echo json_encode($term_student_counts); ?>;

  const termChart = new Chart(termBarChartCTX, {
    type: 'bar',
    data: {
      labels: terms,
      datasets: [{
        label: 'Number of Students',
        data: term_student_counts,
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
            maxRotation: 90,
            minRotation: 90,
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
  // End of Date Taken vs Number of Students Bar Chart.
</script>
<script>
  $(document).ready(function() {
    $("#dtBasicExample").DataTable({
      scrollY: "360px",
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
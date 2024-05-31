<?php
define('MY_APP', true);
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

require_once 'dbconnection.php';

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
$lastWeekStudentsQuery = "SELECT COUNT(*) as number_of_students FROM students WHERE date_quiz_taken >= '$sevenDaysAgo' AND date_quiz_taken <= '$today'";
$lastWeekStudentsResult = $conn->query($lastWeekStudentsQuery);

$lastWeekStudents = 0;
if ($lastWeekStudentsResult->num_rows > 0) {
  $row = $lastWeekStudentsResult->fetch_assoc();
  $lastWeekStudents = $row['number_of_students'];
}

// Count date and students.
$datesStudentsQuery = "SELECT date_quiz_taken, COUNT(*) as number_of_students FROM students GROUP BY date_quiz_taken";
$datesStudentsResult = $conn->query($datesStudentsQuery);

$dates = array();
$dateStudentCounts = array();

if ($datesStudentsResult->num_rows > 0) {
  while ($row = $datesStudentsResult->fetch_assoc()) {
    $dates[] = $row['date_quiz_taken'];
    $dateStudentCounts[] = $row['number_of_students'];
  }
}

// Count students attending each quarter.
$termsStudentsQuery = "SELECT expected_term, COUNT(*) as number_of_students FROM students GROUP BY expected_term";
$termsStudentsResult = $conn->query($termsStudentsQuery);

$terms = array();
$termStudentCounts = array();

if ($termsStudentsResult->num_rows > 0) {
  while ($row = $termsStudentsResult->fetch_assoc()) {
    $terms[] = $row['expected_term'];
    $termStudentCounts[] = $row['number_of_students'];
  }
}

function sortTermAndStudentCountsByYearAndQuarter(&$terms, &$studentCounts)
{
  // Define a custom sorting function
  $customSort = function ($a, $b) {
    // Extract year and quarter from the terms
    preg_match('/(\D+)(\d+)/', $a, $aMatches);
    preg_match('/(\D+)(\d+)/', $b, $bMatches);

    $aYear = $aMatches[2];
    $bYear = $bMatches[2];

    $quarters = ['Winter', 'Spring', 'Summer', 'Fall'];
    $aQuarter = array_search($aMatches[1], $quarters);
    $bQuarter = array_search($bMatches[1], $quarters);

    // First, compare years
    if ($aYear != $bYear) {
      return $aYear > $bYear;
    }
    // If years are equal, compare quarters
    else {
      return $aQuarter > $bQuarter;
    }
  };

  // Combine terms and student counts into an associative array
  $combined = array_combine($terms, $studentCounts);

  // Sort the associative array using custom sorting function
  uksort($combined, $customSort);

  // Extract sorted terms and student counts back into separate arrays
  $terms = array_keys($combined);
  $studentCounts = array_values($combined);
}

sortTermAndStudentCountsByYearAndQuarter($terms, $termStudentCounts);

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
            <h2 id="quizcore-total-students-display"><?= $total ?></h2>
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
            Students Signed Up Past Week
          </div> <!-- card-header -->
          <div class="card-body">
            <h2 id="quizcore-total-students-past-week-display"><?= $lastWeekStudents ?></h2>
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
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Date Of Birth</th>
                  <th>Date Taken</th>
                  <th>Recommendation</th>
                  <th>Start Term</th>
                  <th>CWU ID</th>
                  <th>Previous College</th>
                  <th>Relevant CS Courses</th>
                </tr>
              </tfoot>
            </table>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Pie chart & Course Description. -->
  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Course Description. -->
      <div class="col-xl-6 col-xxl-6 col-sm-12 mb-6">
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
      <!-- Pie chart . -->
      <div class="col-xl-6 col-xxl-6 col-sm-12 mb-6">
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

  <!-- Line chart: Number of Students vs Date Taken -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Number of Students Taking Exam</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <canvas class="my-4 w-100" id="quizcore-date-taken-line-chart" style="min-height: 300px; max-height: 400px;"></canvas>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->

  <!-- Line chart: Total Number of Students Taking Exam over Time -->
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Number of Students Taking Exam (cummulative)</h3>
          </div> <!-- card-header -->
          <div class="card-body">
            <canvas class="my-4 w-100" id="quizcore-cummulative-date-taken-line-chart" style="min-height: 300px; max-height: 400px;"></canvas>
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
            <canvas class="my-4 w-100" id="quizcore-expected-term-bar-chart" style="min-height: 300px; max-height: 400px;"></canvas>
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col -->
    </div> <!-- row -->
  </div> <!-- container-fluid -->
</main>

<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<!-- chart.js date adapter, needed for line chart Number of Students Signed Up over Time -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
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

  const takenDates = <?= json_encode($dates) ?>.map(date => new Date(date).toISOString().split('T')[0]);
  const studentCounts = <?= json_encode($dateStudentCounts) ?>;

  // Number of Students vs Date Taken Line Chart.
  new Chart(document.getElementById("quizcore-date-taken-line-chart").getContext("2d"), {
    type: 'line',
    data: {
      labels: takenDates,
      datasets: [{
        label: 'Number of Students',
        data: studentCounts,
        backgroundColor: [
          "rgba(171, 0, 50, 1)"
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)"
        ],
      }]
    },
    options: {
      // elements: {
      //   point: {
      //     radius: 3, // Adjust the point size here
      //     hoverRadius: 5, // Optional: Adjust hover size
      //   }
      // },
      responsive: true,
      maintainAspectRatio: false,
      borderWidth: 1,
      scales: {
        x: {
          type: 'time',
          time: {
            // unit: 'day',
            tooltipFormat: 'yyyy-MM-dd'
          },
          title: {
            display: true,
            text: 'Date Taken',
            font: {
              size: 16,
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
              size: 16,
            },
          },
          ticks: {
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

  /**
   * Calculates the cumulative student counts from an array of student counts.
   * @param {number[]} studentCounts - An array of integers representing the number of students per exam date.
   * @returns {number[]} An array of integers representing the cumulative student counts.
   */
  const calculateCumulativeStudentCounts = (studentCounts) => {
    let cumulativeStudentCounts = [];
    let sum = 0;

    for (let i = 0; i < studentCounts.length; i++) {
      sum += studentCounts[i];
      cumulativeStudentCounts.push(sum);
    }

    return cumulativeStudentCounts;
  };

  /**
   * Parses the string array into an array of numbers.
   * @param {string[]} studentCounts - An array of strings representing the number of students per exam date.
   * @returns {number[]} An array of integers representing the number of students per exam date.
   */
  const parseStudentCounts = (studentCounts) => {
    return studentCounts.map(count => parseInt(count, 10));
  };

  const cumulativeStudentCounts = calculateCumulativeStudentCounts(parseStudentCounts(studentCounts));

  // Total Number of Students vs Date Taken Line Chart.
  new Chart(document.getElementById("quizcore-cummulative-date-taken-line-chart").getContext("2d"), {
    type: 'line',
    data: {
      labels: takenDates,
      datasets: [{
        label: 'Total Students',
        data: cumulativeStudentCounts,
        backgroundColor: [
          "rgba(171, 0, 50, 1)"
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)"
        ],
      }]
    },
    options: {
      // elements: {
      //   point: {
      //     radius: 3, // Adjust the point size here
      //     hoverRadius: 5, // Optional: Adjust hover size
      //   }
      // },
      responsive: true,
      maintainAspectRatio: false,
      borderWidth: 1.25,
      scales: {
        x: {
          type: 'time',
          time: {
            // unit: 'day',
            tooltipFormat: 'yyyy-MM-dd'
          },
          title: {
            display: true,
            text: 'Time',
            font: {
              size: 16,
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
            text: 'Total Students',
            font: {
              size: 16,
            },
          },
          ticks: {
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
        data: <?= json_encode($termStudentCounts) ?>,
        backgroundColor: [
          "rgba(171, 0, 50, 1)"
        ],
        borderColor: [
          "rgba(171, 4, 51, 255)"
        ],
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      borderWidth: 0,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Expected Term',
            font: {
              size: 16,
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
              size: 16,
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

  // JavaScript to animate the stats cards.
  document.addEventListener("DOMContentLoaded", function() {
    let counterElements = [{
        element: document.getElementById("quizcore-total-students-display"),
        target: <?= $total ?>
      },
      {
        element: document.getElementById("quizcore-total-students-past-week-display"),
        target: <?= $lastWeekStudents ?>
      }
    ];
    let start = null;
    let duration = 1000; // Total duration of the animation in milliseconds

    function updateCounters(timestamp) {
      if (!start) start = timestamp;
      let progress = timestamp - start;

      counterElements.forEach(counter => {
        let count = Math.min(progress / duration * counter.target, counter.target);
        counter.element.innerText = Math.floor(count);
      });

      if (progress < duration) {
        requestAnimationFrame(updateCounters);
      } else {
        counterElements.forEach(counter => counter.element.innerText = counter.target); // Ensure they end exactly at target
      }
    }

    requestAnimationFrame(updateCounters);
  });
</script>

<script>
  // Students table.
  document.addEventListener('DOMContentLoaded', function() {
    // Setup - add a text input to each footer cell
    $('#quizcore-students-table tfoot th').each(function(i) {
      var $headerTh = $('#quizcore-students-table thead th').eq($(this).index());
      var title = $headerTh.text();
      var headerWidth = $headerTh.width(); // Get the width of the corresponding header cell

      $(this).html(
        '<input type="text" placeholder="' + title + '" data-index="' + i + '" style="width: ' + headerWidth + 'px;"/>'
      );
    });

    /** @type {HTMLElement} */
    const quizcoreStudentsTable = document.querySelector('#quizcore-students-table');

    const table = new DataTable(quizcoreStudentsTable, {
      scrollY: "100vh",
      scrollX: true,
      scrollCollapse: true,
    });

    // Filter event handler
    $(table.table().container()).on('keyup', 'tfoot input', function() {
      table
        .column($(this).data('index'))
        .search(this.value)
        .draw();
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

      // Open the student info page in a new tab with the ID parameter
      window.open(`student.php?id=${studentId}`, '_blank');
    });
  });
</script>

<?php
require_once './footer.php';
?>
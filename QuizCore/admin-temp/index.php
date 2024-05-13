<?php
session_start();
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Store Count of students recommended to 110, 111, and 112
$count110 = 0;
$count111 = 0;
$count112 = 0;


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

                $newStudents = 0;
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                  $total++;
                  if ($row["expected_term"] === "Fall24") {
                    $newStudents++;
                  }
                  if ($row["recommendation"] == 110) {
                    $count110++;
                  } else if ($row["recommendation"] == 111) {
                    $count111++;
                  } else if ($row["recommendation"] == 112) {
                    $count112++;
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
                <p class="mb-1">Students Attended Next Term</p>
                <?php
                echo '<h3 class="text-white">' . $newStudents . '</h3>';
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
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Date Of Birth</th>
                  <th scope="col">Recommendation</th>
                  <th scope="col">Start Term</th>
                  <th scope="col">CWu ID</th>
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
                  echo '<td>' . $row["recommendation"] . '</td>';
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

  <!-- chart-->
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
    labels: ["CS110", "CS111", "CS112+"],
    datasets: [{
      data: [<?php echo $count110 ?>, <?php echo $count111 ?>, <?php echo $count112 ?>], // Sample data, you can replace with your own values
      backgroundColor: [
        "rgba(171, 4, 51, 255)", // Red
        "rgba(138, 35, 50, 255)", // Dark Red
        "rgba(0, 0, 0, 255)", // Black
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
</script>
<script>
  $(document).ready(function() {
    $("#dtBasicExample").DataTable({
      scrollY: "360px",
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
</body>

</html>
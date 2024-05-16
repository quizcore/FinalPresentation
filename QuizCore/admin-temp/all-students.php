<?php
session_start();
//delete later
$_SESSION['servername'] = "localhost";
$_SESSION['username'] = "root";
$_SESSION['password'] = "";
$_SESSION['dbname'] = "quizcore";
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
    <h1 class="h2">All of all students</h1>
  </div>

  <!--Data table-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All students</h3>
          </div>
          <div class="card-body">

            <!-- table entry-->
            <div class="table-wrapper">
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
  </div>

</main>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<!-- Chart -->

<script>
  $(document).ready(function() {
    $("#dtBasicExample").DataTable({
      scrollY: "500px",
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
</body>

</html>
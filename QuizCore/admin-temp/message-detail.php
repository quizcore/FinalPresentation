<?php
session_start();
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

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
    <h1 class="h2">Message</h1>

  </div>
  <!-- Student Profile Card -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">

        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
          <div class="card-body">
            <h5 class="card-title text-center"> <?php echo $row["first_name"] . " " . $row["last_name"] ?> </h5>
            <hr>
            <p class="card-text text-center">Message details</p>
            <div class="row">
              <?php
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';
              echo '<li class="list-group-item"><strong>ID: </strong>' . $row["student_id"] . '</li>';
              echo '<li class="list-group-item"><strong>ID: </strong>' . $row["student_id"] . '</li>';

              echo '</div>';
              echo '<div class="col-md-6">';
              echo '<ul class="list-group list-group-flush">';

              // Recommendation check and display


              echo '<li class="list-group-item"><strong>Start Term: </strong>' . $row["expected_term"] . '</li>';
              echo '</ul>';
              echo '</div>';
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</main>
</div>
</div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
<script>
  // Get the canvas element
  var ctx = document.getElementById('myChart').getContext('2d');

  // Define the data
  var data = {
    labels: ['CS110', 'CS111', 'NONE'],
    datasets: [{
      data: [30, 40, 30], // Sample data, you can replace with your own values
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)', // Red
        'rgba(54, 162, 235, 0.6)', // Blue
        'rgba(255, 206, 86, 0.6)' // Yellow
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)'
      ],
      borderWidth: 1
    }]
  };

  // Define options
  var options = {
    // Add a legend to the chart
    legend: {
      position: 'right' // Adjust position as needed
    },
    // Add labels inside the doughnut chart
    plugins: {
      labels: {
        render: 'percentage', // Display percentages
        precision: 0, // Number of decimal places for percentages
        fontSize: 14, // Font size of labels
        fontColor: '#fff', // Font color of labels
        fontStyle: 'bold', // Font style of labels
        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif" // Font family of labels
      }
    },
    // Customize hover effects
    hover: {
      mode: 'nearest', // Highlight nearest item on hover
      animationDuration: 500, // Adjusted animation duration on hover (increased to 500ms)
      intersect: true // Enable hover interactions with all elements at the same index
    }
  };


  // Create the doughnut chart
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
  });
</script>

<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<script>
  function redirectToStudentPage(studentId) {
    window.location.href = 'students_page?id=' + studentId;
  }
</script>

</body>

</html>
<?php
// Include the database connection file.
include_once 'dbconnection.php';

// Start the session.
session_start();

if (isset($_GET['mess_id'])) {
  // Get student_id from index.php (existing logic)
  $mess_id = $_GET['mess_id'];
  $select = "SELECT * FROM contact WHERE contact_id = $mess_id;";
} else {
  // Display default student with ID 1
  $mess_id = 1;  // Set the default student ID
  $select = "SELECT * FROM contact WHERE contact_id = $mess_id;";
}

$result = $conn->query($select);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  // Display student data using $row (existing logic)
} else {
  echo "Contact not found.";  // Handle case where default student is not found
}

// Rest of your code to display student information using $row

$pageTitle = "Contact Details";
require_once 'header.php';
?>

<!--main-->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Message</h1>
  </div>


  <!-- Contact Card -->

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Admin Profile Card -->
        <div class="card shadow-lg p-3 mb-5 rounded">
          <div class="card-body">
            <h5 class="card-title text-center"> <?php echo $row["contact_name"] ?> </h5>
            <hr>
            <?php
            echo '<p class="card-text text-center">' . $row["contact_email"] . '</p>';
            echo '<ul class="list-group list-group-flush">';
            echo '<li class="list-group-item">' . $row["contact_message"] . '</li>';
            echo '</ul>';
            ?>
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


<?php
// Include footer.
require_once './footer.php';
?>
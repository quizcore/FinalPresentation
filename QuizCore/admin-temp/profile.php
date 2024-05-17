<?php
session_start();
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

//$select = "SELECT * FROM admin WHERE email = '$_SESSION[admin_email]';";
$select = "SELECT * FROM admin";
$result = $conn->query($select);
$row = $result->fetch_assoc();

$pageTitle = "Admin Profile";
require_once 'header.php';
?>

<!--Main-->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Admin Profile Card -->
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
          <div class="card-body">
            <h5 class="card-title text-center">Admin Profile</h5>
            <hr>
            <?php
            echo '<p class="card-text text-center">Welcome, ' . $row["first_name"] .  '! Here are your details:</p>';
            echo '<ul class="list-group list-group-flush">';
            echo '<li class="list-group-item"><strong>Name:</strong>' . $row["first_name"] . " " . $row["last_name"] . '</li>';
            echo '<li class="list-group-item"><strong>Email:</strong>' . $row["email"] . '</li>';
            echo '<li class="list-group-item"><strong>Role:</strong> Administrator</li>';
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
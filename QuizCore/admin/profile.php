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

// Fetch the admin data
$select = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($select);
$stmt->bind_param("s", $_SESSION['admin_email']);
$stmt->execute();
$result = $stmt->get_result();
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
      <div class="col-lg-8">
        <!-- Admin Profile Card -->
        <div class="card shadow-lg p-3 mb-5 rounded">
          <h3 class="card-title text-center">Admin Profile</h3>
          <div class="card-body">
            <div class="row mt-3">
              <div class="col-lg-12">
                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                  <div class="col-sm-4">
                    <label class="col-form-label fw-bold">Email:</label>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-control"><?= htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></div>
                  </div>
                </div>
                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                  <div class="col-sm-4">
                    <label class="col-form-label fw-bold">First Name:</label>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-control"><?= htmlspecialchars($row["first_name"], ENT_QUOTES, 'UTF-8'); ?></div>
                  </div>
                </div>
                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                  <div class="col-sm-4">
                    <label class="col-form-label fw-bold">Last Name:</label>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-control"><?= htmlspecialchars($row["last_name"], ENT_QUOTES, 'UTF-8'); ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <label class="col-form-label fw-bold">Role:</label>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-control">Administrator</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
// Include footer.
require_once './footer.php';
// Close connection.
$conn->close();
?>
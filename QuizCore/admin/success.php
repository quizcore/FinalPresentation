<?php
// // In the individual PHP files, check if the constant indicating the application is defined.
// if (!defined('MY_APP')) {
//   // If the constant is not defined, redirect the user to the homepage and terminate the script.
//   header('Location: index.php');
//   exit;
// }
?>

<?php
define('MY_APP', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();



// Check if a success message is set in the session
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    // Unset the success message to prevent displaying it again on refresh
    unset($_SESSION['success_message']);
} else {
    // Redirect to another page if no success message is set
    header("Location: index.php");
    exit();
}

$pageTitle = "Update student success message";
require_once 'header.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- Admin Profile Card -->
        <div class="card shadow-lg p-3 mb-5 rounded">
          <h3 class="card-title text-center">Update message</h3>
          <div class="card-body">
            <div class="row mt-3">
              <div class="col-lg-12">

                <div class="row">
                <p><?php echo $successMessage; ?></p>
    <p><a href="index.php">Go back to homepage</a></p>
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
require_once 'footer.php'; ?>
<?php
define('MY_APP', true);
session_start();

// Check if the user is already logged in, if yes, redirect to admin page.
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
  header("Location: index.php");
  exit();
}

include_once 'dbconnection.php';

// Define variables and initialize with empty values.
$email = $password = "";
$email_err = $password_err = $login_err_msg = "";

// Processing form data when form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if email is empty.
  if (empty(trim($_POST["email"]))) {
    $email_err = "Email is empty";
  } else {
    $email = trim($_POST["email"]);
  }

  // Check if password is empty.
  if (empty(trim($_POST["password"]))) {
    $password_err = "Password is empty";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials.
  if (empty($email_err) && empty($password_err)) {
    // Prepare a select statement.
    $sql = "SELECT email, password FROM admin WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
      // Bind variables to the prepared statement as parameters.
      $stmt->bind_param("s", $email);

      // Attempt to execute the prepared statement.
      if ($stmt->execute()) {
        // Store result.
        $stmt->store_result();

        // Check if email exists, if yes then verify password.
        if ($stmt->num_rows == 1) {
          // Bind result variables.
          $stmt->bind_result($email, $stored_password);
          if ($stmt->fetch()) {
            if ($password === $stored_password) {
              // Password is correct, start a new session.
              session_start();

              // Store data in session variables.
              $_SESSION["loggedin"] = true;
              $_SESSION["admin_email"] = $email;

              // Redirect user to admin page.
              header("Location: index.php");
              exit;
            } else {
              // Display an error message if password is not valid.
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          // Display an error message if email doesn't exist.
          $email_err = "No account found with that email.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement.
      $stmt->close();
    }
  }

  // Collect all error messages.
  $all_error_msgs = [];

  if (!empty($email_err)) {
    array_push($all_error_msgs, $email_err);
  }

  if (!empty($password_err)) {
    array_push($all_error_msgs, $password_err);
  }

  if (count($all_error_msgs) > 0) {
    $login_err_msg = implode("<br>", $all_error_msgs);
  }
}

$pageTitle = "Admin Login";
require_once 'login-header.php';
?>

<style>
  .form-floating.position-relative {
    position: relative;
  }

  .field-icon-b {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 2;
  }
</style>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card shadow-lg rounded">
        <main class="form-signin w-100 m-auto">
          <form method="post" action="login.php">
            <h1 class="h3 mb-3 mt-5 fw-normal text-center fw-bold">ADMIN LOGIN</h1>

            <div class="pb-5 text-center"><i class="bi bi-person-circle" style="margin-left: -44px; font-size: 60px;"></i></div>

            <div class="form-floating">
              <input type="text" class="form-control rounded-3" id="floatingInput" name="email">
              <label for="floatingInput">Email address</label>
            </div>

            <div class="form-floating mt-3">
              <input type="password" class="form-control rounded-2" id="floatingPassword" name="password">
              <label for="floatingPassword">Password</label>
              <span toggle="#floatingPassword" class="bi bi-eye-slash field-icon-b toggle-password"></span>
            </div>

            <input id=signUpBtn type="submit" value="Login" class="mt-4 btn btn-lg btn-dark w-100 py-2">
          </form>

          <!-- Error message display -->
          <div id='loginErrorAlert' class='alert alert-danger d-flex alert-dismissible fade mt-3' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Error:'>
              <use xlink:href='#check-circle-fill' />
            </svg>
            <div>
              <?= $login_err_msg ?>
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
          </div>
        </main>
      </div>

      <script>
        // Toggle password show/hide.
        document.querySelectorAll(".toggle-password").forEach(function(button) {
          button.addEventListener("click", function() {
            // Toggle the classes for the eye icon
            this.classList.toggle("bi-eye-slash");
            this.classList.toggle("bi-eye");

            // Get the input element based on the "toggle" attribute of the clicked element
            var input = document.querySelector(this.getAttribute("toggle"));

            // Toggle the input type between password and text
            if (input.getAttribute("type") === "password") {
              input.setAttribute("type", "text");
            } else {
              input.setAttribute("type", "password");
            }
          });
        });

        // Login error alert.
        document.addEventListener('DOMContentLoaded', function() {
          const alert = document.getElementById('loginErrorAlert');

          <?php if (empty($login_err_msg)) : ?>
            alert.classList.remove('show');
          <?php else : ?>
            alert.classList.add('show');
          <?php endif; ?>

          const closeButton = document.querySelector('.btn-close');
          closeButton.addEventListener('click', function() {
            alert.classList.remove('show');
          });
        });
      </script>
    </div>
  </div>
</div>

<?php
require_once './login-footer.php';
$conn->close();
?>
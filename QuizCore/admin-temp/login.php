<?php
// Start the session.
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the user is already logged in, if yes, redirect to admin page.
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Define variables and initialize with empty values.
$email = $password = "";
$email_err = $password_err = $login_err = "";

$select = "SELECT email, password FROM admin";
$result = $conn->query($select);

// Processing form data when form is submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty.
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty.
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for valid login based on database entries
    $valid = False;

    // Validate credentials.
    if (empty($email_err) && empty($password_err)) {
        while ($row = $result->fetch_assoc()) {
            if ($row["email"] === $email && $row["password"] === $password) {
                // Password is correct, start a new session.
                session_start();
                $valid = True;

                // Store data in session variables.
                $_SESSION["loggedin"] = $valid;
                $_SESSION["admin_email"] = $email;

                // Redirect user to admin page.
                header("location: index.php");
            }
        }
        if ($valid === False) {
            // Email doesn't exist, display a generic error message.
            $login_err = "Invalid email or password.";
            echo "<script>alert(`$login_err`)</script>";
        }
    } else {
        $login_err = $email_err . " " . $password_err;
        echo "<script>alert(`$login_err`)</script>";
    }
}
?>

<?php
$pageTitle = "Admin Login";
require_once 'loginheader.php';
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

<main class="form-signin w-100 m-auto">
  <form method="post" action="login.php">
    <!-- <img class="mb-4" src="img/cwu_wildcat_spirit_mark_rgb.png" alt="" width="80" height="80"> -->
    <h1 class="h3 mb-3 mt-5 fw-normal">Please Login.</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating position-relative">
      <input type="password" id="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
      <span toggle="#password" class="fa fa-fw fa-eye field-icon-b toggle-password"></span>
    </div>

    <div class="form-check text-start my-3">
      <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
        Remember me
      </label>
    </div>
    <button class="btn btn-bd-red w-100 py-2" type="submit">Login</button>
  </form>
</main>

<script>
  document.querySelectorAll(".toggle-password").forEach(function(button) {
    button.addEventListener("click", function() {
      // Toggle the classes for the eye icon
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");

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
</script>

<?php
// Include footer.
require_once './footer.php';
?>
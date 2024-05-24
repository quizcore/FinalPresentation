<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Check if the send button was pressed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST['name']);
  $email = test_input($_POST['contactEmail']);
  $body = test_input($_POST['emailBody']);

  if (strlen($name) > 0 && strlen($email) > 0  && strlen($body) > 0) {
    $sql = "INSERT INTO contact(contact_name, contact_email, contact_message) VALUES('$name', '$email', '$body');";
    mysqli_query($conn, $sql);

    // Set a flag to indicate successful submission
    $success = true;
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$pageTitle = "Contact Us";
require_once 'header.php';
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const alert = document.querySelector('.alert');

    <?php if (isset($success) && $success === true) : ?>
      alert.classList.add('show');
    <?php else : ?>
      alert.classList.remove('show');
    <?php endif; ?>

    const closeButton = document.querySelector('.btn-close');
    closeButton.addEventListener('click', function() {
      alert.classList.remove('show');
    });
  });
</script>

<div class="container py-5">
  <div class="row d-flex align-items-center">
    <div class="col-md-6">
      <h1>Contact Us</h1>
      <p>
        If you have any questions or feedback, feel free to reach out to us.
      </p>
      <form method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" name="name" id="name" required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" name="contactEmail" id="email" required />
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="emailBody" rows="5" required></textarea>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <input type="submit" class="btn btn-bd-red btn-lg px-4" value="Send">
        </div>
      </form><br />

      <!-- Success message display -->
      <div id='myAlert' class='alert alert-success d-flex alert-dismissible fade' role='alert'>
        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'>
          <use xlink:href='#check-circle-fill' />
        </svg>
        <div>
          Your message has been sent successfully!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
      </div>

    </div>
    <div class="col-md-6 mt-3">
      <img src="./img/cwu-brand.jpeg" class="img-fluid rounded-5" alt="Contact Us Image">
    </div>
  </div>
</div>
<?php
// Include footer.
require_once 'footer.php';
?>
<?php
session_start();

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Check if the send button was pressed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST['name']);
  $email = test_input($_POST['contactEmail']);
  $body = test_input($_POST['emailBody']);

  if (strlen($name) > 0 && strlen($email) > 0  && strlen($body) > 0) {
    $sql = "INSERT INTO contact(contact_name, contact_email, contact_message) VALUES('$name', '$email', '$body');";
    mysqli_query($conn, $sql);

    // Success message after successful insert using alert
    echo "<script>alert('Your message has been sent successfully!');</script>";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$pageTitle = "Contact Us";
require_once 'header.php';
?>

<div class="container">
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
      <input type="submit" class="btn btn-bd-red btn-lg px-4 me-md-2" value="Send">
    </div>
  </form>

</div>
<?php
// Include footer.
require_once 'footer.php';
?>

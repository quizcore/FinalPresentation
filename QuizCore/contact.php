<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';

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

  function limitTextAreaCharacterLimit(textarea, limit) {
    if (textarea.value.length > limit) {
      textarea.value = textarea.value.substring(0, limit);
    }
  }
</script>

<div class="container py-5">
  <div class="row d-flex align-items-center">
    <div class="col-md-6">
      <h1>Contact Us</h1>
      <p>
        If you have any questions or feedback, feel free to reach out to us.
      </p>
      <div class="mt-4">
        <form method="POST">
          <label for="name" class="form-label">Name:</label>
          <div class="input-group mb-3">
            <span class="input-group-text">
              <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control" name="name" id="name" maxlength="70" placeholder="e.g. Dave Hall" required />
            <!-- tooltip -->
            <span class="input-group-text">
              <span class="quizcore-tooltip" data-bs-placement="bottom" title="FirstName LastName">
                <i class="bi bi-question-circle text-muted"></i>
              </span>
            </span>
          </div>
          <label for="email" class="form-label">Email Address:</label>
          <div class="input-group mb-3">
            <span class="input-group-text">
              <i class="bi bi-envelope-fill"></i>
            </span>
            <input type="email" class="form-control" name="contactEmail" id="email" maxlength="30" placeholder="e.g. dave.hall@mail.com" required />
            <!-- tooltip -->
            <span class="input-group-text">
              <span class="quizcore-tooltip" data-bs-placement="bottom" title="Enter an email address for us to respond to.">
                <i class="bi bi-question-circle text-muted"></i>
              </span>
            </span>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message:</label>
            <textarea class="form-control" id="message" name="emailBody" rows="5" oninput="limitTextAreaCharacterLimit(this, 290)" placeholder="Please keep your text within a maximum of 290 characters" required></textarea>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <input type="submit" class="btn btn-bd-red btn-lg px-4" value="Send">
          </div>
        </form>
      </div>

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
      <img src="./img/cwu-brand.jpeg" class="img-fluid rounded-3" alt="Contact Us Image">
    </div>
  </div>
</div>

<?php
require_once 'footer.php';
$conn->close();
?>
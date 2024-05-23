<?php
// Include the database connection file.
include_once 'dbconnection.php';

// Start the session.
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

// Start the session.
session_start();

if (isset($_GET['messageId'])) {
  // Get messageId from query parameter
  $messageId = $_GET['messageId'];
} else {
  // Display default contact with ID 1
  $messageId = 1;  // Set the default contact ID
}

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT * FROM contact WHERE contact_id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $contactDetails = $result->fetch_assoc();
  // Display contact data using $contactDetails
} else {
  echo "Contact not found.";  // Handle case where default contact is not found
}

// Set page title
$pageTitle = "Contact Details";
require_once 'header.php';
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Message</h1>
  </div>

  <!-- Contact Card -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Contact Profile Card -->
        <div class="card shadow-lg p-3 mb-5 rounded">
          <div class="card-body">
            <h5 class="card-title text-center"><?= htmlspecialchars($contactDetails["contact_name"]) ?></h5>
            <hr>
            <p class="card-text text-center"><?= htmlspecialchars($contactDetails["contact_email"]) ?></p>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><?= htmlspecialchars($contactDetails["contact_message"]) ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
// Include footer.
require_once './footer.php';

// Close the statement and database connection.
$stmt->close();
$conn->close();
?>
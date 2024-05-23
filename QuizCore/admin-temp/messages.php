<?php

declare(strict_types=1);

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

$pageTitle = "Contact Messages";
require_once 'header.php';

// Fetch messages from the database
$messages = fetchMessages($conn);

/**
 * Fetches messages from the database.
 *
 * @param mysqli $conn The database connection.
 * @return array An array of messages.
 */
function fetchMessages(mysqli $conn): array
{
  $messages = [];
  $select = "SELECT * FROM contact";
  $result = $conn->query($select);

  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $messages[] = $row;
    }
  } else {
    // Handle query error (consider logging the error instead of exposing it to the user)
    die("Failed to retrieve messages: " . $conn->error);
  }

  return $messages;
}
?>

<!--Main-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Contact Messages</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="quizcore-messages-table" class="table table-striped table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($messages)) : ?>
                    <?php foreach ($messages as $row) : ?>
                      <tr data-message-id="<?= htmlspecialchars($row['contact_id'], ENT_QUOTES, 'UTF-8') ?>">
                        <td><?= htmlspecialchars($row['contact_id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['contact_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['contact_email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['contact_message'], ENT_QUOTES, 'UTF-8') ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="4"><?= isset($error) ? $error : 'No messages found.' ?></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
</div>
</div>

<script>
  // Messages table.
  document.addEventListener('DOMContentLoaded', function() {
    new DataTable('#quizcore-messages-table', {
      scrollY: "100vh",
      scrollX: true,
      scrollCollapse: true,
    });
  });

  // redirectToStudentPage
  const tableRows = document.querySelectorAll('tr[data-message-id]'); // Select rows with data-message-id attribute

  tableRows.forEach(row => {
    row.addEventListener('click', (event) => {
      // Get the contact ID from the data attribute with updated name
      const contactId = row.dataset.messageId;

      // Redirect to student info page with ID parameter
      window.location.href = `message-detail.php?mess_id=${contactId}`;
    });
  });
</script>

<?php
// Include footer.
require_once './footer.php';
// Close the database connection.
$conn->close();
?>
<?php
define('MY_APP', true);
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

require_once 'dbconnection.php';

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

$pageTitle = "Contact Messages";
require_once 'header.php';
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
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  // Messages table.
  document.addEventListener('DOMContentLoaded', function() {
    // Setup - add a text input to each footer cell
    $('#quizcore-messages-table tfoot th').each(function(i) {
      var $headerTh = $('#quizcore-messages-table thead th').eq($(this).index());
      var title = $headerTh.text();
      var headerWidth = $headerTh.width(); // Get the width of the corresponding header cell

      $(this).html(
        '<input type="text" placeholder="' + title + '" data-index="' + i + '" style="width: ' + headerWidth + 'px;"/>'
      );
    });

    /** @type {HTMLElement} */
    const quizcoreStudentsTable = document.querySelector('#quizcore-messages-table');

    const table = new DataTable(quizcoreStudentsTable, {
      scrollY: "100vh",
      scrollX: true,
      scrollCollapse: true,
    });

    // Filter event handler
    $(table.table().container()).on('keyup', 'tfoot input', function() {
      table
        .column($(this).data('index'))
        .search(this.value)
        .draw();
    });
  });

  /** @type {NodeListOf<HTMLTableRowElement>} */
  const tableRows = document.querySelectorAll('tr[data-message-id]');

  tableRows.forEach(row => {
    row.addEventListener('click', (event) => {
      // Get the message ID from the data attribute
      /** @type {string} */
      const messageId = row.dataset.messageId;

      // Open the message info page in a new tab with the ID parameter
      window.open(`message-detail.php?id=${messageId}`, '_blank');
    });
  });
</script>

<?php
// Include footer.
require_once './footer.php';
// Close the database connection.
$conn->close();
?>
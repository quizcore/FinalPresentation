<?php
// Include the database connection file.
include_once 'dbconnection.php';

// Start the session.
session_start();


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
                  <!-- Dynamically pull all messages from database -->
                  <?php
                  $select = "SELECT * FROM contact";
                  $result = $conn->query($select);
                  while ($row = $result->fetch_assoc()) {
                    // Get the contact ID
                    $contact_id  = $row["contact_id"];
                    echo '<tr data-message-id="' . $contact_id . '">';

                    echo '<td>' . $row["contact_id"] . '</td>';
                    echo '<td>' . $row["contact_name"] . '</td>';
                    echo '<td>' . $row["contact_email"] . '</td>';
                    echo '<td>' . $row["contact_message"] . '</td>';
                    echo '</tr>';
                  }
                  ?>
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
?>
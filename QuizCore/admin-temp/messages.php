<?php
session_start();
//delete later
$_SESSION['servername'] = "localhost";
$_SESSION['username'] = "root";
$_SESSION['password'] = "";
$_SESSION['dbname'] = "quizcore";
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);


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
              <table id="messages" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
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


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>


<script>
  $(document).ready(function() {
    $("#messages").DataTable({
      scrollY: "360px",
      scrollX: true,
      scrollCollapse: true,
    });
  });
</script>
<!-- redirect To Student Page -->
<script>
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
require_once './ad-footer.php';
?>
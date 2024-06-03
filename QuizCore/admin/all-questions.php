<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

// Start the session.
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

require_once 'dbconnection.php';

$result = $conn->query("SELECT * FROM questions");

$pageTitle = "All Questions";
require_once 'header.php';
?>

<!--main-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">List of all questions</h1>
  </div>

  <!--Data table-->
  <div class="container-fluid" style="font-size: 14px;">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Questions</h3>
          </div>
          <div class="card-body">

            <!-- table entry-->
            <table id="quizcore-questions-table" class="table table-striped table-sm" cellspacing="0" width="100%">

              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Di.</th>
                  <th scope="col">Question Body</th>
                  <th scope="col">Choice 1</th>
                  <th scope="col">Choice 2</th>
                  <th scope="col">Choice 3</th>
                  <th scope="col">Choice 4</th>
                  <th scope="col">Answer</th>
                </tr>
              </thead>
              <tbody>
                <?php
                function prepareScriptInput($text)
                {
                  return str_replace('`', '\\`', $text);
                }

                // Function to build table rows
                function buildTableRow(array $row): void
                {
                  // Get the student ID
                  $question_id  = htmlspecialchars($row["question_id"], ENT_QUOTES, 'UTF-8');
                  echo '<tr
                        data-bs-toggle="' . "tooltip" . '"
                        data-bs-placement="' . "top" . '"
                        data-bs-title="' . "Tooltip on top" . '"
                        data-question-id="' . $question_id . '"
                      >';

                  // add a tag on question_id
                  echo '<td>' . htmlspecialchars($question_id, ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '<td>' . htmlspecialchars($row["difficulty"], ENT_QUOTES, 'UTF-8') . '</td>';
                  // echo '<td>' . htmlspecialchars($row["question_body"], ENT_QUOTES, 'UTF-8') . '</td>';
                  // Question Body.
                  echo '<td id="question-body-' . $question_id . '">';
                  echo '  <script>document.getElementById("question-body-'  . $question_id . '").innerHTML=marked.parse(`' . prepareScriptInput($row["question_body"]) . '`);</script>';
                  echo '</td>';
                  // Choices.
                  for ($i = 1; $i <= 4; $i++) {
                    echo '<td id="answer-' . $i . '-' . $question_id . '">';
                    echo '  <script>document.getElementById("answer-' . $i . '-' . $question_id . '").innerHTML=marked.parse(`' . prepareScriptInput($row["answer_$i"]) . '`);</script>';
                    echo '</td>';
                  }
                  echo '<td>' . htmlspecialchars("Choice " . ($row["question_answer"] + 1), ENT_QUOTES, 'UTF-8') . '</td>';
                  echo '</tr>';
                }

                // Loop through the result set
                foreach ($result as $row) {
                  buildTableRow($row);
                }

                // Free result set
                $result->free();
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Di.</th>
                  <th>Question Body</th>
                  <th>Choice 1</th>
                  <th>Choice 2</th>
                  <th>Choice 3</th>
                  <th>Choice 4</th>
                  <th>Correct Answer</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  // Students table.
  document.addEventListener('DOMContentLoaded', function() {
    // Setup - add a text input to each footer cell
    $('#quizcore-questions-table tfoot th').each(function(i) {
      var $headerTh = $('#quizcore-questions-table thead th').eq($(this).index());
      var title = $headerTh.text();
      var headerWidth = $headerTh.width(); // Get the width of the corresponding header cell

      $(this).html(
        '<input type="text" placeholder="' + title + '" data-index="' + i + '" style="width: ' + headerWidth + 'px;"/>'
      );
    });

    /** @type {HTMLElement} */
    const quizcoreStudentsTable = document.querySelector('#quizcore-questions-table');

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
</script>

<?php
// Include footer.
require_once 'footer.php';

// Close the database connection
$conn->close();
?>
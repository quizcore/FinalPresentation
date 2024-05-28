<?php
define('MY_APP', true);
session_start();
require_once 'dbconnection.php';
require_once 'functions.php';

// Fetch questions.
// Prepare the query to count questions with difficulty = '1'
$count_query = "SELECT COUNT(*) AS question_count FROM questions WHERE difficulty = '1'";

$count_result = $conn->query($count_query);

if ($count_result->num_rows > 0) {
  $row = $count_result->fetch_assoc();
  $total_questions = $row['question_count'];
} else {
  // Handle error if no count retrieved
  die("Error: Could not count questions.");
}

// If there are more than 5 questions, select 5 randomly
if ($total_questions > 5) {
  // Prepare the query to select random questions
  $select = "SELECT * FROM questions WHERE difficulty = '1' ORDER BY RAND() LIMIT 5";
} else {
  // If there are less than 5 questions, select all
  $select = "SELECT * FROM questions WHERE difficulty = '1'";
}

$result = $conn->query($select);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	processStudentAnswers($conn);

	header("Location: exam-cs110-s2.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 1</h2>
</div>

<!-- Progress bar -->
<?= generateProgressBar(25) ?>

<div class="container">
	<!--Questions pulled from database-->
	<form id="Q1" method="post" action="#">
		<?php displayQuestions($result); ?>
		<div class="container d-grid gap-2 d-md-grid justify-content-md-center">
			<input type="submit" value="Next" class="btn btn-lg btn-bd-red">
		</div>
	</form>
</div>

<?php
require_once 'exam-footer.php';
$conn->close();
?>
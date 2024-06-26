<?php
define('MY_APP', true);
session_start();
require_once 'dbconnection.php';
require_once 'functions.php';

if (!checkExamSectionDone($conn, 5)) {
	die('You have taken this section.');
}

if (!checkCS111Accessible($conn)) {
	die('CS111 exam sections are not available based on your score.');
}

// Fetch questions.
$select = "SELECT * FROM questions WHERE difficulty = 5 ORDER BY RAND() LIMIT 5";
$result = $conn->query($select);
if (!$result) {
	die("Error executing query: " . $conn->error);
}
$rows = $result->fetch_all();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	processStudentAnswers($conn);

	header("Location: exam-cs111-s3.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 5</h2>
</div>

<!-- Progress bar -->
<?= generateProgressBar(40) ?>

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
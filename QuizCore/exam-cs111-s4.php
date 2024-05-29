<?php
define('MY_APP', true);
session_start();
require_once 'dbconnection.php';
require_once 'functions.php';

if (!checkExamSectionDone($conn, 7)) {
	die('You have taken this section');
}

// Fetch questions.
$select = "SELECT * FROM questions WHERE difficulty = 7 ORDER BY RAND() LIMIT 5";
$result = $conn->query($select);
if (!$result) {
	die("Error executing query: " . $conn->error);
}
$rows = $result->fetch_all();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	processStudentAnswers($conn);

	$score = getStudentScore($conn);
	$_SESSION["score"] = $score;
	header("Location: exam-final-results.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 7</h2>
</div>

<!-- Progress bar -->
<?= generateProgressBar(80) ?>

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
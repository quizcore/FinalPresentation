<?php
define('MY_APP', true);
session_start();
require_once 'dbconnection.php';
require_once 'functions.php';

$select = "SELECT * FROM questions WHERE difficulty = '3'";
$result = $conn->query($select);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Check answers and display results
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$question_id = $row["question_id"];
			$correct_answer = $row["question_answer"];
			$selected_answer = $_POST["$question_id"];

			// Check if the selected answer is correct
			if ($selected_answer == $correct_answer) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
		}
	}

	$a11 = $_POST['11'];
	$a12 = $_POST['12'];
	$a13 = $_POST['13'];
	$a14 = $_POST['14'];
	$a15 = $_POST['15'];
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];

	// Prepare the SQL statement with placeholders.
	$sql = "UPDATE students SET question_11 = ?, question_12 = ?, question_13 = ?, question_14 = ?, question_15 = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement.
	$stmt = $conn->prepare($sql);
	if ($stmt === false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders.
	$stmt->bind_param('iiiiiis', $a11, $a12, $a13, $a14, $a15, $score, $email);

	// Execute the prepared statement.
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	$stmt->close();

	if ($score >= 11) {
		header("Location: exam-mid-results.php");
	} else {
		header("Location: exam-final-results.php");
	}
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 3</h2>
</div>

<!-- Progress bar -->
<?= generateProgressBar(75) ?>

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
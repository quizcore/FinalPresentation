<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';
require_once 'functions.php';

$select = "SELECT * FROM questions WHERE difficulty = '7'";
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

	$a31 = $_POST['31'];
	$a32 = $_POST['32'];
	$a33 = $_POST['33'];
	$a34 = $_POST['34'];
	$a35 = $_POST['35'];
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];

	// Prepare the SQL statement with placeholders.
	$sql  = "UPDATE students SET question_31 = ?, question_32 = ?, question_33 = ?, question_34 = ?, question_35 = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement.
	$stmt = $conn->prepare($sql);
	if ($stmt === false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders.
	$stmt->bind_param('iiiiiis', $a31, $a32, $a33, $a34, $a35, $score, $email);

	// Execute the prepared statement.
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	$stmt->close();

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
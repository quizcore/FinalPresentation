<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';
require_once 'functions.php';

$select = "SELECT * FROM questions WHERE difficulty = '2'";
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

	$a6 = $_POST['6'];
	$a7 = $_POST['7'];
	$a8 = $_POST['8'];
	$a9 = $_POST['9'];
	$a10 = $_POST['10'];
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];

	// Prepare the SQL statement with placeholders.
	$sql = "UPDATE students SET question_6 = ?, question_7 = ?, question_8 = ?, question_9 = ?, question_10 = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement.
	$stmt = $conn->prepare($sql);
	if ($stmt == false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders.
	$stmt->bind_param('iiiiiis', $a6, $a7, $a8, $a9, $a10, $score, $email);

	// Execute the prepared statement.
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	$stmt->close();

	header("Location: exam-cs110-s3.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 2</h2>
</div>

<!-- Progress bar -->
<?= generateProgressBar(50) ?>

<div class="container">
	<!--Questions pulled from database-->
	<form id="Q2" method="post" action="#">
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
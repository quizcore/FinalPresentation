<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';
require_once 'functions.php';

$_SESSION['score'] = 0;

$select = "SELECT * FROM questions WHERE difficulty = '1'";
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

	$a1 = $_POST['1'];
	$a2 = $_POST['2'];
	$a3 = $_POST['3'];
	$a4 = $_POST['4'];
	$a5 = $_POST['5'];
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];

	// Prepare the SQL statement with placeholders.
	$sql  = "UPDATE students SET question_1 = ?, question_2 = ?, question_3 = ?, question_4 = ?, question_5 = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement.
	$stmt = $conn->prepare($sql);
	if ($stmt === false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders.
	$stmt->bind_param('iiiiiis', $a1, $a2, $a3, $a4, $a5, $score, $email);

	// Execute the prepared statement.
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	$stmt->close();

	header("Location: exam-cs110-s2.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 1</h2>
</div>

<!-- Progress bar -->
<?php echo generateProgressBar(25); ?>

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
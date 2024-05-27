<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';
require_once 'functions.php';

$select = "SELECT * FROM questions WHERE difficulty = '5'";
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

	$a21 = $_POST['21'];
	$a22 = $_POST['22'];
	$a23 = $_POST['23'];
	$a24 = $_POST['24'];
	$a25 = $_POST['25'];
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];

	// Prepare the SQL statement with placeholders.
	$sql  = "UPDATE students SET question_21 = ?, question_22 = ?, question_23 = ?, question_24 = ?, question_25 = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement.
	$stmt = $conn->prepare($sql);
	if ($stmt === false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders.
	$stmt->bind_param('iiiiiis', $a21, $a22, $a23, $a24, $a25, $score, $email);

	// Execute the prepared statement.
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	$stmt->close();

	header("Location: exam-cs111-s3.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 5</h2>
</div>

<!-- Progress bar -->
<?php echo generateProgressBar(40); ?>

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
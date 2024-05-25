<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';
// Include functions file
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
	$sql = "UPDATE students SET question_31 = $a31, question_32 = $a32, question_33 = $a33, question_34 = $a34, question_35 = $a35, score = $score WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $sql);

	header("Location: exam-final-results.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 7</h2>
</div>

<!-- Progress bar -->
<?php echo generateProgressBar(80); ?>

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
// Include footer.
require_once 'exam-footer.php';

// Close the database connection
$conn->close();
?>
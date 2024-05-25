<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';
// Include functions file
require_once 'functions.php';

$select = "SELECT * FROM questions WHERE difficulty = '6'";
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

	$a26 = $_POST['26'];
	$a27 = $_POST['27'];
	$a28 = $_POST['28'];
	$a29 = $_POST['29'];
	$a30 = $_POST['30'];

	$score = $_SESSION['score'];
	$sql = "UPDATE students SET question_26 = $a26, question_27 = $a27, question_28 = $a28, question_29 = $a29, question_30 = $a30, score = $score WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $sql);

	header("Location: exam-cs111-s4.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 6</h2>
</div>

<!-- Progress bar -->
<?php echo generateProgressBar(60); ?>

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
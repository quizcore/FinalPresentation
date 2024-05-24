<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';

$select = "SELECT * FROM questions WHERE difficulty = '2'";
$result = $conn->query($select);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$a6 = $_POST['6'];
	$a7 = $_POST['7'];
	$a8 = $_POST['8'];
	$a9 = $_POST['9'];
	$a10 = $_POST['10'];

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($a6 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a7 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a8 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a9 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a10 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
		}
	}

	$sql = "UPDATE students SET question_6 = '$a6', question_7 = '$a7', question_8 = '$a8', question_9 = '$a9', question_10 = '$a10' WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $sql);

	header("Location: exam-cs110-s3.php");
}

$pageTitle = "Exam";
require_once 'exam-header.php';
// Include functions file
require_once 'functions.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 2</h2>
</div>

<!-- Progress bar -->
<!-- Progress bar -->
<?php echo generateProgressBar(50); ?>

<div class="container">
	<!--Questions pulled from database-->
	<form id="Q2" method="post" action="#">
		<?php
		if ($result->num_rows > 0) {
			// output data of each row
			while ($row = $result->fetch_assoc()) {
				echo '<div class="container shadow p-3 my-5 bg-body-tertiary rounded">';
				echo '<h4>' . $row["question_body"] . '</h4>';
				echo '<div class="form-check">';
				echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-A" name="' . $row["question_id"] . '" value="' . $row["answer_1"] . '" required>';
				echo '<label class="form-check-label" for="'  . $row["question_id"] . '-A">A: ' . $row["answer_1"] . '</label><br>';
				echo '</div>';
				echo '<div class="form-check">';
				echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-B" name="' . $row["question_id"] . '" value="' . $row["answer_2"] . '" required>';
				echo '<label class="form-check-label" for="'  . $row["question_id"] . '-B">B: ' . $row["answer_2"] . '</label><br>';
				echo '</div>';
				echo '<div class="form-check">';
				echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-C" name="' . $row["question_id"] . '" value="' . $row["answer_3"] . '" required>';
				echo '<label class="form-check-label" for="'  . $row["question_id"] . '-C">C: ' . $row["answer_3"] . '</label><br>';
				echo '</div>';
				echo '<div class="form-check">';
				echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-D" name="' . $row["question_id"] . '" value="' . $row["answer_4"] . '" required>';
				echo '<label class="form-check-label" for="'  . $row["question_id"] . '-D">D: ' . $row["answer_4"] . '</label><br>';
				echo '</div>';
				echo '</div>';
			}
		}
		?>
		<div class="container d-grid gap-2 d-md-grid justify-content-md-center">
			<input type="submit" value="Next" class="btn btn-lg btn-bd-red">
		</div>
	</form>
</div>

<?php
// Include footer.
require_once 'exam-footer.php';
?>
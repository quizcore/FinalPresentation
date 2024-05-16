<?php
session_start();

$_SESSION['score'] = 0;

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

$select = "SELECT * FROM questions WHERE difficulty = '1'";
$result = $conn->query($select);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$a1 = $_POST['1'];
	$a2 = $_POST['2'];
	$a3 = $_POST['3'];
	$a4 = $_POST['4'];
	$a5 = $_POST['5'];

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($a1 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a2 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a3 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a4 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
			if ($a5 == $row['question_answer']) {
				$_SESSION['score'] = $_SESSION['score'] + 1;
			}
		}
	}

	$sql = "UPDATE students SET question_1 = '$a1', question_2 = '$a2', question_3 = '$a3', question_4 = '$a4', question_5 = '$a5' WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $sql);
	header("Location: CS110Q2.php");
}

$pageTitle = "Exam";
require_once 'testheader.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 1</h2>
</div>

<div class="container">
	<!--Questions pulled from database-->
	<form id="Q1" method="post" action="#">
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
require_once 'testfooter.php';
?>
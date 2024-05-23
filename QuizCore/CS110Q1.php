<?php
session_start();

$_SESSION['score'] = 0;

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Prepare the query to count questions with difficulty = '1'
$count_query = "SELECT COUNT(*) AS question_count FROM questions WHERE difficulty = '1'";

$count_result = $conn->query($count_query);

if ($count_result->num_rows > 0) {
  $row = $count_result->fetch_assoc();
  $total_questions = $row['question_count'];
} else {
  // Handle error if no count retrieved
  die("Error: Could not count questions.");
}

// If there are more than 5 questions, select 5 randomly
if ($total_questions > 5) {
  // Prepare the query to select random questions
  $select = "SELECT * FROM questions WHERE difficulty = '1' ORDER BY RAND() LIMIT 5";
} else {
  // If there are less than 5 questions, select all
  $select = "SELECT * FROM questions WHERE difficulty = '1'";
}

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
// Include functions file
require_once 'functions.php';
?>
<!--Main-->
<!--Main Div-->
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
// Include footer.
require_once 'testfooter.php';
?>
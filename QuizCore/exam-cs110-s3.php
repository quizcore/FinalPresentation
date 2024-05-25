<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';
// Include functions file
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
	$sql = "UPDATE students SET question_11 = $a11, question_12 = $a12, question_13 = $a13, question_14 = $a14, question_15 = $a15, score = $score WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $sql);

	if ($score >= 11) {
		header("Location: exam-mid-results.php");
	} else {
		header("Location: exam-final-results.php");
	}
}

$pageTitle = "Exam";
require_once 'exam-header.php';
?>
<!--Main-->
<!--Main Div-->
<div class="container shadow p-3 my-5 bg-body-tertiary rounded">
	<h2>Exam Question Set: 3</h2>
</div>

<!-- Progress bar -->
<!-- Progress bar -->
<?php echo generateProgressBar(75); ?>

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
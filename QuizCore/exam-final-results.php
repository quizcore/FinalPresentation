<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';
require_once 'functions.php';
$pageTitle = "Result";
require_once 'exam-header.php';
?>

<div class='container shadow p-3 my-5 bg-body-tertiary rounded'>
	<h2>Thank you for completing the test!</h2>
	<br><br>
	<h3>Please speak with an advisor about your results and to find out which course is recommended for you.</h3>

	<?php
	$score = $_SESSION['score'];
	$email = $_COOKIE['student'];
	$course = 110;
	if ($score >= 25) {
		$course = 1;
	} else if ($score < 25 && $score >= 11) {
		$course = 111;
	}

	// Prepare the SQL statement with placeholders
	$sql = "UPDATE students SET recommendation = ?, score = ? WHERE email = ?";

	// Initialize a prepared statement
	$stmt = $conn->prepare($sql);
	if ($stmt === false) {
		die('Prepare failed: ' . $conn->error);
	}

	// Bind the parameters to the placeholders
	$stmt->bind_param('sis', $course, $score, $email);

	// Execute the prepared statement
	if (!$stmt->execute()) {
		die('Execute failed: ' . $stmt->error);
	}

	// Close the statement
	$stmt->close();
	?>

	<!-- Progress bar -->
	<?= generateProgressBar(100) ?>
</div>

<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>
	<button type='button' class='btn btn-lg btn-bd-red' id='quizcore-home-btn'>Home</button> <br />
</div>
<script>
	document.getElementById('quizcore-home-btn').addEventListener('click', function() {
		window.location.href = './';
	});
</script>

<?php
require_once 'exam-footer.php';
$conn->close();
?>
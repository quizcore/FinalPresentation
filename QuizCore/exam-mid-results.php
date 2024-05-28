<?php
define('MY_APP', true);
session_start();

require_once 'dbconnection.php';
require_once 'functions.php';
$pageTitle = "Result";
require_once 'exam-header.php';
?>

<div class='container shadow p-3 my-5 bg-body-tertiary rounded'>
	<?php if ($_SESSION['score'] >= 11) : ?>
		<h3>Great job on the first half of the exam! Your performance so far has qualified you to continue with the rest of the exam.</h3>
		<br><br>

		<!-- Progress bar -->
		<?= generateProgressBar(100) ?>

		<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>
			<button type='button' class='btn btn-lg btn-bd-red' id='continueBtn'>Continue</button> <br />
		</div>
		<script>
			document.getElementById('continueBtn').addEventListener('click', function() {
				window.location.href = './exam-cs111-s1.php'
			});
		</script>
	<?php else : ?>
		<h2>Thank you for completing the test!</h2>
		<br><br>
		<h3>Please talk to an advisor about your results, and to learn what course is recommended for you to take.</h3>

		<?php
		$course = 110;
		$score = $_SESSION['score'];
		$email = $_COOKIE['student'];

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

		<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>
			<button type='button' class='btn btn-lg btn-bd-red' id='quizcore-home-btn'>Home</button> <br />
		</div>
		<script>
			document.getElementById('quizcore-home-btn').addEventListener('click', function() {
				window.location.href = './';
			});
		</script>";
	<?php endif; ?>
</div>

<?php
require_once 'exam-footer.php';
$conn->close();
?>
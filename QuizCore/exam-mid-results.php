<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';

$course = "";

$pageTitle = "Result";
require_once 'exam-header.php';
// Include functions file
require_once 'functions.php';

echo "<div class='container shadow p-3 my-5 bg-body-tertiary rounded'>";
if ($_SESSION['score'] >= 11) {
	echo "<h3>Great job on the first half of the exam! Your performance so far has qualified you to continue with the rest of the exam.</h3><br><br>";

	//<!-- Progress bar -->
	echo generateProgressBar(100);

	echo "<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>";
	echo "<button type='button' class='btn btn-lg btn-bd-red' id='continueBtn'>Continue</button> <br />";
	echo "</div>\n";
	echo "<script>\n";
	echo "  document.getElementById('continueBtn').addEventListener('click', function() {\n";
	echo "    window.location.href = './exam-cs111-s1.php';\n";
	echo "  });\n";
	echo "</script>";
} else {
	echo "<h2>Thank you for completing the test!</h2><br><br><h3>Please talk to an advisor about your results, and to learn what course is recommended for you to take.</h3>";
	$course = 110;
	$res = "UPDATE students SET recommendation = '$course', score = '$_SESSION[score]' WHERE email = '$_COOKIE[student]';";
	mysqli_query($conn, $res);

	//<!-- Progress bar -->
	echo generateProgressBar(100);

	echo "<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>";
	echo "<button type='button' class='btn btn-lg btn-bd-red' id='homeBtn'>Home</button> <br />";
	echo "</div>\n";
	echo "<script>\n";
	echo "  document.getElementById('homeBtn').addEventListener('click', function() {\n";
	echo "    window.location.href = './';\n";
	echo "  });\n";
	echo "</script>";
}

echo "</div>";

require_once 'exam-footer.php';

// Close the database connection
$conn->close();

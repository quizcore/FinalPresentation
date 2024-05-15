<?php
session_start();

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
$course = 0;

$pageTitle = "Result";
require_once 'testheader.php';

echo "<div class='container shadow p-3 my-5 bg-body-tertiary rounded'>";
echo "<h2>Thank you for completing the test!</h2><br><br><h3>Please talk to an advisor about your results, and to learn what course is recommended for you.</h3>";
if ($_SESSION['score'] >= 25) {
	$course = 112;
} else if ($_SESSION['score'] < 25 && $_SESSION['score'] >= 11) {
	$course = 111;
} else {
	$course = 110;
}

$res = "UPDATE students SET recommendation = '$course', score = '$_SESSION[score]' WHERE email = '$_COOKIE[student]';";
mysqli_query($conn, $res);

echo "</div>";
echo "<div class='container d-grid gap-2 d-md-grid justify-content-md-center'>";
echo "<button type='button' class='btn btn-lg btn-bd-red' id='homeBtn'>Home</button> <br />";
echo "</div>\n";
echo "<script>\n";
echo "  document.getElementById('homeBtn').addEventListener('click', function() {\n";
echo "    window.location.href = './';\n";
echo "  });\n";
echo "</script>";

$pageTitle = "Exam";
require_once 'testfooter.php';

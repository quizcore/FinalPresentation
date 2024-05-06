<?php
	session_start();
	
	$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
	$course = "";
	
	$pageTitle = "Result";
	require_once 'testheader.php';
	
	echo "<div class='container shadow p-3 my-5 bg-body-tertiary rounded'>";
		if($_SESSION['score'] >= 11) {
			echo "<h3>Great job on the first half of the exam, your performance so far allows you to continue on to the rest of the exam</h3><br><br>";
			echo "<a href='CS111Q1.php' class='btn btn-lg btn-bd-red w-100 py-2'>Continue</a><br><br><br>";
		} else {
			echo "<h2>Thank you for completing the test!</h2><br><br><h3>Please talk to an advisor about your results, and to learn what course is recommended for you to take.</h3>";
			$course = 110;
			$res = "UPDATE students SET recommendation = '$course', score = '$_SESSION[score]' WHERE email = '$_COOKIE[student]';";
			mysqli_query($conn, $res);
		}
	echo "</div>";
	
	$pageTitle = "Exam";
	require_once 'testfooter.php';
?>
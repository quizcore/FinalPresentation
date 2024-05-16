<?php
	session_start();
	
	$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
	$canStore = True;

	date_default_timezone_set("America/Los_Angeles");
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$first_name = test_input($_POST['firstName']);
		$last_name = test_input($_POST['lastName']);
		$email = test_input($_POST['email']);
		$dob = date('Y-m-d', strtotime($_POST['dob']));
		$date_taken = date('Y-m-d');
		
		if(strlen($first_name) > 0 && strlen($last_name) > 0 && strlen($email) > 0) {
			$select = "SELECT * FROM students";
			$result = $conn->query($select);
			
			$sql = "INSERT INTO students(first_name, last_name, dob, date_quiz_taken, email) VALUES('$first_name', '$last_name', '$dob', '$date_taken','$email');";
			
			// Allow insertion if the DB is empty
			if ($result->num_rows === 0 ) {
				mysqli_query($conn, $sql);
			}
			// Otherwise check the DB for dubplicate values before posting 
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if($row["email"] === $email) {
						$canStore = False;
					}
				}
				if ($canStore) {
					mysqli_query($conn, $sql);
				}
			}
		}
		
		if($canStore) {
			setcookie("student", $email, time() + 3600);
			$_COOKIE["student"] = $email;
			header("Location: exam2.php");
		}
	}
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$pageTitle = "Exam";
	require_once 'header.php';
?>

<!--Main-->
<!--Main Div-->
<div class="container">
  <!--Form-->
  <div id="myForm" class="form-signin w-100 m-auto">
    <form id="studentForm" method="post" action="#">
      <h1 class="h3 mb-3 fw-normal">Please provide your information</h1>

      <div class="form-floating">
        <input type="text" class="form-control" name="firstName" id="floatingInput1" placeholder="First Name" required>
        <label for="floatingInput1">First Name</label>
      </div>

      <div class="form-floating">
        <input type="text" class="form-control" name="lastName" id="floatingInput2" placeholder="Last Name" required>
        <label for="floatingInput2">Last Name</label>
      </div>

      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput3" placeholder="name@example.com" required>
        <label for="floatingInput3">Email address</label>
      </div>

      <div class="form-floating">
        <input type="date" min="1900-01-01" max="2006-09-01" class="form-control" name="dob" id="floatingPassword" placeholder="date of birth" required> 
        <label for="floatingPassword">Date of Birth</label>
      </div><br />

      <input id=signUpBtn type="submit" value="Sign Up" class="btn btn-lg btn-dark w-100 py-2"> 
	  
	  <?php
		if($canStore === False) {
			echo"<h3>Our records show that you have already completed the test</h3>";
		}
	  ?>
    </form>
  </div>
</div>

<?php
// Include footer.
require_once 'testfooter.php';
?>
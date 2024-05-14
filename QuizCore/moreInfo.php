<?php
	session_start();
	
	$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$sid = NULL;
		
		if(isset($_POST['sid'])) {
			$sid = test_input($_POST['sid']);
		}
		$term = $_POST['term'];
		$education = test_input($_POST['education']);
		$classes = test_input($_POST['classes']);
		
		$select = "SELECT * FROM students";
		$result = $conn->query($select);
			
		$sql = "UPDATE students SET sid = '$sid', expected_term = '$term', previous_education = '$education', previous_classes = '$classes' WHERE email = '$_COOKIE[student]';";
		mysqli_query($conn, $sql);
		header("Location: CS110Q1.php");
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
  <h1 class="h3 mb-3 fw-normal">Please provide information about your previous education.</h1>
  <!--Form-->
  <div id="myForm" class="form-signin w-100 m-auto">
    <form id="studentForm" method="post" action="#">
      <div class="form-floating">
		<select id="term" name="term" class="form-control" required>
		  <option value="Fall24">Fall 2024</option>
		  <option value="Winter25">Winter 2025</option>
		  <option value="Spring25">Spring 2025</option>
		</select>
	  </div>

      <div class="form-floating">  
		<span class="guide-text">If you are a current Central student, please provide your student ID.</br></span>
        <input type="text" class="form-control" name="sid" id="floatingInput" placeholder="Student ID">
        <label for="floatingInput">Student ID (Optional)</label>
      </div>

      <div class="form-floating">
		<span class="guide-text">If you are a student looking to transfer to Central, please provide your previous universities you've attended, and any previous computer science courses you've taken.</br></span>
        <input type="text" class="form-control" name="education" id="floatingInput" placeholder="Previous Universities" required>
        <label for="floatingInput">Previous Universities Attended</label>
      </div>

      <div class="form-floating">
        <textarea class="form-control" name="classes" id="floatingPassword" placeholder="Previous Classes" rows="8" cols="50" required> </textarea>
        <label for="floatingPassword">Previous Computer Science Courses</label>
      </div><br />

      <input type="submit" value="Submit" class="btn btn-lg btn-dark w-100 py-2"> 
	  <!--<button class="btn btn-lg btn-dark w-100 py-2" type="submit">Sign Up</button>-->
	  
    </form>
  </div>
</div>

<script>
  document
    .getElementById("quickStartBtn")
    .addEventListener("submit", function(event) {
      // Prevents the default form submission behavior.
      event.preventDefault();
      // Redirect to exam2.php.
      window.location.href = "exam2.php";
    });
</script>
<!--End of Main-->

<?php
// Include footer.
require_once 'testfooter.php';
?>
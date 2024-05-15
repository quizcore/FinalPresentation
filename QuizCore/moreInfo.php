<?php
session_start();

$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$sid = NULL;

	if (isset($_POST['sid'])) {
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

function test_input($data)
{
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
	<div class="container text-center">
		<h1 class="h3 my-4 fw-normal">Please provide information about your previous education.</h1>
	</div>

	<div id="myForm" class="form-signin w-100 m-auto">
		<form id="studentForm" method="post" action="#">

		<div class="form-group mb-3">
        <label for="term">Intended Enrollment Term</label>
        <select id="term" name="term" class="form-control" required>
          </select>
      </div>

			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingCentral">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCentral" aria-expanded="false" aria-controls="collapseCentral">
							Central Student
						</button>
					</h2>
					<div id="collapseCentral" class="accordion-collapse collapse" aria-labelledby="headingCentral" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<div class="form-group mb-3">
								<label for="sid">CWU Student ID</label>
								<input type="text" class="form-control" name="sid" id="floatingInput" placeholder="Student ID">
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="headingTransfer">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTransfer" aria-expanded="false" aria-controls="collapseTransfer">
							New or Transfer Student
						</button>
					</h2>
					<div id="collapseTransfer" class="accordion-collapse collapse" aria-labelledby="headingTransfer" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<div class="form-group mb-3">
								<label for="education">Previous Universities Attended</label>
								<textarea type="text" class="form-control" name="education" id="floatingInput" placeholder="Separate universities with commas (e.g., University of Central California, MIT" rows="4" cols="50"></textarea>
							</div>
							<div class="form-group mb-3">
								<label for="classes">Previous Computer Science Courses</label>
								<textarea class="form-control" name="classes" id="floatingPassword" placeholder="List each course on a new line, including course code (e.g., CS-101) and course name (e.g., Introduction to Computer Science)" rows="6" cols="50"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div><br/>

			<input id="signUpBtn" type="submit" value="Submit" class="btn btn-lg btn-dark w-100 py-2">

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
<script>
  const selectTerm = document.getElementById('term');
  const currentYear = new Date().getFullYear(); // Get current year

  // Function to create and add option elements
  function addTermOption(year, season) {
    const option = document.createElement('option');
    option.value = `${season}${year}`;
    option.text = `${season} ${year}`;
    selectTerm.appendChild(option);
  }

  // Loop through the next 2 years and add options for Fall, Winter, Spring, and Summer
  for (let year = currentYear; year < currentYear + 2; year++) {
    addTermOption(year, 'Fall');
    addTermOption(year, 'Winter');
    addTermOption(year, 'Spring');
    addTermOption(year, 'Summer');
  }
</script>

<?php
// Include footer.
require_once 'testfooter.php';
?>
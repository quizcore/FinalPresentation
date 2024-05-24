<?php
// Define a constant in the main application file to serve as a flag indicating that the application is being accessed.
define('MY_APP', true);

session_start();

// Include the database connection file.
include_once 'dbconnection.php';

$idError = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$sid = NULL;
	if (isset($_POST['sid']) && !empty($_POST['sid'])) {
		$sid = test_input($_POST['sid']);
		if (!is_numeric($sid)) {
			$idError = True;
		}
	}
	$term = $_POST['term'];
	$education = test_input($_POST['education']);
	$classes = test_input($_POST['classes']);

	$sql = "UPDATE students SET ";
	$sql .= "expected_term = '$term', ";
	$sql .= "previous_education = '$education', ";
	$sql .= "previous_classes = '$classes' ";
	// Add sid update only if it has a value
	if (isset($sid)) {
		$sql .= ", sid = '$sid' ";
	}
	$sql .= "WHERE email = '$_COOKIE[student]';";

	if ($idError == False) {
		mysqli_query($conn, $sql);
		header("Location: exam-cs110-s1.php");
	}
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$pageTitle = "Exam";
require_once 'exam-header.php';
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
					<option value="" disabled selected>Select Term</option>
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
								<input type="number" class="form-control" name="sid" id="floatingInput" placeholder="Student ID">
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
			</div><br />

			<input id="signUpBtn" type="submit" value="Submit" class="btn btn-lg btn-dark w-100 py-2">

			<?php
			if ($idError === True) {
				echo "<h3>Student ID should only contain numbers, please enter it again.</h3>";
			}
			?>

		</form>
	</div>
</div>

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
require_once 'exam-footer.php';
?>
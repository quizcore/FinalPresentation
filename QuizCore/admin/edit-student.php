<?php
// // In the individual PHP files, check if the constant indicating the application is defined.
// if (!defined('MY_APP')) {
//   // If the constant is not defined, redirect the user to the homepage and terminate the script.
//   header('Location: index.php');
//   exit;
// }
?>

<?php
define('MY_APP', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

include_once 'dbconnection.php';

$errors = array();

// Default student ID
$id = isset($_GET['id']) ? $_GET['id'] : 1;
// Prepare the SQL statement with placeholders.
$select = "SELECT * FROM students WHERE student_id = ?;";
// Initialize a prepared statement.
$stmt = $conn->prepare($select);
// Bind the parameters to the placeholders.
$stmt->bind_param("i", $id);
// Execute the prepared statement.
$stmt->execute();
// Get the result
$result = $stmt->get_result();
// Close statement.
$stmt->close();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if (!is_null($row)) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['id']);

            $updatedFields = array();
            if (isset($_POST['first_name']) && $_POST['first_name'] != $row['first_name']) {
                $updatedFields['first_name'] = mysqli_real_escape_string($conn, $_POST['first_name']);
            }

            // Repeat this for other fields like last_name, email, dob, start_term, etc.

            if (!empty($updatedFields)) {
                $updateQuery = "UPDATE students SET ";

                foreach ($updatedFields as $key => $value) {
                    $updateQuery .= "$key = ?, ";
                }

                $updateQuery = rtrim($updateQuery, ', ');
                $updateQuery .= " WHERE student_id = ?";

                $stmt = $conn->prepare($updateQuery);
                $bindTypes = str_repeat('s', count($updatedFields)) . 'i';
                $bindValues = array_values($updatedFields);
                $bindValues[] = $student_id;

                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param($bindTypes, ...$bindValues);

                if ($stmt->execute()) {
                    // Success message if the update is successful
                    $_SESSION['success_message'] = "Student information updated successfully!";
                    // Redirect to a success page
                    header("Location: success.php");
                    exit();
                } else {
                    // Error message if the update fails
                    echo "Error updating student information: " . $conn->error;
                }

                $stmt->close();
            } else {
                echo "No changes were made.";
            }
        } 
    } else {
        array_push($errors, "Student information not found.");
    }
}

$pageTitle = "Edit Student Information";
require_once 'header.php';
?>

<!-- Your HTML form for editing student information goes here -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Student Information</h1>
    </div>

    <form id="editStudentForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="hidden" name="id" value="<?php echo $row['student_id']; ?>">

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>">
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>">
        </div>

        <div class="mb-3">
            <label for="start_term" class="form-label">Start Term:</label>
            <input type="text" class="form-control" id="start_term" name="start_term" value="<?php echo $row['expected_term']; ?>">
        </div>

        <div class="mb-3">
            <label for="cwu_id" class="form-label">CWU ID:</label>
            <input type="text" class="form-control" id="cwu_id" name="cwu_id" value="<?php echo $row['sid']; ?>">
        </div>

        <div class="mb-3">
            <label for="previous_college" class="form-label">Previous College:</label>
            <input type="text" class="form-control" id="previous_college" name="previous_college" value="<?php echo $row['previous_education']; ?>">
        </div>

        <div class="mb-3">
            <label for="cs_courses" class="form-label">Relevant CS Courses:</label>
            <input type="text" class="form-control" id="cs_courses" name="cs_courses" value="<?php echo $row['previous_classes']; ?>">
        </div>

        <!-- Add more fields for other student information as needed -->


        <div class="container d-grid gap-2 d-md-grid justify-content-md-center">
            <input type="submit" value="Update Information" class="btn btn-lg btn-bd-red">
        </div>
    </form>
</main>


<?php
if (count($errors) > 0) {
    echo "<div class='alert alert-danger'>";
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo "</div>";
}

// Include footer.
require_once 'footer.php';
?>
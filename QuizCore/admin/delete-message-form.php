<?php
define('MY_APP', true);
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

require_once 'dbconnection.php';

// Check if the message ID is provided
if (isset($_GET['id'])) {
    $messageId = $_GET['id'];
} else {
    die("Message ID not provided");
}

// Fetch the contact details for the given message ID
$stmt = $conn->prepare("SELECT * FROM contact WHERE contact_id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $contactDetails = $result->fetch_assoc();
} else {
    die("Message not found");
}

// Set page title
$pageTitle = "Delete message";
require_once 'header.php';

$conn->close();
?>

<!--Main-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Admin Profile Card -->
                <div class="card shadow-lg p-3 mb-5 rounded">
                    <h3 class="card-title text-center">Delete Message</h3>
                    <br />
                    <p class="text-center">Are you sure you want to delete the following message?</p>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                                    <div class="col-sm-4">
                                        <label class="col-form-label fw-bold">Name:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-control"><?= htmlspecialchars($contactDetails['contact_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                </div>
                                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                                    <div class="col-sm-4">
                                        <label class="col-form-label fw-bold">Email:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-control"><?= htmlspecialchars($contactDetails['contact_email'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                </div>
                                <div class="row" style="border-bottom: 1px dashed #ccc; margin-bottom: 15px; padding-bottom: 15px;">
                                    <div class="col-sm-4">
                                        <label class="col-form-label fw-bold">Message:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-control"><?= htmlspecialchars($contactDetails['contact_message'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div><br/><br/><br/><br/>

                                    <form action="delete-message.php" method="POST">
                                        <div class="container d-grid gap-2 d-md-grid justify-content-md-center">
                                        <input type="hidden" name="id" value="<?php echo $messageId; ?>">
                                            <input type="submit" value="Delete" class="btn btn-lg btn-bd-red">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<?php

require_once 'footer.php';

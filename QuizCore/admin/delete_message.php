<?php
define('MY_APP', true);
session_start();

// Check if the user is not logged in, redirect them to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit();
}

require_once 'dbconnection.php';

// Check if the message ID is provided via POST
if (isset($_POST['id'])) {
    $messageId = $_POST['id'];

    // Prepare and execute the SQL statement to delete the message
    $stmt = $conn->prepare("DELETE FROM contact WHERE contact_id = ?");
    $stmt->bind_param("i", $messageId);
    $stmt->execute();
    $stmt->close();

    // Redirect back to a confirmation page or homepage after deletion
    header("Location: messages.php");
    exit();
} else {
    die("Message ID not provided");
}

$conn->close();
?>

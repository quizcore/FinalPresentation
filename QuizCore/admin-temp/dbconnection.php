<?php
// In the individual PHP files, check if the constant indicating the application is defined.
if (!defined('MY_APP')) {
    // If the constant is not defined, redirect the user to the homepage and terminate the script.
    header('Location: index.php');
    exit;
}

const DB_SERVERNAME = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_NAME = "quizcore";

// Create connection
$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

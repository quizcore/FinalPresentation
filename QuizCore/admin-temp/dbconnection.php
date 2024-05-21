<?php
// Define a constant to prevent direct access to files.
define('DB_ACCESS', TRUE);

// Include this file in all your scripts that require database connection.
// Check if DB_ACCESS is not defined to prevent access to this file directly.
if (!defined('DB_ACCESS')) {
    die('Direct access not allowed');
}

$_SESSION['servername'] = "localhost";
$_SESSION['username'] = "root";
$_SESSION['password'] = "";
$_SESSION['dbname'] = "quizcore";

// Create connection
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

<?php
// Define a constant to prevent direct access to files.
define('DB_ACCESS', TRUE);

// Include this file in all your scripts that require database connection.
// Check if DB_ACCESS is not defined to prevent access to this file directly.
if(!defined('DB_ACCESS')){
    die('Direct access not allowed');
}

// Your database connection code can be placed here.
// For example:
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizcore";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

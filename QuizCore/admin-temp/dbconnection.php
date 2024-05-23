<?php
// Define a constant to prevent direct access to files.
define('DB_ACCESS', TRUE);

// Include this file in all your scripts that require database connection.
// Check if DB_ACCESS is not defined to prevent access to this file directly.
if (!defined('DB_ACCESS')) {
    die('Direct access not allowed');
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

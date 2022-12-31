<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "ENTER_YOUR_USERNAME_HERE";
$dbPassword = "ENTER_YOUR_PASSWORD_HERE";
$dbName     = "userCalendar";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
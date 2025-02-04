<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Database username
$password = ""; // Database password
$database = "db_pos"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

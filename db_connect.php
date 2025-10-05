<?php
$servername = "localhost";
$username = "root";
$password = ""; // default password is blank in XAMPP
$dbname = "pitchboard"; // ✅ same name as your database in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

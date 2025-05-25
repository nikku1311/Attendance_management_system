<?php
$conn = new mysqli("localhost", "root", "Your sql password", "attendance_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

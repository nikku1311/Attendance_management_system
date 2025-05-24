<?php
$conn = new mysqli("localhost", "root", "nikku@13", "attendance_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
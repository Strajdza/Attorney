<?php
$conn = new mysqli("localhost", "root", "", "dule");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>
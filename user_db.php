<?php
$conn = new mysqli("localhost","root","","myappusers");
if($conn->connect_error) die("Connection failed:".$conn->connection_error);
?>
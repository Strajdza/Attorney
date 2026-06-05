<?php
session_start();


header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit(0);
}

include "user_db.php";

$ID = $_SESSION["user_id"]??null;

$sql = "SELECT ProfilePicture
        FROM user_info
        WHERE ID ='$ID' ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    

    echo json_encode([
        "success" => true,
        "profile_picture" => $row["ProfilePicture"]
        
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}
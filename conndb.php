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

$data = json_decode(file_get_contents("php://input"), true);

$email = $conn->real_escape_string($data['email'] ?? '');
$User = $conn->real_escape_string($data['user'] ?? '');
$Password = $conn->real_escape_string($data['password'] ?? '');

$sql = "SELECT * FROM user_info WHERE Username = '$User'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo json_encode([
        "successs" => true,
        "message" => "Username not available"
    ]);

} else {

    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    $insert = "INSERT INTO user_info (email, Username, Password)
               VALUES ('$email', '$User', '$hashedPassword')";

    if ($conn->query($insert) === TRUE) {

        echo json_encode([
            "success" => true,
            "message" => "User created successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Insert failed"
        ]);

    }
}

?>
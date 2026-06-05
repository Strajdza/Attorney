<?php
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "domain" => "localhost",
    "httponly" => true,
    "samesite" => "Lax"
]);
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

$User = $conn->real_escape_string($data['user'] ?? '');
$Password = $conn->real_escape_string($data['password'] ?? '');

$sql = "SELECT * FROM user_info WHERE Username = '$User' OR email='$User'";
$result = $conn->query($sql);
if($result ->num_rows>0){
    $row = $result->fetch_assoc();
    if(password_verify($Password,$row['Password'])){
        session_regenerate_id(true);
$_SESSION["user_id"] = $row["ID"];
    echo json_encode([
    "success"=>true,
    "message"=>"worked",]);
    }else {

        echo json_encode([
            "success" => false,
            "message" => "Wrong password"
        ]);
    }
}else {
    echo json_encode([
        "success" => false,
        "message" => "Wrong username/email or password"
    ]);
}
?>
<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") exit(0);

include "user_db.php";


$ID = $_SESSION["user_id"]??null;

if($ID){

    $query="SELECT * FROM user_info WHERE ID != $ID";
;
}else{
   $query="SELECT * FROM user_info";}
$users = [];
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $users[] = [
        "user" => $row["Username"],
        "id" => $row["ID"],
        "image" => $row["ProfilePicture"]
    ];
}

echo json_encode([
    "success" => true,
    "users" => $users
]);

exit;
?>
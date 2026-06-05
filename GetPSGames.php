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

include 'user_db.php';

$result = $conn-> query(
    "SELECT * from ps_games"
);
$PSgames=[];
while($row = $result->fetch_assoc()){
    $PSgames[]=[
        "name"=>$row["Game_Name"],
        "image"=>$row["Image"],
        "appid"=>$row["ID"]
    ];
}
echo json_encode([
    "success"=>true,
    "psgames"=>$PSgames
]);
?>
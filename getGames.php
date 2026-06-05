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

$ID = $_SESSION["user_id"];

$result = $conn->query(
    "SELECT game_name,appID,image,rawg_image FROM user_games WHERE user_id='$ID'"
);

$games = [];

while ($row = $result->fetch_assoc()) {
    $games[] =[
        "name"=>$row["game_name"],
        "appid" => $row["appID"],
        "image" => $row["image"],
        "rawg_image"=>$row["rawg_image"]
    ];
}
echo json_encode([
    "success" => true,
    "games" => $games
]);
?>
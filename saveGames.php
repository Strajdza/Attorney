<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") exit(0);

include "user_db.php";

$data = json_decode(file_get_contents("php://input"), true);

$ID = $_SESSION["user_id"];
$games = $data["games"];

$conn->query("DELETE FROM user_games WHERE user_id='$ID'");

foreach ($games as $game) {
    $gameName = $conn->real_escape_string($game);

    $conn->query(
        "INSERT INTO user_games(user_id, game_name)
         VALUES ('$ID', '$gameName')"
    );
}

echo json_encode([
    "success" => true
]);
?>
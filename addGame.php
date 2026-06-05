<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// handle preflight
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

include "user_db.php";

// check session FIRST
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "error" => "Not logged in"
    ]);
    exit;
}

$user_id = $_SESSION["user_id"];

// read JSON body
$raw = file_get_contents("php://input");
file_put_contents("debug.txt", $raw);
$data = json_decode($raw, true);

// debug safety
if (!$data) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid JSON",
        "raw" => $raw
    ]);
    exit;
}

// extract fields
$appID = $data["appID"] ?? null;
$name  = $data["name"] ?? null;
$image = $data["image"] ?? null;
$source = $data["source"] ?? "rawg";

// validation
if (!$appID || !$name) {
    echo json_encode([
        "success" => false,
        "error" => "Missing fields"
    ]);
    exit;
}

// check if already exists
$check = $conn->prepare("SELECT id FROM user_games WHERE user_id = ? AND appID = ?");
$check->bind_param("ii", $user_id, $appID);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "error" => "Game already exists"
    ]);
    exit;
}

// insert
$stmt = $conn->prepare("
    INSERT INTO user_games (user_id, game_name, image, appID, source)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("issss", $user_id, $name, $image, $appID, $source);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Game added"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "DB insert failed"
    ]);
}
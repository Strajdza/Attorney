<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Content-Type: application/json");

$name = $_GET["name"] ?? "";

if (!$name) {
    echo json_encode(["success" => false, "error" => "No name"]);
    exit;
}

$url = "https://api.rawg.io/api/games?key=01cc9075754b4483baae5789d6316d6a&search=" . urlencode($name);

$response = file_get_contents($url);
$data = json_decode($response, true);

$rawgImage = null;

if (!empty($data["results"])) {
    foreach ($data["results"] as $game) {
        if (!empty($game["background_image"])) {
            $rawgImage = $game["background_image"];
            break;
        }
    }
}

echo json_encode([
    "success" => true,
    "rawg_image" => $rawgImage
]);
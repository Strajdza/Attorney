<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include "user_db.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION["user_id"];

$data = json_decode(file_get_contents("php://input"), true);
$steamUrl = $data["steamUrl"] ?? "";

// validate steam id
if (!preg_match('/(\d{17})/', $steamUrl, $matches)) {
    echo json_encode(["success" => false, "error" => "Invalid Steam URL"]);
    exit;
}

$steamId = $matches[1];

$url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=021B19AC8342E5AC23A53B541FD1676E&steamid=$steamId&include_appinfo=1&format=json";

$response = file_get_contents($url);

if (!$response) {
    echo json_encode(["success" => false, "error" => "Steam API failed"]);
    exit;
}

$result = json_decode($response, true);
$games = $result["response"]["games"] ?? [];

foreach ($games as $game) {

    $appid = $game["appid"];
    $name  = $game["name"];

    $image = "https://cdn.cloudflare.steamstatic.com/steam/apps/$appid/header.jpg";

    // RAWG lookup (MUST use name AFTER defining it)
    $rawgImage = null;

    $rawgUrl = "https://api.rawg.io/api/games?key=01cc9075754b4483baae5789d6316d6a&search=" . urlencode($name);
    $rawgResponse = file_get_contents($rawgUrl);

    if ($rawgResponse) {
        $rawgData = json_decode($rawgResponse, true);

        if (!empty($rawgData["results"])) {

            foreach ($rawgData["results"] as $r) {
                if (strcasecmp($r["name"], $name) === 0) {
                    $rawgImage = $r["background_image"] ?? null;
                    break;
                }
            }

            if (!$rawgImage) {
                $rawgImage = $rawgData["results"][0]["background_image"] ?? null;
            }
        }
    }

    $stmt = $conn->prepare("
        INSERT INTO user_games (user_id, game_name, image, rawg_image, appID, source)
        VALUES (?, ?, ?, ?, ?, 'steam')
        ON DUPLICATE KEY UPDATE
            game_name = VALUES(game_name),
            image = VALUES(image),
            rawg_image = VALUES(rawg_image)
    ");

    $stmt->bind_param(
        "isssi",
        $user_id,
        $name,
        $image,
        $rawgImage,
        $appid
    );

    $stmt->execute();
}

echo json_encode(["success" => true]);
?>
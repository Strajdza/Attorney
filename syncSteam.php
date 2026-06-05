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

$STEAM_API_KEY = "021B19AC8342E5AC23A53B541FD1676E";

$ID = $_SESSION["user_id"] ?? null;

if (!$ID) {
    echo json_encode([
        "success" => false,
        "message" => "Not logged in"
    ]);
    exit;
}

$result = $conn->query("SELECT SteamID FROM user_info WHERE ID='$ID'");
$row = $result->fetch_assoc();

$steamId = $row["SteamID"] ?? null;

if (!$steamId) {
    echo json_encode([
        "success" => false,
        "message" => "No Steam account connected"
    ]);
    exit;
}

$gamesUrl = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key="
    . urlencode($STEAM_API_KEY)
    . "&steamid="
    . urlencode($steamId)
    . "&include_appinfo=true"
    . "&include_played_free_games=true"
    . "&format=json";

$gamesData = json_decode(file_get_contents($gamesUrl), true);
if (!$gamesData) {
    echo json_encode([
        "success" => false,
        "message" => "Steam API request failed"
    ]);
    exit;
}

if (!isset($gamesData["response"]["games"])) {
    echo json_encode([
        "success" => false,
        "message" => "No games returned from Steam",
        "steamResponse" => $gamesData
    ]);
    exit;
}


$games = $gamesData["response"]["games"] ?? [];

$gamesList = [];

$conn->query("DELETE FROM user_games WHERE user_id='$ID'");

foreach ($games as $game) {

    $appId = $game["appid"];
    $gameName = $game["name"];
    $image = "https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/$appId/library_600x900.jpg";

    $gamesList[] = [
        "name" => $gameName,
        "appid" => $appId,
        "image" => $image
    ];

    $safeName = $conn->real_escape_string($gameName);
    $safeAppId = $conn->real_escape_string($appId);
    $safeImage = $conn->real_escape_string($image);

    $conn->query(
        "INSERT INTO user_games(user_id, game_name, appID, image)
         VALUES ('$ID', '$safeName', '$safeAppId', '$safeImage')"
    );
}

echo json_encode([
    "success" => true,
    "games" => $gamesList
]);
?>
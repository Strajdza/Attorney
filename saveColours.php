<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}
include "user_db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "No data received"]);
    exit;
}

$colour1 = $data["colour1"] ?? null;
$colour2 = $data["colour2"] ?? null;
$colour3 = $data["colour3"] ?? null;

$userId = $_SESSION["user_id"] ?? null;

if (!$userId) {
    echo json_encode(["error" => "No session user"]);
    exit;
}

$stmt = $conn->prepare("
    UPDATE user_info
    SET colour1 = ?, colour2 = ?, colour3 = ?
    WHERE ID = ?
");

if (!$stmt) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$stmt->bind_param("sssi", $colour1, $colour2, $colour3, $userId);

if (!$stmt->execute()) {
    echo json_encode(["error" => $stmt->error]);
    exit;
}

echo json_encode(["success" => true,
"userId" => $userId]);
?>
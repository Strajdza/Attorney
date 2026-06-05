<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "user_db.php";

$userId = $_SESSION["user_id"] ?? null;

if (!$userId) {
    echo json_encode(["error" => "No session user"]);
    exit;
}

$stmt = $conn->prepare("
    SELECT colour1, colour2, colour3
    FROM user_info
    WHERE ID = ?
");

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
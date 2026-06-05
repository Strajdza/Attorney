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

if (isset($_FILES["image"])) {

    $ID = $_SESSION["user_id"];

$result = $conn->query("SELECT ProfilePicture FROM user_info WHERE ID='$ID'");
$user = $result->fetch_assoc();

if (!empty($user["ProfilePicture"]&&
    $user["ProfilePicture"] !== "default.webp")) {
    $oldPath = "uploads/user_uploads/" . $user["ProfilePicture"];

    if (file_exists($oldPath)) {
        unlink($oldPath);
    }
}
    $extension = strtolower(
        pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)
    );

    $fileName = "user_" . $ID . "_" . time() . "." . $extension;

    move_uploaded_file(
        $_FILES["image"]["tmp_name"],
        "uploads/user_uploads/" . $fileName
    );

    $sql = "UPDATE user_info
            SET ProfilePicture='$fileName'
            WHERE ID='$ID'";

    $queryWorked = $conn->query($sql);

    echo json_encode([
        "success" => $queryWorked,
        "profile_picture" => $fileName
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "No image received"
    ]);
}
?>
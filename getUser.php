<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
include 'user_db.php';

$ID=$_SESSION["user_id"]??null;

if(!$ID){
    echo json_encode([
        "success"=>false
    ]);
    exit;
}

$result=$conn->query(
    " SELECT Username from user_info WHERE ID='$ID'"
);
$row=$result->fetch_assoc();
echo json_encode([
    "success"=>true,
    "username"=>$row["Username"]
]);
?>
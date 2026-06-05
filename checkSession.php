<?php
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");


$response = [
    "loggedIn" => false
];

if (isset($_SESSION["user_id"])) {
    $response = [
        "loggedIn" => true,
        "user" => [
            "id" => $_SESSION["user_id"],
            "name" => $_SESSION["user_name"] ?? null
        ]
    ];
}

echo json_encode($response);
exit;
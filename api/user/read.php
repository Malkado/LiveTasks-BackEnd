<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/user.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);


$stmt = $user->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $user_arr = array();
    $user_arr["data"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            "Id_User" => $Id_User,
            "Name_User" => $Name_User,
            "Email_User" => $Email_User,
            "Login_User" => $Login_User,
            "Pass_User" => $Pass_User
        );
        array_push($user_arr["data"], $user_item);
    }

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(200);
    echo json_encode([]);
}

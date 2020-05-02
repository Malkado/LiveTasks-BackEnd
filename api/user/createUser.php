<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->pass) &&
    !empty($data->login)
) {
    $user->Name_User = $data->name;
    $user->Email_User = $data->email;
    $user->Login_User = $data->login;
    $user->Pass_User = $data->pass;
    if($user->create()){
        http_response_code(200);
        echo json_encode(array("message"=>"Função executada com sucesso."));

    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=>"Erro ao tentar criar novo usuário."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Erro interno. Tente novamente mais tarde."));
}
?>
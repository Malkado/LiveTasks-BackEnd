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
    !empty($data->pass) &&
    !empty($data->login)
) {
    $user->Login_User = $data->login;
    $user->Pass_User = $data->pass;
    if ($user->auth()) {
        /**
         * Se o usuário e a senha estiverem ok, o é gerado um token e enviado de volta para o usuário. este token deve ser salvo no banco de dados e 
         * consultado para validar o usuário.
         */
        #


        $token = $user->Token_User;
        http_response_code(200);
        echo json_encode(array("message" => "Função executada com sucesso.", "Token" => $token));
    } else {
        http_response_code(403);
        echo json_encode(array("message" => $user->Error));
    }
} else {
    http_response_code(403);
    echo json_encode(array("message" => "Erro interno. Tente novamente mais tarde."));
}

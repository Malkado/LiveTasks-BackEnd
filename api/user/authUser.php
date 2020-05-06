<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    header("Access-Control-Allow-Origin:*");
    header('Access-Control-Allow-Methods: POST, OPTIONS');
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
            $token = $user->Token_User;
            http_response_code(200);
            echo json_encode(array("message" => "Função executada com sucesso.", "Token" => $token));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "message" => "Erro interno. Tente novamente mais tarde.",
                "statusCode" => 500
            ));
        }
    } else {
        http_response_code(403);
        echo json_encode(array(
            "message" =>
            "Não foi possivel obter os valores na requisição.",
            "statusCode" => 500
        ));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "O tipo da requisição está incorreto.",
        "statusCode" => 400
    ));
}

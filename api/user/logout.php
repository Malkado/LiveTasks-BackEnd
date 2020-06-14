<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers:Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    include_once '../config/database.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $header = apache_request_headers();
    $token = $header["Token"];

    if ($token) {
        if (!empty($data->Id)) {
            $user->Id_User = $data->Id;
            $user->Token_User = $token;
            if ($user->Logout()) {
                http_response_code(200);
                echo json_encode(array(
                    "message" =>
                    "Usuário desconectado com sucesso.",
                    "statusCode" => 200

                ));
            } else {
                http_response_code(500);
                echo json_encode(array(
                    "messege" =>
                    "Erro interno. Tente novamente mais tarde.",
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
        http_response_code(401);
        echo json_encode(array(
            "message" =>
            "Token de Autenticação não encontrado.",
            "statusCode" => 401

        ));
    }
} else {

    http_response_code(400);
    echo json_encode(array(
        "message" =>
        "O tipo da requisição está incorreto.",
        "statusCode" => 400

    ));
}

<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}
if ($_SERVER['REQUEST_METHOD'] == "PUT" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    include_once '../config/database.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"));
    $header = apache_request_headers();
    $token = $header["Token"];
    if (
        !empty($data->idUser) &&
        !empty($data->name) &&
        !empty($data->email) &&
        !empty($data->pass)
    ) {
        $user->Id_User = $data->idUser;
        $user->Name_User = $data->name;
        $user->Email_User = $data->email;
        $user->Pass_User = $data->pass;
        $user->Token_User = $token;
        if ($user->updateUser()) {
            http_response_code(200);
            echo json_encode(array(
                "message" => "Função executada com sucesso.",
                "statusCode" => 200
            ));
        } else {
            http_response_code(400);
            echo json_encode(array(
                "message" => "Dados incorretos.",
                "statusCode" => 400
            ));
        }
    } else {

        http_response_code(400);
        echo json_encode(array(
            "message" =>
            "Não foi possivel obter os valores na requisição.",
            "statusCode" => 400
        ));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "O tipo da requisição está incorreto.",
        "statusCode" => 400
    ));
}

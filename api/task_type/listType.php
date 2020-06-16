<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers:Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}
if ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {


    include_once '../config/database.php';
    include_once '../objects/tasktype.php';

    $database = new Database();
    $db = $database->getConnection();

    $task_type = new Task_Type($db);


    $header = apache_request_headers();
    $token = $header["Token"];
    if ($token) {

        $task_type->Token_User = $token;
        if ($task_type->listTask_type()) {

            http_response_code(200);
            echo json_encode(array(
                "message" => "Função executada com sucesso.",
                "statusCode" => 200,
                "results" => $task_type->Json
            ));
        } else {
            http_response_code(400);
            echo json_encode(array(
                "message" => "Dados incorretos.",
                "statusCode" => 400
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
        "message" => "O tipo da requisição está incorreto.",
        "statusCode" => 400
    ));
}

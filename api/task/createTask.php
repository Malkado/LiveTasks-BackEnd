<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {


    include_once '../config/database.php';
    include_once '../objects/task.php';

    $database = new Database();
    $db = $database->getConnection();

    $task = new Task($db);

    $data = json_decode(file_get_contents("php://input"));

    $header = apache_request_headers();
    $token = $header["Token"];
    if ($token) {
        if (
            !empty($data->user_id) &&
            !empty($data->name) &&
            !empty($data->description)
        ) {
            $task->Token_User = $token;
            $task->Id_User = $data->user_id;
            $task->Name_Task = $data->name;
            $task->Description_Task = $data->description;
            if ($task->createTask()) {

                http_response_code(200);
                echo json_encode(array(
                    "message" => "Função executada com sucesso."
                ));
            } else {
                http_response_code(400);
                echo json_encode(array(
                    "message" => "Dados incorretos.",
                    "statusCode" => 400
                ));
            }
        } else {
            http_response_code(403);
            echo json_encode(array(
                "message" =>
                "Não foi possivel obter os valores na requisição.",
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

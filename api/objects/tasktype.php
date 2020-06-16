<?php
class Task_Type
{
    private $conn;
    private $table_name = "task_type";

    public $Id_Task_Type;
    public $Name_Task_Type;

    public $Token_User;

    public $Error;
    public $Json;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    function listTask_type()
    {
        $verify_user_token = "SELECT Token_User FROM user WHERE Token_User =:token";
        $vrf = $this->conn->prepare($verify_user_token);

        $this->Token_User = htmlspecialchars(strip_tags($this->Token_User));

        $vrf->bindParam(":token", $this->Token_User);
        $vrf->execute();
        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $token =  $data[0][0];

            if ($token == $this->Token_User) {
                $querySelect = "SELECT * FROM  task_type";
                $svrf = $this->conn->prepare($querySelect);

                $svrf->execute();
                if ($svrf->rowCount() != 0) {
                    $num = $svrf->rowCount();

                    if ($num > 0) {
                        $task_type_arr = array();
                        $task_type_arr["data"] = array();

                        while ($row = $svrf->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            $task_item = array(
                                "Id_Task_Type" => $Id_Task_Type,
                                "Name_Task_Type" => $Name_Task_Type
                            );
                            array_push($task_type_arr["data"], $task_item);
                        }
                        $this->Json = $task_type_arr;
                    }
                    return true;
                } else {
                    $this->Json = $arr["data"] = [];
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}

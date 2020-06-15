<?php
class Task
{
    private $conn;
    private $table_name = "task";

    public $Id_Task;
    public $Name_Task;
    public $Description_Task;
    public $Id_Task_Type;
    public $Id_User;

    public $Token_User;

    public $Error;
    public $Json;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    function createTask()
    {
        $verify_user_token = "SELECT Token_User FROM user WHERE Id_User =:id";
        $vrf = $this->conn->prepare($verify_user_token);

        $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

        $vrf->bindParam(":id", $this->Id_User);
        $vrf->execute();
        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $token =  $data[0][0];

            if ($token == $this->Token_User) {

                $create_query = "INSERT INTO task SET Name_Task=:name, Description_Task=:description, 
                Id_Task_Type= 1,Id_User=:user";
                $stmt = $this->conn->prepare($create_query);
                $this->Name_Task = htmlspecialchars(strip_tags($this->Name_Task));
                $this->Description_Task = htmlspecialchars(strip_tags($this->Description_Task));
                $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

                $stmt->bindParam(":name", $this->Name_Task);
                $stmt->bindParam(":description", $this->Description_Task);
                $stmt->bindParam(":user", $this->Id_User);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    function deleteTask()
    {
        $verify_user_token = "SELECT Token_User FROM user WHERE Id_User =:id";
        $vrf = $this->conn->prepare($verify_user_token);

        $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

        $vrf->bindParam(":id", $this->Id_User);
        $vrf->execute();
        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $token =  $data[0][0];

            if ($token == $this->Token_User) {
                $querySelect = "SELECT * FROM  task WHERE Id_Task=:task";
                $svrf = $this->conn->prepare($querySelect);
                $this->Id_Task = htmlspecialchars(strip_tags($this->Id_Task));

                $svrf->bindParam(":task", $this->Id_Task);
                $svrf->execute();
                if ($svrf->rowCount() != 0) {
                    $queryDelete = "DELETE FROM task WHERE Id_Task=:task";
                    $dvrf = $this->conn->prepare($queryDelete);

                    $this->Id_Task = htmlspecialchars(strip_tags($this->Id_Task));
                    $dvrf->bindParam(":task", $this->Id_Task);

                    if ($dvrf->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    function listTask()
    {
        $verify_user_token = "SELECT Token_User FROM user WHERE Id_User =:id";
        $vrf = $this->conn->prepare($verify_user_token);

        $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

        $vrf->bindParam(":id", $this->Id_User);
        $vrf->execute();
        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $token =  $data[0][0];

            if ($token == $this->Token_User) {
                $querySelect = "SELECT * FROM  task WHERE Id_User=:user";
                $svrf = $this->conn->prepare($querySelect);
                $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

                $svrf->bindParam(":user", $this->Id_User);
                $svrf->execute();
                if ($svrf->rowCount() != 0) {
                    $num = $svrf->rowCount();

                    if ($num > 0) {
                        $task_arr = array();
                        $task_arr["data"] = array();

                        while ($row = $svrf->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            $task_item = array(
                                "Id_Task" => $Id_Task,
                                "Name_Task" => $Name_Task,
                                "Description_Task" => $Description_Task,
                                "Id_Task_Type" => $Id_Task_Type,
                                "Id_User" => $Id_User,

                            );
                            array_push($task_arr["data"], $task_item);
                        }
                        $this->Json = $task_arr;
                    }
                    return true;
                } else {
                    $this->Json = $arr["data"] = [];
                    return true;
                }
            } else {
                return false;
            }
        }
    }
    function updateTask()
    {

        $verify_user_token = "SELECT Token_User FROM user WHERE Id_User =:id";
        $vrf = $this->conn->prepare($verify_user_token);

        $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

        $vrf->bindParam(":id", $this->Id_User);
        $vrf->execute();
        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $token =  $data[0][0];

            if ($token == $this->Token_User) {
                $querySelect = "SELECT * FROM  task WHERE Id_Task=:task";
                $svrf = $this->conn->prepare($querySelect);
                $this->Id_Task = htmlspecialchars(strip_tags($this->Id_Task));

                $svrf->bindParam(":task", $this->Id_Task);
                $svrf->execute();
                if ($svrf->rowCount() != 0) {
                    $queryUpdate = "UPDATE task SET Name_Task=:name_task, 
                    Description_Task=:descr,Id_Task_Type =:task_type WHERE Id_Task=:task";
                    $uvrf = $this->conn->prepare($queryUpdate);

                    $this->Id_Task = htmlspecialchars(strip_tags($this->Id_Task));
                    $this->Name_Task = htmlspecialchars(strip_tags($this->Name_Task));
                    $this->Description_Task = htmlspecialchars(strip_tags($this->Description_Task));
                    $this->Id_Task_Type = htmlspecialchars(strip_tags($this->Id_Task_Type));

                    $uvrf->bindParam(":task", $this->Id_Task);
                    $uvrf->bindParam(":name_task", $this->Name_Task);
                    $uvrf->bindParam(":descr", $this->Description_Task);
                    $uvrf->bindParam(":task_type", $this->Id_Task_Type);

                    if ($uvrf->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}

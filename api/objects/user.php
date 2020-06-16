<?php
class User
{
    private $conn;
    private $table_name = "user";

    public $Id_User;
    public $Name_User;
    public $Email_User;
    public $Login_User;
    public $Pass_User;
    public $Token_User;

    public $Error;
    public $Json;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    function read()
    {
        $query = "SELECT Id_User, Name_User, Email_User, Login_User, Pass_User 
        FROM . $this->table_name";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create()
    {


        $verify_login = "SELECT Email_User FROM user WHERE Login_User=:login UNION SELECT  Email_User FROM user WHERE Email_User =:email"; // substituir UNION por AND
        $vrf = $this->conn->prepare($verify_login);

        $this->Login_User = htmlspecialchars(strip_tags($this->Login_User));
        $this->Email_User = htmlspecialchars(strip_tags($this->Email_User));

        $vrf->bindParam(":email", $this->Email_User);
        $vrf->bindParam(":login", $this->Login_User);

        $vrf->execute();

        if ($vrf->rowCount() != 0) {
            return false;
        } else {
            $this->Pass_User = base64_encode($this->Pass_User);
            $query = "INSERT INTO " . $this->table_name .
                " SET Name_User=:name,Email_User=:email,Login_User=:login,Pass_User=:pass";

            $stmt = $this->conn->prepare($query);
            $this->Name_User = htmlspecialchars(strip_tags($this->Name_User));
            $this->Email_User = htmlspecialchars(strip_tags($this->Email_User));
            $this->Login_User = htmlspecialchars(strip_tags($this->Login_User));
            $this->Pass_User = htmlspecialchars(strip_tags($this->Pass_User));

            $stmt->bindParam(":name", $this->Name_User);
            $stmt->bindParam(":email", $this->Email_User);
            $stmt->bindParam(":login", $this->Login_User);
            $stmt->bindParam(":pass", $this->Pass_User);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
    function auth()
    {
        $verify_login = "SELECT Pass_User FROM user WHERE Login_User=:login";
        $vrf = $this->conn->prepare($verify_login);

        $this->Login_User = htmlspecialchars(strip_tags($this->Login_User));

        $vrf->bindParam(":login", $this->Login_User);

        $vrf->execute();


        if ($vrf->rowCount() != 0) {
            $data = $vrf->fetchAll();
            $pass =  $data[0][0];
            if (base64_encode($this->Pass_User) == $pass) {

                $this->Token_User = md5(date(time()) . $this->Login_User . "@#a%_47");


                $update_token = "UPDATE user SET Token_user=:token WHERE Login_User=:login";

                $stmt = $this->conn->prepare($update_token);

                $stmt->bindParam(":login", $this->Login_User);

                $stmt->bindParam(":token", $this->Token_User);

                if ($stmt->execute()) {
                    $select_id_and_name = "SELECT Name_User, Id_User FROM user WHERE Login_User=:login";

                    $svrf = $this->conn->prepare($select_id_and_name);

                    $svrf->bindParam(":login", $this->Login_User);
                    if ($svrf->execute()) {
                        if ($svrf->rowCount() != 0) {
                            $data = $svrf->fetchAll();
                            $this->Name_User = $data[0][0];
                            $this->Id_User = $data[0][1];

                            return true;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                $this->Error = "Senha Incorreta.";
                return false;
            }
        } else {
            $this->Error = "Usuário não encontrado.";
            return false;
        }
    }
    function Logout()
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
                $modify_Token = "UPDATE user SET Token_User= NULL WHERE Id_User =:id";
                $stmt = $this->conn->prepare($modify_Token);
                $stmt->bindParam(":id", $this->Id_User);
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
    function profile()
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
                $query = "SELECT Id_User, Name_User, Email_User, Login_User, Pass_User 
                FROM user WHERE Id_User=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $this->Id_User);
                if ($stmt->execute()) {
                    $data = $stmt->fetchAll();
                    $this->Json = array("profile" => array(
                        "Id_User" => $data[0]['Id_User'],
                        "Name_User" => $data[0]['Name_User'],
                        "Email_User" => $data[0]['Email_User'],
                        "Login_User" => $data[0]['Login_User'],
                        "Pass_User" => base64_decode($data[0]['Pass_User'])
                    ));
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    function updateUser()
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
                $verify_user = "SELECT Name_User FROM user WHERE Id_User =:id";
                $vrf = $this->conn->prepare($verify_user);

                $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

                $vrf->bindParam(":id", $this->Id_User);
                $vrf->execute();
                if ($vrf->rowCount() != 0) {
                    $queryUpdate = "UPDATE user SET Name_User=:name_user, 
                    Email_User=:email,Pass_User =:pass WHERE Id_User=:user";
                    $uvrf = $this->conn->prepare($queryUpdate);

                    $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));
                    $this->Name_User = htmlspecialchars(strip_tags($this->Name_User));
                    $this->Email_User = htmlspecialchars(strip_tags($this->Email_User));
                    $this->Pass_User = htmlspecialchars(strip_tags($this->Pass_User));

                    $this->Pass_User = base64_encode($this->Pass_User);

                    $uvrf->bindParam(":user", $this->Id_User);
                    $uvrf->bindParam(":name_user", $this->Name_User);
                    $uvrf->bindParam(":email", $this->Email_User);
                    $uvrf->bindParam(":pass", $this->Pass_User);
                    if ($uvrf->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    function deleteUser()
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
                $verify_user = "SELECT Name_User FROM user WHERE Id_User =:id";
                $vrf = $this->conn->prepare($verify_user);

                $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

                $vrf->bindParam(":id", $this->Id_User);
                $vrf->execute();
                if ($vrf->rowCount() != 0) {
                    $queryDelete = "DELETE FROM user WHERE Id_User=:user";
                    $dvrf = $this->conn->prepare($queryDelete);

                    $this->Id_User = htmlspecialchars(strip_tags($this->Id_User));

                    $dvrf->bindParam(":user", $this->Id_User);

                    if ($dvrf->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}

<?php
class User
{
    private $conn;
    private $table_name = "user";


    public $Name_User;
    public $Email_User;
    public $Login_User;
    public $Pass_User;
    public $Token_User;

    public $Error;
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
        echo $this->Login_User;
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

                    return true;
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
}

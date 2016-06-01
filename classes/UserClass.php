<?php

require_once 'DbConnection.php';
require_once 'RandomKey.php';
require_once 'EncryptPass.php';

class UserClass
{
    
    private $conn;
    
    public function __construct()
    {
        $database   = new DbConnection();
        $db         = $database->dbConnection();
        $this->conn = $db;

        $random = new RandomKey();
        $key = $random->randomkey();
        $this->keyuser = $key;
    }
    
    public function register($username, $email, $timezone, $upass, $code)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO myr_users(code,username,email,timezone,password,token) VALUES(:code, :username, :email, :timezone, :password, :token)");
            $stmt->bindparam(":code", $this->keyuser);
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":timezone", $timezone);
            $stmt->bindparam(":password", $upass);
            $stmt->bindparam(":token", $code);
            $stmt->execute();
            return $stmt;
        }
        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    public function editUser($timezone, $picture,  $email)
    {
        $stmt = $this->conn->prepare("UPDATE myr_users SET picture = :picture , timezone = :timezone WHERE email = :email");
        $stmt->bindparam(":timezone", $timezone);
        $stmt->bindparam(":email", $email);
        $stmt->bindparam(":picture", $picture);
        $stmt->execute();
        return true;
    }
    
    public function queryDB($sql)
    {
        
        $stmt = $this->conn->prepare($sql);
        return $stmt;
        
    }
    
    public function login($email, $upass)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM myr_users WHERE email=:email");
            $stmt->execute(array(":email" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() == 1) {
                // Creando objecto de password.
                $encrypt_pass = new EncryptPass();
                // Descrypt the password
                $password = $encrypt_pass->encrypt_decrypt('encrypt', $upass);
                if ($userRow['status'] == "Y") {
                    if ($userRow['password'] == $password) {
                        $_SESSION['userSession'] = $userRow['ID'];
                        $_SESSION['codeSession'] = $userRow['code'];
                        $_SESSION['emailSession'] = $userRow['email'];
                        return true;
                    } else {
                        header("Location: login.php?error2");
                        exit;
                    }
                } else {
                    header("Location: login.php?inactive");
                    exit;
                }
            } else {
                header("Location: login.php?error3");
                exit;
            }
        }
        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }
    
    public function redirect($url)
    {
        header("Location: $url");
    }
    
    public  function infoUser($id, $email) 
    {

         $stmt = $this->conn->prepare("SELECT * FROM myr_users WHERE ID=:id AND email=:email");
         $stmt->execute(array(":email" => $email, ":id" => $id));
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
         return $user;

    }

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
        $_SESSION['codeSession'] = false;
        $_SESSION['emailSession'] = false;
    }
}
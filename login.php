<?php

class Login
{
    private $error = "";
    
    public function evaluate($data)
    {
        $email = $data['email'];
        $password = md5($data['password']);

        $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $DB = new DataBase();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
            if ($password == $row['password']) {
                // creaza session
                $_SESSION['email'] = $row['email'];
                 header("Location: home.php");
                    exit;
            } else {
                $this->error .= "Parola Gresita!";
            }
        } else {
            $this->error .= "Nu exista cont cu acest email!";
        }
        return $this->error;
    }
    
    public function check_login($email)
    {
        $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $DB = new DataBase();
        $result = $DB->read($query);
        if ($result) {
            $user_data = $result[0];
            return $user_data;
        } else {
            return false;
        }
    }
}

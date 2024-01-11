<?php

class SignUp
{
    private $error = "";
    public function evaluate($data)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error .= $key . " is empty! <br>";
            }
            elseif ($key == 'name') {
                if (is_numeric($value)) {
                    $this->error .= "Nu poti avea cifre in nume<br>";
                }
            }
            if($key == 'email'){
                $check = new DataBase();
                $select = "select * from user where email='$value'";
                $res = $check->read($select);
                if($res){
                    $this->error .= "Email este deja folosit!";
                }
            }
        }
        if($data['password'] != $data["cpassword"]){
            $this->error .= "Parolele nu se potrivest!";
        }
        
        if ($this->error == "") {
            
            $this->create_user($data);
            header('Location: login.php'); 

        } else {
            return $this->error;
        }


    }

    public function create_user($data)
    {
        $nume = $data['nume'];
        $prenume = $data['prenume'];

        $email = $data['email'];
        $password = md5($data['password']);
        $cpass = md5($data['cpassword']);

            $query = "insert into user(nume,prenume, email, password) values ('$nume','$prenume', '$email', '$password')";
            $DB = new DataBase();
            $DB->insert($query);
        }
   
}



?>
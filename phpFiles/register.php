<?php

include ("../conect.php");
include ("../signup.php");
    $nume = "";
    $prenume="";
    $email = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $register = new SignUp();
    $result = $register->evaluate($_POST);

    if($result != ""){
    echo "<div style='text-align:center; fost-size:12px;color:black'>";
    echo "The following errors occured:<br>";
    echo $result;
    echo "</div>";
    }
    $nume = $_POST['nume'];
    $prenume=$_POST['prenume'];
    $email = $_POST['email'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/registerStyle.css">
</head>
<body>
<div class="registerForm" >

    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register now!</h3>
    <input  type="text" value="<?php echo $nume ?>" name="nume" placeholder="enter nume" class="box" >
    <input  type="text" value="<?php echo $prenume ?>" name="prenume" placeholder="enter prenume" >
    <input  type="email" value="<?php echo $email ?>" name="email" placeholder="enter email" class="box" >
    <input  type="password" name="password" placeholder="enter password" class="box" >
    <input  type="password" name="cpassword" placeholder="confirm password" class="box" >
         <br>
        <input id="submit" type="submit" name="submit" value="register now" class="btn" href="login.html">
       
</div>
    </form>
    <p style="color:white">already have an account?<a href="login.php">Login</a></p>

</body>
</html>
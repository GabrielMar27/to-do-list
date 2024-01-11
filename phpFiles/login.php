<?php
session_start();

include ("../conect.php");
include ("../login.php");

$email = "";
$password = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $login = new Login();
    $result = $login->evaluate($_POST);

    if($result != ""){
        echo "<div style='text-align:center; font-size:12px; color:black'>";
        echo "The following errors occurred:<br>";
        echo $result;
        echo "</div>";
        echo "<script type='text/javascript'>window.alert('$result');</script>";
    }

    $email = $_POST['email'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../styles/loginStyle.css">
</head>

<body>

    <div class="loginForm" >
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Log in your To Do List Account</h1>
            <input type="email" value="<?php echo $email ?>" name="email" placeholder="enter email" class="box" required>
            <br>
            <input type="password" name="password" placeholder="enter password" class="box" required>
            <br>
            <input type="submit" name="submit" value="login now" class="btn">
        </form>
    </div>
    <p style="color:white">don't have an account? <a href="register.php"style="color:blue">register now</a></p>

</body>

</html>

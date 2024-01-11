<?php
session_start();
session_destroy();
header('Location: phpFiles/login.php'); 
exit();
?>

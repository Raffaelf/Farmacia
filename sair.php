<?php
session_start();

unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['email']);
unset($_SESSION['logado']);
        
header('Location: login.php');
exit;

?>
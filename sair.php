<?php
session_start();

unset($_SESSION['session_farma']);
setcookie('cookie_farma', '', 1);
        
header('Location: login.php');
exit;
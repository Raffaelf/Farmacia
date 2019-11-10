<?php
    if(!isset($_SESSION['session_farma'])) {
        header('Location: pages/login.php');
        exit;
    } 

    $medicamentos = array();

    $ch = curl_init('http://localhost:8080/produto');

?>
<?php
    if(!isset($_SESSION['session_farma'])) {
        header('Location: pages/login.php');
        exit;
    } 

    $ch = curl_init('http://localhost:8080/produto');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'                                                                                
    ));                                                             
                                                                                                                    
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response);
    $medicamentos = array();

    // Preenche array com os medicamentos da farmacia
    foreach($response as $medicamento) {
        if($medicamento->farmacia->id == $farmacia_logada->id){
            array_push($medicamentos, $medicamento);
        }
    }

    // Ordenando array do ultimo para o primeiro elemento
    usort($medicamentos, function ($a, $b){

        return (($a->id > $b->id) ? -1 : 1);
    });
?>
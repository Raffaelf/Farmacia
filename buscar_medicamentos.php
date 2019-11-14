<?php
    if(!isset($_SESSION['session_farma'])) {
        header('Location: pages/login.php');
        exit;
    } 

    $ch = curl_init('http://localhost:8080/administrador/listarprodutos');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',
        "Authorization:Bearer " . $_SESSION['session_farma']                                                                               
    ));                                                             
                                                                                                                    
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response);
    $medicamentos_ativos = array();
    $medicamentos_desativados = array();

    // Preenche array com os medicamentos da farmacia
    foreach($response as $medicamento) {

        if(!$medicamento->removedAt) {
            array_push($medicamentos_ativos, $medicamento);
        }
        else {
            array_push($medicamentos_desativados, $medicamento);
        }
    }

    // Ordenando array do ultimo para o primeiro elemento
    usort($medicamentos_ativos, function ($a, $b){

        return (($a->id > $b->id) ? -1 : 1);
    });
?>
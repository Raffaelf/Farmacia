<?php
    session_start();
   
    if(!isset($_SESSION['session_farma'])) {
        header('Location: login.php');
        exit;
    }

    if(
        !isset($_POST['nome']) &&
        !isset($_POST['preco']) &&
        !isset($_POST['concentracao']) &&
        !isset($_POST['quantidade']) &&
        !isset($_POST['registro_anvisa']) &&
        !isset($_POST['principio_ativo']) &&
        !isset($_POST['forma_farmaceutica']) &&
        !isset($_POST['detentor_registro'])
    ) {

        header('Location: index.php?i=4');
        exit;
    }
    
    // Montando array com dados
    $dados = array(
        "nome" => $_POST['nome'],
        "principioAtivo" => $_POST['principio_ativo'],
        "concentracao" => $_POST['concentracao'],
        "formaFarmaceutica" => $_POST['forma_farmaceutica'],
        "registroAnvisa" => $_POST['registro_anvisa'],
        "detentorRegistro" => $_POST['detentor_registro'],
        "preco" => $_POST['preco'],
        "quantidade" => $_POST['quantidade']
    );

    // Montando a requisição
    $dadosJSON = json_encode($dados);  
                                                                                                                    
    $ch = curl_init('http://localhost:8080/adminAut/produto');                                                                      
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosJSON);                                                                  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json", 
        "Authorization:Bearer " . $_SESSION['session_farma']
    ));                                                                                                              
    curl_setopt($ch, CURLOPT_HEADER, 1);                                                                                                              
                                                                                                                    
    $response = curl_exec($ch);
    curl_close($ch);

    $header = explode(' ', $response);

    if($header[1] == "200" || $header[1] == "201") {

        header('Location: index.php?i=s1');
        exit;
    }
    header('Location: index.php?i=e1');
    exit;
?>
<?php

if($_POST['password'] != $_POST['confirm-password']) {
    echo "<script>alert('Senhas não coincidem!');</script>";
    echo "<script>window.location = '/Admin/login.php'</script>";
} else {
    $data = array(
        "cnpj" => $_POST['cnpj'], 
        "email" => $_POST['email'], 
        "login" => $_POST['username'],
        "nome" => $_POST['business'], 
        "senha" => $_POST['password'], 
        "telefone" => $_POST['telefone']
    );

    $data_string = json_encode($data);  

    echo $data_string;
                                                                                                                    
    $ch = curl_init('http://localhost:8080/administrador/cadastrarfarmacia');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
                                                                                                                    
    $retorno = curl_exec($ch);
    curl_close($ch);
}
?>
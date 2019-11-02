<?php 
session_start();
 
$login = (isset($_POST['username'])) ? $_POST['username'] : '';
$senha = (isset($_POST['password'])) ? $_POST['password'] : '';
$lembrete = (isset($_POST['remember'])) ? $_POST['remember'] : '';
 
if (!empty($login) && !empty($senha)){
/*
	$conexao = new PDO('mysql:host=localhost;dbname=db_blog', 'root', '123456');
	$sql = 'SELECT id, nome, email FROM usuario WHERE email = ? AND senha = ?';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $email);
	$stm->bindValue(2, md5($senha));
	$stm->execute();
	$dados = $stm->fetch(PDO::FETCH_OBJ);
*/
	$array = array('login' => $login, 
					'senha' => $senha);
	$data_string = json_encode($array);  

	//echo $data_string;

	$ch = curl_init('http://localhost:8080/administrador/autenticar');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
            );                                                                                                                   
		
		$result = curl_exec($ch);

		if($result != true){
			echo "<script>alert('Usuário ou senha incorretos!');</script>";
			echo "<script>window.location = '/Admin/login.php'</script>";
		} else {
		
			if(!empty($array)){
 
				$_SESSION['login'] = $array['login'];
				$_SESSION['senha'] = $array['senha'];
				$_SESSION['logado'] = TRUE;
 
				if($lembrete == 'SIM'){
 
		   			$expira = time() + 60*60*24*30; 
		   			setCookie('CookieLembrete', base64_encode('SIM'), $expira);
		   			setCookie('CookieEmail', base64_encode($login), $expira);
		   			setCookie('CookieSenha', base64_encode($senha), $expira);
				} else {
		   
    	   			setCookie('CookieLembrete');
		   			setCookie('CookieEmail');
		   			setCookie('CookieSenha');
				}
				echo "<script>window.location = '/Admin/index.php'</script>";
			} else {
				echo "<script>alert('Erro inesperado!');</script>";
				echo "<script>window.location = '/Admin/login.php'</script>";
			}
		}
} else { 
	echo "<script>alert('Erro!');</script>";
	echo "<script>window.location = '/Admin/login.php'</script>";
}

			//$_SESSION['logado'] = FALSE;
	    	//echo "<script>window.location = '/Admin/login.php'</script>";
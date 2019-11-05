<?php 
session_start();
 
$usuario = (isset($_POST['username'])) ? $_POST['username'] : '';
$senha = (isset($_POST['password'])) ? $_POST['password'] : '';
$lembrete = (isset($_POST['remember'])) ? $_POST['remember'] : '';
 
if (!empty($usuario) && !empty($senha)){

		$login = array(
				'login' => $usuario, 
				'senha' => $senha
		);

		$loginJson = json_encode($login);  

		$ch = curl_init('http://localhost:8080/administrador/autenticar');                                                                      
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
					curl_setopt($ch, CURLOPT_POSTFIELDS, $loginJson);                                                                  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
						'Content-Type: application/json',                                                                                
						'Content-Length: ' . strlen($loginJson))                                                                       
					);                                                                                                                   
			
		$result = curl_exec($ch);
		
		
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $headerSize);

		echo $header;

		$infoHeader = explode(' ', $header);

		echo "<pre>";
		var_dump($infoHeader);
		echo "</pre>";

		//Para pegar apenas o token quebrar a string nos espaços

			// if($result != true){
			// 	echo "<script>alert('Usuário ou senha incorretos!');</script>";
			// 	echo "<script>window.location = '/Farmacia/login.php'</script>";
			// } else {
			
			// 	if(!empty($array)){
	
			// 		$_SESSION['login'] = $array['login'];
			// 		$_SESSION['senha'] = $array['senha'];
			// 		$_SESSION['logado'] = TRUE;
	
			// 		if($lembrete == 'SIM'){
	
			//    			$expira = time() + 60*60*24*30; 
			//    			setCookie('CookieLembrete', base64_encode('SIM'), $expira);
			//    			setCookie('CookieEmail', base64_encode($login), $expira);
			//    			setCookie('CookieSenha', base64_encode($senha), $expira);
			// 		} else {
				
			// 	   			setCookie('CookieLembrete');
			//    			setCookie('CookieEmail');
			//    			setCookie('CookieSenha');
			// 		}
			// 		echo "<script>window.location = '/Admin/index.php'</script>";
			// 	} else {
			// 		echo "<script>alert('Erro inesperado!');</script>";
			// 		echo "<script>window.location = '/Admin/login.php'</script>";
			// 	}
			// }
} else { 
	echo "<script>alert('Erro!');</script>";
	header('Location: login.php');
	exit;
}

			//$_SESSION['logado'] = FALSE;
	    	//echo "<script>window.location = '/Admin/login.php'</script>";
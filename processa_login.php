<?php 
		session_start();
		
		$usuario = (isset($_POST['username'])) ? $_POST['username'] : '';
		$senha = (isset($_POST['password'])) ? $_POST['password'] : '';
		$lembrete = (isset($_POST['remember'])) ? $_POST['remember'] : '';
		
		/* 
		 * Redireciona para login caso um dos campos esteja vazio,
		 * e retorna uma variavel 'i' via GET para informar que houve uma falha no login
		 */
		if (empty($usuario) || empty($senha)){		
				header('Location: login.php?i=1');
				exit;
		}

		// Cria um array com dados do login e converte para JSON
		$login = array('login' => $usuario, 'senha' => $senha);
		$loginJSON = json_encode($login);  

		// Configurando a requisicao
		$ch = curl_init('http://localhost:8080/administrador/autenticar');                                                                      
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
					curl_setopt($ch, CURLOPT_POSTFIELDS, $loginJSON);                                                                  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                      
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
						'Content-Type: application/json',                                                                                
						'Content-Length: ' . strlen($loginJSON))                                                                       
					);                                                                                                                   
		
		$response = curl_exec($ch);
		
		// Extraindo o header da resposta em STRING da API
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $headerSize);

		/* 
		 * Quebrando a String do header para pegar o STATOS da requisicao e o TOKEN
		 * o resultado é um array
		 * onde na posicao 1 terá o STATUS
		 * e na posicao 4 o TOKEN, caso a requisiçao tenha STAUTS 200
		 */
		$header = explode(' ', $header);

		if($header[1] == "200") {
				
				$token = $header[4];
				$_SESSION['session_farma'] = $token;

				// Caso a caixa lembrar senha esteja marcada cria um cookie com validade de 7 dias
				if($lembrete) {
					setcookie('cookie_farma', $token, time() + (60 * 24 * 7));
				}

				header('Location: index.php');
				exit;

		}
		else {
				header('Location: login.php?i=1');
				exit;
		}
?>
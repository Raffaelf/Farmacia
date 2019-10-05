<?php 
session_start();
 
$email = (isset($_POST['username'])) ? $_POST['username'] : '';
$senha = (isset($_POST['password'])) ? $_POST['password'] : '';
$lembrete = (isset($_POST['remember'])) ? $_POST['remember'] : '';
 
if (!empty($email) && !empty($senha)):
/*
	$conexao = new PDO('mysql:host=localhost;dbname=db_blog', 'root', '123456');
	$sql = 'SELECT id, nome, email FROM usuario WHERE email = ? AND senha = ?';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $email);
	$stm->bindValue(2, md5($senha));
	$stm->execute();
	$dados = $stm->fetch(PDO::FETCH_OBJ);
*/
    $array = array(
        'id' => '1',
        'email' => 'admin@admin.com',
        'nome' => 'Admin'
    );
	if(!empty($array)):
 
		$_SESSION['id'] = $array['id'];
		$_SESSION['nome'] = $array['nome'];
		$_SESSION['email'] = $array['email'];
		$_SESSION['logado'] = TRUE;
 
		if($lembrete == 'SIM'):
 
		   $expira = time() + 60*60*24*30; 
		   setCookie('CookieLembrete', base64_encode('SIM'), $expira);
		   setCookie('CookieEmail', base64_encode($email), $expira);
		   setCookie('CookieSenha', base64_encode($senha), $expira);
		else:
		   
    	   setCookie('CookieLembrete');
		   setCookie('CookieEmail');
		   setCookie('CookieSenha');
 		   
		endif;
 
		echo "<script>window.location = '/Admin/index.php'</script>";
	else:

		$_SESSION['logado'] = FALSE;
	    echo "<script>window.location = '/Admin/login.php'</script>";
 
	endif;
 
endif;
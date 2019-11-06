<?php
session_start();

if(isset($_SESSION['session_farma'])) {
		header('Location: index.php');
		exit;
}

// Recuperando dados dos cookies caso existam
$usuario = '';
$senha = '';
$lembrar = '';

if(isset($_COOKIE['cookie_farma'])) {
		$cookie = explode(' ', $_COOKIE['cookie_farma']);

		$usuario = $cookie[0];
		$senha = $cookie[1];
		$lembrar = $cookie[2];
}
?>

<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<title>Logar no sistama</title>

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="assets/css/styleLogin.css" rel="stylesheet">
		
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="assets/js/mascara.min.js"></script>
		<script src="assets/js/styleLogin.js"></script>
</head>
<body>
<div class="container">
  	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Entrar</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Cadastrar</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">

								<!-- Formulario de login -->
								<form id="login-form" action="processa_login.php" method="post" role="form" style="display: block;">
				
										<p Style="color: red; font-size: 15px; text-align: center">
												<?php echo (isset($_GET['i']) ? 'Email e/ou senha inválido!' : ''); ?>
										</p>
										
										<div class="form-group">
												<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Nome de usuário" value="<?=$usuario?>" required>
										</div>
										<div class="form-group">
												<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Senha" value="<?=$senha?>" required>
										</div>
										<div class="form-group text-center">
												<input type="checkbox" tabindex="3" class="" name="remember" id="remember" value="SIM" <?=$lembrar?>>
												<label for="remember"> Lembrar senha</label>
										</div>
										<div class="form-group">
												<div class="row">
														<div class="col-sm-6 col-sm-offset-3">
																<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Entrar">
														</div>
												</div>
										</div>
										<div class="form-group">
												<div class="row">
														<div class="col-lg-12">
																<div class="text-center">
																		<a href="https://phpoll.com/recover" tabindex="5" class="forgot-password">Esqueceu a senha?</a>
																</div>
														</div>
												</div>
										</div>
								</form>

								<!-- Formulario de cadastro -->
								<form id="register-form" action="processa_registro.php" method="post" role="form" style="display: none;">
									
										<label>Dados de acesso</label>
										<div class="form-group">
												<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Nome de usuário" value="">
										</div>
										<div class="form-group">
												<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Senha">
										</div>
										<div class="form-group">
												<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirmar senha">
										</div>
										<br>

									<!--label>Dados da farmácia </label>
									<div class="form-group">
										<input type="text" name="business" id="business" tabindex="1" class="form-control" placeholder="Razão social" value="">
									</div>
									<div class="form-group">
										<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" onkeyup="mascara('##.###.###/####-##',this,event,true)" maxlength="18">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="E-mail" value="" required>
									</div>
									<div class="form-group">
										<input type="text" name="telefone" id="telefone" tabindex="1" class="form-control" placeholder="Telefone" value="" required onkeyup="mascara('(##) ####-####',this,event,true)" maxlength="14">
									</div>
									<br>

									<label>Endereço da farmácia</label>
									<div class="form-group">
										<input type="text" name="rua" id="rua" tabindex="1" class="form-control" placeholder="Rua" value="" required>
									</div>
									<div class="form-group">
										<input type="number" name="numero" id="numero" tabindex="1" class="form-control" placeholder="Nº" value="" required>
									</div>
									<div class="form-group">
										<input type="text" name="bairro" id="bairro" tabindex="1" class="form-control" placeholder="Bairro" value="" required>
									</div>
									<div class="form-group">
										<input type="complemento" name="complemento" id="complemento" tabindex="1" class="form-control" placeholder="Complemento" value="">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Cadastrar">
											</div>
										</div>
									</div-->
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
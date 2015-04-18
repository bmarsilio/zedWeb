<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<span class="sr-only">Erro:</span>Você precisa se autenticar para acessar este menu!
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<h4 class="text-center login-title">Autentique-se para visualizar os relatórios</h4>
			<div class="account-wall">
				<div class="login-logo">
					<img class="profile-img" src="../../../img/logo.jpg" alt="">
				</div>
				<form class="form-signin" method="post" action="#">
					<input type="text" class="form-control" placeholder="usuário" required autofocus id="user" name="user">
					<br />
					<input type="password" class="form-control" placeholder="senha" required id="pswd" name="pswd">
					<br />
					<button class="btn btn-lg btn-primary btn-block" type="submit">Autenticar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php  
require_once 'src/php/_Class/LoginClassRelatorios.php';

session_start();

    $login = new LoginClassRelatorios();

	$usuario = $_POST['user'];
	$senha   = $_POST['pswd'];

	if($usuario == 'admin'){
    	$auth = $login->authUser($usuario,$senha);
	}

	$autenticado = false;

	if($auth == '1'){
		$autenticado = true;
	}

	if($autenticado){
?>
		<script type="text/javascript">
			window.location = 'relatorios';
		</script>
<?php
	}
?>
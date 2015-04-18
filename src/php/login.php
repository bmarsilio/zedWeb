<?php

//echo __DIR__.'src/php/_Class/LoginClass.php';die;

require_once '_Class/LoginClass.php';
session_start();

    $login = new LoginClass();

	$usuario = $_POST['usuario'];
	$senha   = $_POST['senha'];
	$mesa 	 = $_POST['mesa'];

    $auth = $login->authUser($usuario,$senha);

	$result = 0;

	if($auth == '1'){
		$result = 1;
	}

	if($result == 1){
		$_SESSION['logado'] = true;
		$_SESSION['usuario'] = $usuario;
		$_SESSION['usuarioId'] = $login->getIdUsuario($usuario);
		$_SESSION['nome'] = $login->getNome($usuario);
		$_SESSION['idAtendente'] = $login->getIdAtendente($login->getNome($usuario));
		$_SESSION['mesa'] = $mesa;
	}

	print($result);


?>
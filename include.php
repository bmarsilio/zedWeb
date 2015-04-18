<?php  
	session_start();
	error_reporting(E_ALL^E_NOTICE^E_DEPRECATED);
	//session_destroy();
	//$_SESSION[logado] = true;
	if(!$_SESSION[logado]){die("<script>window.location='login.php';</script>");}
?>
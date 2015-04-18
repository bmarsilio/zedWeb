<?php  
	require_once '../_Class/mysql_class.php';

	$conexao = new mySQLAdapter();

	/*
	* valida se e para incluir nova mensagem de chat no banco ou para remover notificacao de chat
	*/
    if($_GET['notifica']){
    	/*
    	* remove flag que mostra notificacao em tela
    	*/
    	$query = "
    		UPDATE chat SET notifica = 0
    	";
    	
    }else{
		$sql = "
			SELECT 
				coalesce(max(idChat)+1,1) as nextId
			FROM 
				chat
		";

		$sqlNextId = $conexao->sql_query($sql);

		while($dados = mysql_fetch_object($sqlNextId)){
			$dadosNextId = $dados->nextId;
		}

	    $query = "
	        INSERT INTO
	            chat
	                (
	                    idchat, 
	                    idUsuario, 
	                    data, 
	                    mensagem,
	                    notifica
	                )
	        VALUES
	            (
	                '$dadosNextId',
	                '$_POST[usuarioId]',
	                '$_POST[data]',
	                '$_POST[mensagem]',
	                '1'
	            );
	    ";
    }

	$conexao->sql_query($query);
?>
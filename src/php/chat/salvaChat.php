<?php  
	require_once '../_Class/mysql_class.php';

	$conexao = new mySQLAdapter();
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
                    mensagem
                )
        VALUES
            (
                '$dadosNextId',
                '$_POST[usuarioId]',
                '$_POST[data]',
                '$_POST[mensagem]'
            );
    ";

    $conexao->sql_query($query);
?>
<?php
	require_once '../_Class/mysql_class.php';

	$conexao = new mySQLAdapter();

	$data = date('Y-m-d');

    $query = "
			select 
				A.mensagem,
			    B.stLogin
			from 
				chat A
			    inner join zd_user B on (B.idUsuario = A.idUsuario)
			where
				A.data = '$data'
			order by
				A.idChat desc
	";
    
    $resultSet = $conexao->sql_query($query);
    
    while ($row = mysql_fetch_assoc($resultSet)) {
    	print('<p>');
    		print('<strong>');
    			print($row['stLogin'].': ');
    		print('</strong>');
    		print($row['mensagem']);
    	print('</p>');
    }
?>
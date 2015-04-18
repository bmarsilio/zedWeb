<?php
	require_once '../_Class/mysql_class.php';

	$conexao = new mySQLAdapter();

	$data = date('Y-m-d');

    $query = "
			select 
				A.mensagem,
			    B.stLogin,
			    A.notifica
			from 
				chat A
			    inner join zd_user B on (B.idUsuario = A.idUsuario)
			where
				A.data = '$data'
			order by
				A.idChat desc
	";
    
    $resultSet = $conexao->sql_query($query);
    /*
    * imprime as mensagens do dia atual
    */
    while ($row = mysql_fetch_assoc($resultSet)) {
    	print('<p>');
    		print('<strong>');
    			print($row['stLogin'].': ');
    		print('</strong>');
    		print($row['mensagem']);
    	print('</p>');

    	if($row['notifica'] == 1){
    		print('
    			<script>
					if (Notification.permission === \'default\') {
						Notification.requestPermission(function() {
						//console.log(\'Usuário não falou se quer ou não notificações. Logo, o requestPermission pede a permissão pra ele.\');
					});
					}else if (Notification.permission === \'granted\') {
						//console.log(\'Usuário deu permissão\');

						var notification = new Notification(\'Nova Mensagem de Chat\', {
							body: \'\',
							tag: \'string única que previne notificações duplicadas\'
						});
						notification.onshow = function() { 
							setTimeout(notification.close, 3000) 
						},
						notification.onclick = function() {
							var dados = $(\'#mensagem\').serialize();
							$.ajax({
								type: "POST",
								url: "src/php/chat/salvaChat.php?notifica=1",
								data: dados,
								success: function( data )
								{
								}
							});
						},
						notification.onclose = function() {
							//console.log(\'onclose: evento quando a notificação é fechada\');
						},
						notification.onerror = function() {
							//console.log(\'onerror: evento quando a notificação não pode ser exibida. É disparado quando a permissão é defualt ou denied\');
						};
					}else if (Notification.permission === \'denied\') {
						//console.log(\'Usuário não deu permissão\');
					}
    			</script>
    		');
    	}
    }
?>
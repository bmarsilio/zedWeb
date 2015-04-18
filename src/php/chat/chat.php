<?php  
	date_default_timezone_set('America/Sao_Paulo');
	$data = date('Y-m-d');
?>    
<div class="col-md-2" id="divChat" style="height: 500px; overflow-y:scroll;">
	<h4><strong>Chat</strong></h4>
	
	<hr />

	<form class="form-control" method="post" id="chatForm" style="border-style: none;">
			<input type="hidden" name="usuarioId" id="usuarioId" class="form-control" value="<?php echo($_SESSION['usuarioId']) ?>">
			<input type="hidden" name="data" id="data" value="<?php echo($data); ?>">
			<input type="text" name="mensagem" id="mensagem" class="form-control" placeholder="Mensagem . . .">

		<!--<button type="submit" class="btn btn-default">Enviar</button>-->
	</form>

	<hr />
	
	<div id='mensagens'>
	</div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		atualiza();

		$('#chatForm').submit(function(){
			var dados = $('#chatForm').serialize();
			
			$.ajax({
				type: "POST",
				url: "src/php/chat/salvaChat.php",
				data: dados,
				success: function( data )
				{
					document.getElementById("mensagem").value = '';
				}
			});
			return false;
		});
	});


	function atualiza(){
		$.get('src/php/chat/carregaChat.php', function(resultado){
			$('#mensagens').html(resultado);
		})

		setTimeout('atualiza()', 3000);
	}

</script>
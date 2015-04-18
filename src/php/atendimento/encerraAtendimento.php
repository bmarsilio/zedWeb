<?php  
	require_once('src/php/_Class/GerenciaAtendimento.php');

	$gAtendimento = new GerenciaAtendimento();

	$resultado = $gAtendimento->encerraAtendimento($_POST);

	if($resultado){
?>
		<script type="text/javascript">
			window.onload = function(){
			    swal({
					title: "Parabéns!",
					text: "Atendimento Realizado com Sucesso!",
					type: "success"
					},
					function(){
						window.location = 'atendimento';
					});
			}
		</script>
<?php  
	}
?>	
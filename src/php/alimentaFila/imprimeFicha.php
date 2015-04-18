	<link href="../../../bootstrap/css/flatly.min.css" rel="stylesheet"> <!--inclui o css-->
	<link href="../../../bootstrap/css/flatly.css" rel="stylesheet"> <!--inclui o css-->
	<script src="../../../bootstrap/js/jQuery.js"></script>

<?php  
	require_once ('../_Class/GerenciaAtendimento.php');

	$gAtendimento = new GerenciaAtendimento();
	
	//cria o atendimento
	$resultado = $gAtendimento->criaAtendimento($_POST);

	//retorna os dados do ultimo atendimento cadastrado
	$dadosAtendimento = $gAtendimento->mostraUltimoAtendimento();

	while($dados = mysql_fetch_object($dadosAtendimento)){
		$idAtendimento = $dados->idAtendimento;
		$tipoAtendimento = $dados->tipoAtendimento;
	}

	if($_POST['tipo'] == 1 or $_POST['tipo'] == 2 or $_POST['tipo'] == 3){
?>

		<div id="impressao" style="display: show; text-align: center;" class="col-sm-5">
			<h4>Seja Bem-Vindo(a)!</h4>
			Sua senha é <strong><?php echo($idAtendimento) ?></strong>.<hr />
			Seu tipo de atendimento é <strong><?php echo($tipoAtendimento) ?></strong>.<hr />
			Aguarde sua senha ser chamada no <strong>telão</strong>, e se diriga a mesa indicada.<hr />
			Logo mais um de nossos atendentes lhe atenderá.
		</div>

		<script type="text/javascript">
			jQuery(window).load(function($){
				//document.getElementById("divChat").style.display = "none";
				//document.getElementById("footer").style.display = "none";
				//document.getElementById("hr").style.display = "none";
				window.location = 'alimentaFila.php';
				var ok = self.print();

				//garante que sempre apos a impressao volta para a pagina onde digita o tipo (estava com bug que as vezes nao voltava)
				if(ok){
					window.location = 'alimentaFila.php';
				}else{
					window.location = 'alimentaFila.php';
				}
			});
		</script>
<?php  
	}else{
?>
		<script type="text/javascript">
			jQuery(window).load(function($){
				window.location = 'alimentaFila.php';
			});
		</script>
<?php  
	}
?>
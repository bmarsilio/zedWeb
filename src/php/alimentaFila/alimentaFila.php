	<link href="../../../bootstrap/css/flatly.min.css" rel="stylesheet"> <!--inclui o css-->
	<link href="../../../bootstrap/css/flatly.css" rel="stylesheet"> <!--inclui o css-->
	<script src="../../../bootstrap/js/jQuery.js"></script>

<?php  
	require_once ('../_Class/GerenciaAtendimento.php');

	$gAtendimento = new GerenciaAtendimento();
?>

<div class="tab-content" id="divTituloAlimentaFila">
    <div class="tab-pane fade in active">
        <h3>Alimenta Fila</h3><hr />
    </div>
</div>

<form class="form-horizontal" method="POST" id="formData" action="imprimeFicha.php">
	<div class="col-sm-2">
		<input type="text" class="form-control" id="tipo" name="tipo" autofocus="autofocus" maxlength="1"/>
	</div>
</form>

<br />
<br />

<script type="text/javascript">
	$(document).ready(function () {
		/*$('#tipo').change(function(){
			$('#formData').submit();
		});*/

		$('#tipo').bind('keyup', function() {
	    	$('#formData').submit();    
		});

	});
	
</script>
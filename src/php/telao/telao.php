<!DOCTYPE html>
<html>
	<head>
		<title>ZedWeb - Telão</title>
		<meta http-equiv="refresh" content="5" /> 
		<link href="../../../bootstrap/css/flatly.min.css" rel="stylesheet"> <!--inclui o css-->
		<link href="../../../bootstrap/css/flatly.css" rel="stylesheet"> <!--inclui o css-->
		<script src="../../../bootstrap/js/jQuery.js"></script>
		
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home"></span> ZedWeb </a>
				</div>
			</div>
		</nav>
	</head>
	
	<body>
		<?php  
			require_once ('../_Class/GerenciaAtendimento.php');

			$gAtendimento = new GerenciaAtendimento();

			$dadosTelao = $gAtendimento->mostraFilaAtendimentoTelao();

			echo '
			<div class="container">
				<div class="table table-responsive">
				    <table class="table table-hover table-striped table-condensed table-bordered" id="myTable">
				        <thead style="align:center; font-size:45px">
				        	<tr>
						        <th class="text-center"><h2>Senha</h2></th>
						        <th class="text-center"><h2>Tipo Atendimento</h2></th>
						        <th class="text-center"><h2>Mesa</h2></th>
						    </tr>
				        </thead>
						<tbody>
			';
				        while ($row = mysql_fetch_assoc($dadosTelao)) {
				        	if($row['idTipoAtendimento'] == '2'){
				        		$class='danger';
				        	}else if ($row['idTipoAtendimento'] == '1'){
				        		$class='warning';
				        	}else if ($row['idTipoAtendimento'] == "3"){
				        		$class='info';
				        	}
				        	echo '
					            <tr class='.$class.' style="text-align:center; font-size:70px">
					                <td>'.$row['idAtendimento'].'</td>
					                <td>'.$row['tipoAtendimento'].'</td>
					                <td>'.$row['mesa'].'</td>
					            </tr>
				            ';
				        }
			echo '
				        </tbody>
				    </table>
				</div>
			</div>
			';
		?>
	</body>

</html>




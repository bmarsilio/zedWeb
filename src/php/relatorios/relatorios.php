	<div class="tab-content">
		<div class="tab-pane fade in active">
			<h3>Relatório</h3>
		</div>
	</div>
	<hr />
	<?php
		require_once 'src/php/_Class/GerenciaRelatorio.php';

		$gRelatorio = new GerenciaRelatorio();
		$Core = new Core();
		//var_dump($_POST);

		$atendentes = $gRelatorio->retornaListaAtendentes();
		$statusAtendimento = $gRelatorio->retornaListaStatusAtendimento();
		
		if(!$_POST['dtInicio']){
			$dtInicio = date('d/m/Y');
		}else{
			$dtInicio = $_POST['dtInicio'];
		}

		if(!$_POST['dtFim']){
			$dtFim = date('d/m/Y');
		}else{
			$dtFim = $_POST['dtFim'];
		}
		//var_dump($dtInicio);
		
	?>
	<form class="form-horizontal" method="POST" action="#">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-3">
					<label><span class="glyphicon glyphicon-user"></span> Atendente</label>
						<select class="form-control" id="atendente" name="atendente">
							<option value="">Selecione um Atendente</option>
							<?php
								while($dadosAtendente = mysql_fetch_object($atendentes)){
									if($dadosAtendente->idAtendente==$_POST['atendente']){
										$selected = 'selected';
									}else{
										unset($selected);
									}
									print("<option value=".$dadosAtendente->idAtendente." ".$selected.">".$dadosAtendente->nomeAtendente."</option>");
								}
							?>
						</select>
				</div>

				<div class="col-sm-3">
					<label><span class="glyphicon glyphicon-user"></span> Status Atendimento</label>
						<select class="form-control" id="statusAtendimento" name="statusAtendimento">
							<option value="">Selecione um Status</option>
							<?php
								while($dadosStatusAtendimento = mysql_fetch_object($statusAtendimento)){
									if($dadosStatusAtendimento->idStatusAtendimento==$_POST['statusAtendimento']){
										$selected = 'selected';
									}else{
										unset($selected);
									}
									print("<option value=".$dadosStatusAtendimento->idStatusAtendimento." ".$selected.">".$dadosStatusAtendimento->descricaoStatus."</option>");
								}
							?>
						</select>
				</div>

				<div class="col-sm-2">
					<label><span class="glyphicon glyphicon-calendar"></span> Data Inicial</label>
						<input id="dtInicio" maxLength="10" class="form-control dateInput" name="dtInicio" type="text" placeholder="__/__/____" value="<?php echo($dtInicio); ?>" />
				</div>

				<div class="col-sm-2">
					<label><span class="glyphicon glyphicon-calendar"></span> Data Final</label>
						<input id="dtFim" maxLength="10" class="form-control dateInput" name="dtFim" type="text" placeholder="__/__/____" value="<?php echo($dtFim); ?>" />
				</div>

				<div class="col-sm-2">
					<br />
					<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-refresh"></span> Atualizar</button>
				</div>
			</div>
		</div>
	</form>
	<hr />

	<?php
		$resultadoAtendenteAtendimento = $gRelatorio->retornaListaAtendimentoAtendente($_POST);
	?>
	<div class="table table-responsive">
	    <table class="table table-hover table-striped table-condensed" id="myTable">
	        <thead>
	        	<tr>
	        		<th>Data</th>
	        		<th>Atendente</th>
	        		<th>Atendimento</th>
	        		<th>Tempo Atendimento</th>
	        		<th>Observação</th>
	        		<th>Status</th>
	        	</tr>
	       	</thead>
	       	<tbody>
	       		<?php
	       			if($_POST){
		       			while($dadosAtendenteAtendimento = mysql_fetch_object($resultadoAtendenteAtendimento)){
		       				$duracaoAtendimento = $Core->trataHora($dadosAtendenteAtendimento->duracaoAtendimento);
		       				echo ('
		       					<tr>
		       						<td>'.$dadosAtendenteAtendimento->dtSolicitacao.'</td>
		       						<td>'.$dadosAtendenteAtendimento->nomeAtendente.'</td>
		       						<td>'.$dadosAtendenteAtendimento->idAtendimento.'</td>
		       						<td>'.$duracaoAtendimento.'</td>
		       						<td>'.$dadosAtendenteAtendimento->observacao.'</td>
		       						<td>'.$dadosAtendenteAtendimento->stStatusAtendimento.'</td>
		       					</tr>
		       				');
	       				}
	       			}
	       		?>
	       	</tbody>
	    </table>
	</div>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#myTable').dataTable();

	    //$('.dateInput').mask("00/00/0000");
	    //$('.dest').mask("(00)0000-0000");
	} );

	/* Máscaras */
	jQuery(function($){
		$(".dateInput").mask("99/99/9999");

	}

	);
</script>
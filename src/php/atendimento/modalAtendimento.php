<!--<script type="text/javascript">
    function paraTempo(){
        aberto = 0;

        $.ajax({
        	type: "POST",
        	url: "src/php/atendimento/encerraAtendimento.php",
        	data:{ atendimentoId: id },
        	success: function (retorno){
	    		$("#myModal2 .modal-dialog .modal-content .modal-body").html(retorno);
        	}
        })
    }
</script>-->
<?php
	require_once('../_Class/mysql_class.php');
	require_once('../_Class/GerenciaAtendimento.php');

	$idAtendimento = $_POST['atendimentoId'];
	$idAtendente = $_POST['atendentenId'];

	$gAtendimento = new GerenciaAtendimento();
	$business = new mySQLAdapter();

	$sql = "
	    SELECT
	    	A.idAtendimento as idAtend,
	        B.stDescricao as tipoAtendimento,
	        C.stDescricao as statusAtendimento,
	        B.idTipoAtendimento as idTipoAtendimento
	    FROM
	    	zd_atendimento A
	       	INNER JOIN zd_tipoAtendimento B ON(B.idTipoAtendimento = A.idTipoAtendimento)
	        INNER JOIN zd_statusAtendimento C ON(C.idStatusAtendimento = A.idSituacaoAtendimento)
	    WHERE
	    	A.idAtendimento = $idAtendimento
	";

	$resultado = $business->sql_query($sql);

	while($dados = mysql_fetch_object($resultado)){
		$gAtendimento->iniciaAtendimento($dados->idAtend,$dados->idTipoAtendimento,$idAtendente);
	}

	$resultado = $business->sql_query($sql);

	while($dados = mysql_fetch_object($resultado)){
		echo'
			<form role="form" action="encerraAtendimento" method="POST">
				<div class="form-group">
					<label>
						Tempo de Atendimento:
					</label>
					<span id="cronometro">
						00:00:00
					</span>
					<br />

					<label>
						ID Atendimento:
					</label>
					<input type="text" class="form-control" id="idAtendimento" name="idAtendimento" readOnly=readOnly value='.$dados->idAtend.'>
					<br />

					<label>
						Situação:
					</label>
						'.$dados->statusAtendimento.'
					<br />

					<label>
						Tipo de Atendimento:
					</label>
						'.$dados->tipoAtendimento.'
					<br />

					<label>
						Observação:
					</label>
					<textarea placeholder="Utilize este campo para destacar informações pertinentes ao atendimento (Opcional)" class="form form-control" name="observacao"></textarea>
				</div>
				<input type="text" class="invisible" id="idAtendente" name="idAtendente" value='.$idAtendente.'><hr />
				<button type="submit" onclick="paraTempo()" class="btn btn-primary">Encerrar Atendimento</button>
			</form>
		';
	}
	//var_dump($sql);

?>

<script type="text/javascript" language="JavaScript">
    var segundo = 0+"0";
    var minuto = 0+"0";
    var hora = 0+"0";
    var aberto = 1;

    function iniciaTempo(id,idAtendente){
        if (aberto == 1){
            setInterval('tempo()',983);
            //return false;
        }
        
        //monta modal
        $.ajax({
        	type: "POST",
        	url: "src/php/atendimento/modalAtendimento.php",
        	data:{ 
        		atendimentoId: id,
        		atendentenId: idAtendente
        	},
        	success: function (retorno){
	    		$("#myModal .modal-dialog .modal-content .modal-body").html(retorno);
        	}
        })

    }

    function paraTempo(){
        aberto = 0;
    }

    function tempo(){
        if (aberto == 1) {
            if (segundo < 59) {
                segundo++
                if (segundo < 10) {
                    segundo = "0" + segundo
                }
            } else if (segundo == 59 && minuto < 59) {
                segundo = 0 + "0";
                minuto++;
                if (minuto < 10) {
                    minuto = "0" + minuto
                }
            }
            if (minuto == 59 && segundo == 59 && hora < 23) {
                segundo = 0 + "0";
                minuto = 0 + "0";
                hora++;
                if (hora < 10) {
                    hora = "0" + hora
                }
            } else if (minuto == 59 && segundo == 59 && hora == 23) {
                segundo = 0 + "0";
                minuto = 0 + "0";
                hora = 0 + "0";
            }
            document.getElementById("cronometro").innerHTML = hora + ":" + minuto + ":" + segundo;
        }
    }
</script>

<?php
require_once 'src/php/_Class/GerenciaAtendimento.php';

$gAtendimento= new GerenciaAtendimento();

$atendimentosNormal = $gAtendimento->buscaListaAtendimentosNormal();
$atendimentosPreferencial = $gAtendimento->buscaListaAtendimentosPreferencial();
$atendimentosReatendimento = $gAtendimento->buscaListaAtendimentosReatendimento();

?>

<script type="text/javascript">
$(document).ready(function(){
    /*$('#myTable').DataTable();*/
});
</script>

<div class="tab-content">
    <div class="tab-pane fade in active">
        <h4>Atendimento Normal</h4><hr />
    </div>
</div>

<div class="table table-responsive">
    <table class="table table-hover table-striped table-condensed" id="myTable">
        <thead>
        	<tr>
		        <th>ID Atendimento</th>
		        <th>Situação Atendimento</th>
		        <th>Tipo Atendimento</th>
		        <th></th>
		    </tr>
        </thead>
		<tbody>
        <?php
        while ($row = mysql_fetch_assoc($atendimentosNormal)) {
        	$disabled = $gAtendimento->trataDisableBotaoAtendimento($row['idAtendente'],$_SESSION['idAtendente']);
        ?>
            <tr class=<?php $gAtendimento->verificaClasseAtendimento($row['statusAtendimento'],$row['tipoAtendimento']); ?>>
                <td><?php echo $row['idAtend'] ?></td>
                <td><?php echo $row['statusAtendimento'] ?></td>
                <td><?php echo $row['tipoAtendimento'] ?></td>
                <td>
                    <button type="button" class="btn btn-default <?php echo($disabled); ?>" title="Clique aqui para realizar o atendimento" data-toggle="modal" data-target="#myModal" onclick="iniciaTempo(<?php echo $row['idAtend']?>,<?php echo $_SESSION['idAtendente']?>)">
                        <span class=" glyphicon glyphicon-ok"></span>
                    </button>
                </td>
            </tr>
            
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div class="tab-content">
    <div class="tab-pane fade in active">
        <h4>Atendimento Preferencial</h4><hr />
    </div>
</div>

<div class="table table-responsive">
    <table class="table table-hover table-striped table-condensed" id="myTable">
        <thead>
        	<tr>
		        <th>ID Atendimento</th>
		        <th>Situação Atendimento</th>
		        <th>Tipo Atendimento</th>
		        <th></th>
		    </tr>
        </thead>
		<tbody>
        <?php
        while ($row = mysql_fetch_assoc($atendimentosPreferencial)) {
        	$disabled = $gAtendimento->trataDisableBotaoAtendimento($row['idAtendente'],$_SESSION['idAtendente']);
        ?>
            <tr class=<?php $gAtendimento->verificaClasseAtendimento($row['statusAtendimento'],$row['tipoAtendimento']); ?>>
                <td><?php echo $row['idAtend'] ?></td>
                <td><?php echo $row['statusAtendimento'] ?></td>
                <td><?php echo $row['tipoAtendimento'] ?></td>
                <td>
                    <button type="button" class="btn btn-default <?php echo($disabled); ?>" title="Clique aqui para realizar o atendimento" data-toggle="modal" data-target="#myModal" onclick="iniciaTempo(<?php echo $row['idAtend']?>,<?php echo $_SESSION['idAtendente']?>)">
                        <span class=" glyphicon glyphicon-ok"></span>
                    </button>
                </td>
            </tr>
            
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div class="tab-content">
    <div class="tab-pane fade in active">
        <h4>Reatendimento</h4><hr />
    </div>
</div>

<div class="table table-responsive">
    <table class="table table-hover table-striped table-condensed" id="myTable">
        <thead>
        	<tr>
		        <th>ID Atendimento</th>
		        <th>Situação Atendimento</th>
		        <th>Tipo Atendimento</th>
		        <th></th>
		    </tr>
        </thead>
		<tbody>
        <?php
        while ($row = mysql_fetch_assoc($atendimentosReatendimento)) {
        	$disabled = $gAtendimento->trataDisableBotaoAtendimento($row['idAtendente'],$_SESSION['idAtendente']);
        ?>
            <tr class=<?php $gAtendimento->verificaClasseAtendimento($row['statusAtendimento'],$row['tipoAtendimento']); ?>>
                <td><?php echo $row['idAtend'] ?></td>
                <td><?php echo $row['statusAtendimento'] ?></td>
                <td><?php echo $row['tipoAtendimento'] ?></td>
                <td>
                    <button type="button" class="btn btn-default <?php echo($disabled); ?>" title="Clique aqui para realizar o atendimento" data-toggle="modal" data-target="#myModal" onclick="iniciaTempo(<?php echo $row['idAtend']?>,<?php echo $_SESSION['idAtendente']?>)">
                        <span class=" glyphicon glyphicon-ok"></span>
                    </button>
                </td>
            </tr>
            
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

<?php
/*$atendimento = new GerenciaAtendimento();

$resultSet = $atendimento->buscaListaAtendimentos();

while($dados = mysql_fetch_object($resultSet)){
    echo $dados->idAtend;
    echo $dados->tipoAtendimento;
    echo $dados->dtSolicita;
}*/
?>



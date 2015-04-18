<?php  
	require_once('include.php');
	require_once('src/php/_Class/Core.php');

	$Core = new Core();

	$Core->atualizaMesaAtendente($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<title>ZedWeb</title>

	<link href="bootstrap/css/flatly.min.css" rel="stylesheet"> <!--inclui o css-->
	<link href="bootstrap/css/flatly.css" rel="stylesheet"> <!--inclui o css-->
	<link rel="stylesheet" type="text/css" href="bootstrap/dataTable/css/bootstrap-data-table.css">
	<link rel="stylesheet" type="text/css" href="sweetAlert/lib/sweet-alert.css">

	<script src="bootstrap/js/jQuery.js"></script>

	<!--CHAT ANTIGO-->
	<!--<script src='https://cdn.firebase.com/js/client/1.0.17/firebase.js'></script>-->
	
	<script src="sweetAlert/lib/sweet-alert.min.js"></script>
	<script type="text/javascript" src="bootstrap/mask/js/jquery.maskedinput.js"></script>
	
</head>
<?php //require_once('menu.php');?>
<body>
	<?php
		require_once('src/php/layout/topo.php');
		require_once 'src/php/chat/chat.php'; 
	?>
	<div class="col-md-10">
		<?php 

		    $routeList = require_once 'config/routes.config.php';
    
            function verificaRota($routeList,$reqRota){
                
                $validate = false;
                
                foreach ($routeList as $rota){
                    if($rota['routename']==$reqRota){
                        $validate = true;
                        require_once $rota['file'].'.php';
                    }
                }
            
                if($validate==false){
                    require_once 'src/php/layout/404.php';
                }
            }
            
            $rota = $_SERVER["REQUEST_URI"];
            
            verificaRota($routeList, $rota);
		?>
		
	   <?php include_once ('src/php/layout/rodape.php');?>
    </div>
    
    <script src="bootstrap/js/jQuery.js"></script> <!--inclui o jquery-->
	<script src="bootstrap/dataTable/js/jquery.dataTables.min.js"></script>
	<script src="bootstrap/mask/js/jquery.maskedinput.js"></script>
	<script src="bootstrap/dataTable/js/dataTables.bootstrap.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script> <!--iclui o js-->
</body>    
</html>

<!--
modal utilizado na tela de atendimento
-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                <h4 class="modal-title" id="myModalLabel">Encerrar Atendimento</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

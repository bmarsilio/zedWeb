<?php
	require_once('src/php/_Class/Core.php');
	$core = new Core();

	$mesas = $core->retornaListaMesas();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Login, registration forms">
        <meta name="author" content="Seong Lee">
    
        <title>ZedWeb - Sistema de Gerenciamento de Filas de Atendimento</title>
    
        <script src="bootstrap/js/jQuery.js"></script>

        <!-- CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
        <link href="bootstrap/css/animation.css" rel="stylesheet" />
        <link href="bootstrap/css/layout-login.css" rel="stylesheet" />
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    
		<section style="height: 763px;" id="signin_main" class="authenty signin-main">
			<div class="section-content">
			  <div class="wrap">
				  <div class="container">	  
						<div class="form-wrap">
							<div class="row">
								<div class="animated bounceIn" id="form_1" data-animation="bounceIn">
									<div class="form-header">
                                        <h4>ZedWeb</h4>
									  <img src="img/logo.jpg" />
								  </div>
								  <div class="form-main">
									  <form id="form1" method="post" action="src/php/login.php">
									      <div id="result"></div>
									  
										  <div class="form-group">
								  			<input id="un_1" name="usuario" class="form-control" placeholder="Usuário" required="required" type="text" autofocus="autofocus">
											<input id="pw_1" name="senha" class="form-control" placeholder="Senha" required="required" type="password">
											<select id="mesa" name="mesa" class="form-control" required="required">
												<option value="">Selecione uma Mesa</option>
												<?php
													while($row=mysql_fetch_assoc($mesas)){
														echo '<option value='.$row['mesaId'].'>'.$row['mesa'].'</option>';
													}

												?>
											</select>
										  </div>
									    <button id="signIn_1" type="submit" class="btn btn-block signin">Autenticar</button>
									  </form>	
								  </div>
									<div class="form-footer">
										<div class="row">
											<!--<div class="col-xs-7">
												<span class="glyphicon glyphicon-question-sign" style="font-size:20px;"></span>&nbsp; 
												<a style="position:relative;top:-5px;" href="http://alterasenha.ftec.com.br/" id="forgot_from_1">Alterar minha senha</a>
											</div>-->
										</div>
									</div>		
							  </div>
							</div>
						</div>
				  </div>
			  </div>
			</div>
		</section>
		
    	  
        <!-- JS -->
                                                           
		
        <script src="bootstrap/js/bootstrap.js"></script>
        
        <script>
    
    
            $(function(){
                
                $('#form1').submit(function(event){
                    
                    event.preventDefault();
                    
                    $.ajax({
                        type: $(this).prop('method'),
                        url: $(this).prop('action'),
                        data: $(this).serialize(),
                        success: function( data )
                        {
                            //alert(data);
                            if(data==1)
                            {
                               	window.location='index.php';                            
                            }else{
                                $('#result').html('Usuário ou senha inválido(s).');    
                            }
                        }
                    });                
                    
                });
                
            
            });  
        
        
        </script>
      
    
    </body>

</html>
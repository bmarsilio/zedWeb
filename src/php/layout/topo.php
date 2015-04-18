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

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="/atendimento"><span class="glyphicon glyphicon-phone-alt"></span> Atendimento </a></li>

				<?php  
					if($_SESSION['usuario'] == 'admin1' || $_SESSION['usuario'] == 'admin2'){
				?>
						<li><a href="/relatorios"><span class="glyphicon glyphicon-list"></span> Relatório</a></li>
						<li><a href="src/php/alimentaFila/alimentaFila.php"><span class="glyphicon glyphicon-repeat"></span> Alimenta Fila</a></li>
						<li><a href="src/php/telao/telao.php"><span class="glyphicon glyphicon-th-large"></span> Telão</a></li>
				<?php 
					}#endIf
				?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li><a href=""><?php echo $_SESSION['nome']; ?></a></li>
				<li><a href="/logout"><span class="glyphicon glyphicon-ban-circle"></span> Logout </a></li>
			</ul>
		</div>

	</div>
</nav>

<hr id="hr"/>
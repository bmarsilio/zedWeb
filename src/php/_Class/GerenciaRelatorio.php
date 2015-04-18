<?php
	require_once 'mysql_class.php';

	class GerenciaRelatorio
	{
	    private $conexao;

	    /**
	     * Método contrutor que instancia a conexão com o banco.
	     */
	    public function __construct(){
	        $this->conexao = new mySQLAdapter();
	    }

	    public function trataData($data){
	        $resultado = implode( '-', array_reverse( explode( '/', $data ) ) );

	        return $resultado;
	    }

	    public function retornaListaAtendimentoAtendente($dados){

			if(!$dados['dtInicio']){
				$dtInicio = date('d/m/Y');
			}else{
				$dtInicio = $dados['dtInicio'];
			}

			if(!$dados['dtFim']){
				$dtFim = date('d/m/Y');
			}else{
				$dtFim = $dados['dtFim'];
			}

	    	$atendenteId = $dados['atendente'];
	    	$statusAtendimento = $dados['statusAtendimento'];

	    	$dtInicioSql = $this->trataData($dtInicio);
	    	$dtFimSql = $this->trataData($dtFim);

	    	if($dados['atendente']){
	    		$where .= ' AND A.idAtendente = '.$atendenteId.'';
		    	if($dados['statusAtendimento']){
		    		$where .= ' AND A.idStatusAtendimento = '.$statusAtendimento.'';
		    	}
	    	}else{
		    	if($dados['statusAtendimento']){
		    		$where .= ' AND A.idStatusAtendimento = '.$statusAtendimento.'';
		    	}
	    		$where .= ' AND A.idStatusAtendimento is not null';
	    	}


	    	$sql = "
				SELECT
					(
						TIME_TO_SEC(
							(TIME_FORMAT(B.dtSolucao, '%H:%i:%s'))
						)
						-
						TIME_TO_SEC(
							(TIME_FORMAT(B.dtSolicitacao, '%H:%i:%s'))
						)
					) as duracaoAtendimento,
					DATE_FORMAT( B.dtSolicitacao , '%d/%c/%Y' ) as dtSolicitacao,
					DATE_FORMAT( B.dtSolucao , '%d/%c/%Y' ) as dtSolucao,
					B.stObservacao as observacao,
					B.idAtendimento as idAtendimento,
					C.stNome as nomeAtendente,
				    D.stDescricao as stStatusAtendimento
				FROM
					zd_atendenteatendimento A
					INNER JOIN zd_atendimento B ON (B.idAtendimento = A.idAtendimento)
					INNER JOIN zd_atendente C ON (C.idAtendente = A.idAtendente)
				    INNER JOIN zd_statusatendimento D ON (D.idStatusAtendimento = A.idStatusAtendimento)
				WHERE
					1 = 1
					AND B.dtSolicitacao BETWEEN '$dtInicioSql 00:00' AND '$dtFimSql 23:59'
					$where
	    	";
	    	//print("<pre>".$sql."</pre>");
			$resultSet = $this->conexao->sql_query($sql);

			return $resultSet;
	    }

	    public function retornaListaAtendentes(){
	    	$sql = "
				SELECT 
					A.idAtendente AS idAtendente,
				    A.stNome AS nomeAtendente,
				    A.stEmail AS emailAtendente
				FROM 
					zd_atendente A
	    	";

			$resultSet = $this->conexao->sql_query($sql);

			return $resultSet;
	    }

	    public function retornaListaStatusAtendimento(){
	    	$sql = "
				SELECT
					A.idStatusAtendimento as idStatusAtendimento,
				    A.stDescricao as descricaoStatus
				FROM
					zd_statusatendimento A
	    	";

	    	$resultSet = $this->conexao->sql_query($sql);

			return $resultSet;
	    }
	}
?>
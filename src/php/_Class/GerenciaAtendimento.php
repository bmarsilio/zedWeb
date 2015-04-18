<?php

require_once 'mysql_class.php';

class GerenciaAtendimento
{
    private $conexao;

    /**
     * Método contrutor que instancia a conexão com o banco.
     */
    public function __construct(){
        $this->conexao = new mySQLAdapter();
    }

    /**
     * Método destinado a listar todos os atendimentos que estão em aberto.
     */
    public function buscaListaAtendimentos(){
        $query = "
				select
					a.idAtendimento as idAtend,
					a.dtSolicitacao as dtSolicita,
					b.stDescricao as tipoAtendimento,
					C.stDescricao as statusAtendimento,
					D.idAtendente as idAtendente,
					A.idSituacaoAtendimento as idSituacaoAtendimento
				from
					zd_atendimento a
					inner join zd_tipoatendimento b on(b.idTipoAtendimento = a.idTipoAtendimento)
					INNER JOIN zd_statusAtendimento C ON(C.idStatusAtendimento = A.idSituacaoAtendimento)
					LEFT JOIN zd_atendenteatendimento D ON (D.idAtendimento = A.idAtendimento)
				where
					idSituacaoAtendimento in (1,2)
				order by
					b.stDescricao,
					a.idAtendimento asc
		";
        
        $resultSet = $this->conexao->sql_query($query);
        
        return $resultSet;
    }

    /**
     * @param $tipo
     * 
     * Método que retorna a classe css que deve estar em cada linha de atendimentos na tela de ListaAtendimentos
     */
    public function verificaClasseAtendimento($status,$tipo){

    	if($tipo == 'Preferencial'){
	    	if($status == 'em atendimento'){
	    		echo "'info'";
	    	}else{
	    		echo "'warning'";
	    	}
    	}else if($status != 'em atendimento'){
    		echo "'danger'";
    	}

    }

    /**
     * @param $dadosPost
     * 
     * Método destinado a criação de um atendimento na tabela zd_atendimento
     */
    public function criaAtendimento($dadosPost){
    	if($dadosPost['tipo'] == 1 or $dadosPost['tipo'] == 2 or $dadosPost['tipo'] == 3){
	    	$sql = "
	    		SELECT 
	    			coalesce(max(idAtendimento)+1,1) as nextId
	    		FROM 
	    			zd_atendimento
	    	";

	    	$sqlNextId = $this->conexao->sql_query($sql);

	    	while($dados = mysql_fetch_object($sqlNextId)){
	    		$dadosNextId = $dados->nextId;
	    	}

	        $query = "
	            INSERT INTO
	                zd_atendimento
	                    (
		                    idAtendimento, 
		                    idSituacaoAtendimento, 
		                    idTipoAtendimento, 
		                    dtSolicitacao
	                    )
	            VALUES
	                (
	                    '$dadosNextId',
	                    '1',
	                    $dadosPost[tipo],
	                    (select now())
	                );
	        ";

	        $this->conexao->sql_query($query);
    	}
    }

    /* TODO Testar a implementação da Método */
    /**
     * @param $idAtendimento
     * @param $idTipoAtend
     * @param $idAtendente
     * @return bool
     *
     * Classe responsável por atualizar o status na tabela zd_atendimento e também por criar o registro na tabela atendenteAtendimento
     */
    //public function atualizaStatusAtendimento(){
    public function iniciaAtendimento($idAtendimento,$idTipoAtend,$idAtendente){

        /*
         * Esta query irá atualizar o status do atendimento (zd_atendimento) para "Em atendimento"
         *
         */
        $query = "
            UPDATE zd_atendimento
                SET
                    idSituacaoAtendimento=2
            WHERE
                idAtendimento='$idAtendimento'
                and idTipoAtendimento='$idTipoAtend';
        ";

        $this->conexao->sql_query($query);

        /*
         * Está query busca o próximo idAtendenteAtendimento disponível
         *
         */

        $sql = "
    		SELECT
                coalesce(max(idAtendenteAtendimento)+1,1) as nextId
            FROM
                zd_atendenteAtendimento
    	";

        $sqlNextId = $this->conexao->sql_query($sql);

        while($dados = mysql_fetch_object($sqlNextId)){
            $dadosNextId = $dados->nextId;
        }

        //valida se ja nao foi inserido no zd_atendenteAtendimento
        $sql = "
            SELECT 
            	count(*) as count
            FROM
                zd_atendenteatendimento
            WHERE
                idAtendimento='$idAtendimento'
                and idStatusAtendimento=2
        ";

        $sqlCount = $this->conexao->sql_query($sql);

        while($dados = mysql_fetch_object($sqlCount)){
            $dadosCount = $dados->count;
        }
        /*
         * Esta query é responsável pela criação do registro na atendenteAtendimento, referente aos dados de atendimento passados para a função.
         *
         */
        if($dadosCount == 0){
        	$query = "
                INSERT INTO
                zd_atendenteatendimento
                (
                    idAtendenteAtendimento,
                    idAtendimento,
                    idAtendente,
                    idStatusAtendimento
                )
                VALUES
                (
                    '$dadosNextId',
                    '$idAtendimento',
                    '$idAtendente',
                    '2'
                );
	        ";
        }
	        $this->conexao->sql_query($query);

        //echo "Testeeeeeeeeee";
    }

    /**
     * @param $idAtendimento
     * @return array
     * 
     * Método desenvolvido para retornar todos os dados que devem aparecer no modal de atendimento.
     */
    
    public function retornaDadosAtendenteAtendimento($idAtendimento){

        $query = "
            select
                a.idAtendenteAtendimento,
                b.idAtendimento,
                d.stDescricao as Situacao,
                c.stDescricao as Tipo,
                e.stNome as Atendente
            from
                zd_atendenteatendimento a
                inner join zd_atendimento b on (b.idAtendimento = a.idAtendimento)
                inner join zd_tipoatendimento c on(c.idTipoAtendimento = b.idTipoAtendimento)
                inner join zd_statusatendimento d on(d.idStatusAtendimento=b.idSituacaoAtendimento)
                inner join zd_atendente e on(e.idAtendente = a.idAtendente)
            where
                a.idAtendimento = $idAtendimento
        ";

        $dataSet = $this->conexao->sql_query($query);

        while($dados = mysql_fetch_object($dataSet)){
            $dadosAtendimento = array(

                'idAtendenteAtendimento' => $dados->idAtendenteAtendimento,
                'idAtendimento' => $dados->idAtendenteAtendimento,
                'situacao' => $dados->Situacao,
                'tipo' => $dados->Tipo,
                'atendente' => $dados->Atendente
            );
        }

        return true;

    }

    public function mostraFilaAtendimentoTelao(){
        $sql ="
			SELECT distinct
				A.idAtendimento AS idAtendimento,
				B.stNome AS atendente,
				D.stDescricao AS tipoAtendimento,
				D.idTipoAtendimento AS idTipoAtendimento,
                E.stDescricao AS mesa
			FROM 
				zd_atendenteatendimento A
				INNER JOIN zd_atendente B ON (B.idAtendente = A.idAtendente)
				INNER JOIN zd_atendimento C ON (C.idAtendimento = A.idAtendimento)
				INNER JOIN zd_tipoatendimento D ON (D.idTipoAtendimento = C.idTipoAtendimento)
                INNER JOIN zd_mesa E ON (E.idMesa = B.idMesa)
			WHERE
				A.idStatusAtendimento = 2
			ORDER BY
				D.stDescricao,
				A.idAtendimento
		";
        
        $resultSet = $this->conexao->sql_query($sql);
        
        return $resultSet;
    }

    public function encerraAtendimento($dados){
    	//var_dump($dados);
    	$idAtendimento = $dados['idAtendimento'];
    	$observacao = $dados['observacao'];
    	$idAtendente = $dados['idAtendente'];

    	//atualiza dados da tabela zd_atendimento
		$sql = "
			UPDATE 
				zd_atendimento
			SET
				idSituacaoAtendimento=3,
				stObservacao = '$observacao',
				dtSolucao = (select now())
			WHERE
				idAtendimento='$idAtendimento'
		";

		$result1 = $this->conexao->sql_query($sql);

		//atualiza dados da tablea zd_atendenteAtendimento
		$sql="
			UPDATE
				zd_atendenteatendimento
			SET
				idStatusAtendimento = 3
			WHERE
				idAtendimento = '$idAtendimento'
				AND idAtendente = '$idAtendente'
		";

		$result2 = $this->conexao->sql_query($sql);

		if($result1){
			if($result2){
				return true;
			}
		}
    }

    public function trataDisableBotaoAtendimento($idAtendente, $idAtendenSession){
	    if($idAtendente){
			if($idAtendente != $idAtendenSession){
				$disabled = 'disabled';
			}else{
				unset($disabled);
			}
		}else{
			unset($disabled);
		}

		return $disabled;
	}

	public function mostraUltimoAtendimento(){
		$sql="
			SELECT 
				A.idAtendimento AS idAtendimento,
			    B.stDescricao AS tipoAtendimento
			FROM 
				zd_atendimento A
			    INNER JOIN zd_tipoatendimento B ON (B.idTipoAtendimento = A.idTipoAtendimento)
			ORDER BY
				idAtendimento DESC
			LIMIT 1
		";

		$resultSet = $this->conexao->sql_query($sql);

		return $resultSet;
	}
}
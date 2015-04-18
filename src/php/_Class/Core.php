<?php

require_once 'src/php/_Class/mysql_class.php';

class Core
{
    private $conexao;

    public function __construct(){
        $this->conexao = new mySQLAdapter();
    }
    
    public function retornaListaMesas(){
    	$sql = "
    		SELECT
    			A.idMesa as mesaId,
    			A.stDescricao as mesa
    		FROM
    			zd_mesa A
    	";

    	$resultSet = $this->conexao->sql_query($sql);

    	return $resultSet;
    }

    public function atualizaMesaAtendente($dados){
    	$mesa = $dados['mesa'];
    	$idAtendente = $dados['idAtendente'];
    	//var_dump($dados);
    	$sql = "
			UPDATE
				zd_atendente
			SET
				idMesa = $mesa
			WHERE
				idAtendente = $idAtendente
    	";
    	
    	$this->conexao->sql_query($sql);
    }

    public function trataHora($hora){
        $hora = gmdate("H:i:s", $hora);

        explode(":", $hora);
        
        $hora = $hora[0].$hora[1]."h ".$hora[3].$hora[4]."m ".$hora[6].$hora[7]."s";

        return $hora;
    }
} 
<?php

require_once 'src/php/_Class/mysql_class.php';

class LoginClassRelatorios
{
    private $conexao;

    public function __construct(){
        $this->conexao = new mySQLAdapter();
    }

    public function authUser($username, $password){
        $query =  "
                    select
                        count(*) as result
                    from
                        zd_user
                    where
                        stLogin = '$username'
                        and stSenha = md5('$password')
                  ";

        $resultSet = $this->conexao->sql_query($query);



        $count = 0;

        while ($row = mysql_fetch_assoc($resultSet)) {
            $count = $row['result'];
        }

        return $count;
    }

    public function getNome($username){
        $query =  "
			SELECT 
			    B.stNome AS nome
			FROM 
				zd_user A
			    INNER JOIN zd_atendente B ON (B.idUsuario = A.idUsuario)
			WHERE
				A.stLogin = '$username'
        ";

        $resultSet = $this->conexao->sql_query($query);

        while ($row = mysql_fetch_assoc($resultSet)) {
            $nome = $row['nome'];
        }

        return $nome;
    }

    public function getIdAtendente($nomeAtendente){
        $query =  "
			SELECT 
			    A.idAtendente
			FROM 
				zd_atendente A
			WHERE
				A.stNome = '$nomeAtendente'
        ";

        $resultSet = $this->conexao->sql_query($query);

        while ($row = mysql_fetch_assoc($resultSet)) {
            $idAtendente = $row['idAtendente'];
        }

        return $idAtendente;
    }
} 
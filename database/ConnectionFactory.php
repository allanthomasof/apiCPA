<?php
header('Access-Control-Allow-Origin: *');

class ConnectionFactory {

    public static function getDB() {
        $connection = self::getConnection();
        $db = new NotORM($connection);
        return $db;
    }
    
    public static function getConnection() {
    	$base_dados = 'cpa';
		$usuario_bd = 'root';
		$senha_bd   = '';
		$host_db    = 'localhost';
		$charset_db = 'utf8';
		$conexao_pdo = null;
		 
		$detalhes_pdo  = 'mysql:host=' . $host_db;
		$detalhes_pdo .= ';dbname='. $base_dados;
		$detalhes_pdo .= ';charset='. $charset_db;
		 
		try {
		    $conexao_pdo = new PDO($detalhes_pdo, $usuario_bd, $senha_bd);
		} catch (PDOException $e) {
		    print "Erro: " . $e->getMessage() . "<br/>";
		    die();
		}

        return $conexao_pdo;
    }
}
?>
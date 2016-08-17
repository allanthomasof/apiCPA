<?php
header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'database/CPAService.php';
require 'database/notorm/NotORM.php';

$app = new \Slim\Slim();

// Faz Login
$app->post('/fazerLogin/', function() use ( $app ) {
	$login = $app->request()->getBody();
	$login = json_decode($login, true);

	$return = CPAService::validaLogin($login['usuario'], $login['senha']);
	echo $return;
});

// Busca Disciplinas
$app->get('/buscaDisciplinas/', function() use ( $app ) {
	$ID_ALUNO = $app->request()->getBody();
	$ID_ALUNO = json_decode($ID_ALUNO, true);

	$return = CPAService::buscaDisciplinas($ID_ALUNO);
	echo json_encode($return);
});




$app->run();
?>
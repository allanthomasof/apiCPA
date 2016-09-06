<?php
header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'database/CPAService.php';
require 'database/ReportService.php';
require 'database/notorm/NotORM.php';

$app = new \Slim\Slim();


// Fazer Login
$app->post('/fazerLogin/', function() use ( $app ) {
	$login = $app->request()->getBody();
	$login = json_decode($login, true);

	$return = CPAService::validaLogin($login['usuario'], $login['senha']);

	echo $return;
});


// Fazer Login Administrador
$app->post('/fazerLoginAdm/', function() use ( $app ) {
	$login = $app->request()->getBody();
	$login = json_decode($login, true);

    if ($login['usuario']=="admin" && $login['senha']=="admin" )
        echo 1;
    else
        echo 0;
});


// Busca Disciplinas
$app->post('/buscaDisciplinas/', function() use ( $app ) {
	$ID_ALUNO = $app->request()->getBody();
	$ID_ALUNO = json_decode($ID_ALUNO, true);

	$return = CPAService::buscaDisciplinas($ID_ALUNO);
	echo json_encode($return);
});


// Salvar Respostas no Banco de Dados
$app->post('/salvarRespostas/', function() use ( $app ) {
	$JSONRespostas = $app->request()->getBody();
	$JSONRespostas = json_decode($JSONRespostas, true);

    echo CPAService::salvarQuestionario($JSONRespostas);
});


// Verificar se a CPA está aberta
$app->get('/verificaCPA/', function() use ( $app ) {
    echo CPAService::verificaCPA();
});


// Modifica o status da CPA
$app->get('/alteraStatusCPA/', function() use ( $app ) {
    echo CPAService::alteraStatusCPA(CPAService::verificaCPA());
});


// Gerar Relatórios
$app->post('/gerarRelatorio/', function() use ( $app ) {
	$relatorio = $app->request()->getBody();
	$relatorio = json_decode($relatorio, true);

    echo ReportService::gerarRelatorio($relatorio);
});








$app->run();
?>
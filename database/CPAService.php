<?php

class CPAService {
    public static function validaLogin($usuario, $senha) {
        $db = ConnectionFactory::getDB(); 
        $result = array();

        $aluno = $db->ALUNO()->select("ID_ALUNO, NOME, CPA, PERIODO")
                    ->where("ID_ALUNO = $usuario AND SENHA = $senha");

        if($data = $aluno->fetch()){
            echo json_encode(
                array(
                    'ID_ALUNO' => $data['ID_ALUNO'],
                    'NOME' => $data['NOME'],
                    'CPA' => $data['CPA'],
                    'PERIODO' => $data['PERIODO']
                )
            );
        } else {
            return 0;
        } 
    }
    
    public static function buscaDisciplinas($ID_ALUNO) {
        $pdo = ConnectionFactory::getConnection();
        
        //Busca as disciplinas que pertencem ao curso e ao período do aluno
        $consulta = $pdo->prepare("SELECT D.NOME FROM disciplinas D JOIN curso C ON D.ID_CURSO = C.ID_CURSO JOIN aluno AS A ON C.ID_CURSO = A.ID_CURSO WHERE A.ID_ALUNO = '$ID_ALUNO' AND A.PERIODO = D.PERIODO");
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    
    public static function salvarQuestionario($JSONRespostas) {
        $db = ConnectionFactory::getDB(); 
        
        //Insere as respostas na tabela CPA, uma linha para cada disciplina.
        for ($index = 0; $index < sizeof($JSONRespostas); $index++) {
            $application = $db->CPA()->insert($JSONRespostas[$index]);
        }
        
        //Adiciona ao registro do usuário que ele já respondeu ao questionário.
        $pdo = ConnectionFactory::getConnection();
        $aluno = $JSONRespostas[0];        
        $id_aluno = $aluno['id_aluno'];
        $atualiza = $pdo->prepare("UPDATE ALUNO SET CPA = 1 WHERE ID_ALUNO = '$id_aluno'");
        $atualiza->execute();   
        
        return "OK";
    }
    
    public static function verificaCPA() {  
        $db = ConnectionFactory::getDB();   
        //Pega a primeira linha retornada pela consulta
        $status = $db->ESTADO_CPA()[0];
        return $status['STATUS'];
    }
    
    public static function alteraStatusCPA($status) {  
        $pdo = ConnectionFactory::getConnection();
        if ($status == 1) {
            $pdo->prepare("UPDATE ESTADO_CPA SET STATUS = 0")->execute();
            return "A CPA foi fechada!";
        } else {
            $pdo->prepare("UPDATE ESTADO_CPA SET STATUS = 1")->execute();
            $pdo->prepare("UPDATE ALUNO SET CPA = 0")->execute();
            return "A CPA foi aberta!";
        }
    }
}
?>
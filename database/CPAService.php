<?php

class CPAService {
    public static function validaLogin($usuario, $senha) {
        $db = ConnectionFactory::getDB(); 
        $result = array();

        $aluno = $db->ALUNO()->select("ID_ALUNO, NOME, CPA")->where("ID_ALUNO = $usuario AND SENHA = $senha");

        if($data = $aluno->fetch()){
            echo json_encode(
                array(
                    'ID_ALUNO' => $data['ID_ALUNO'],
                    'NOME' => $data['NOME'],
                    'CPA' => $data['CPA']
                )
            );
        } else {
            return 0;
        } 
    }
    
    public static function buscaDisciplinas() {
        $pdo = ConnectionFactory::getConnection();

        $consulta = $pdo->prepare("SELECT D.NOME FROM disciplinas D JOIN curso C ON D.ID_CURSO = C.ID_CURSO JOIN aluno AS A ON C.ID_CURSO = A.ID_CURSO
                                   WHERE A.ID_ALUNO = '88888888' AND A.PERIODO = D.PERIODO");
        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

}
?>
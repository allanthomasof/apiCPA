<?php

class ReportService {
    public static function gerarRelatorio($relatorio) {
        switch ($relatorio['tipo']) {
            case 'G_Universidade' :
                return ReportService::G_Universidade($relatorio['dataInicial'], $relatorio['dataFinal']);
        }
    }
    
    private static function G_Universidade($dataInicial, $dataFinal) {
        $pdo = ConnectionFactory::getConnection();
        
        $consulta = $pdo->prepare("
            SELECT sum(CASE WHEN R01 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R01 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R01 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'
            UNION
            SELECT sum(CASE WHEN R02 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R02 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R02 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'
            UNION
            SELECT sum(CASE WHEN R03 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R03 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R03 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'
            UNION
            SELECT sum(CASE WHEN R04 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R04 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R04 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'
            UNION
            SELECT sum(CASE WHEN R05 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R05 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R05 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'
            UNION
            SELECT sum(CASE WHEN R06 = 'A' THEN 1 ELSE 0 END) as A, sum(CASE WHEN R06 = 'B' THEN 1 ELSE 0 END) as B, sum(CASE WHEN R06 = 'C' THEN 1 ELSE 0 END) as C FROM cpa WHERE DATA_QUEST BETWEEN '$dataInicial' AND '$dataFinal'");

        $consulta->execute();
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        $A = 0; $B = 0; $C = 0;
        foreach($result as $linha) {
            $A = $A + $linha['A'];
            $B = $B + $linha['B'];
            $C = $C + $linha['C'];
        }
        return json_encode(array('A'=> $A, 'B'=> $B, 'C'=> $C));
    }
    
    

}
?>
<?php

require_once("../settings.php");
require_once("../db_conn.php");

// create a table v2_tabela_hits with columns:
// data varchar(12)
// hits int

function increaseHit($dbh) {
    $data = gmdate("Ymd", time());
    $stmt = $dbh->prepare("SELECT * FROM v2_tabela_hits WHERE data = :data");
    $stmt->execute([":data" => $data]);
    if ($stmt->rowCount() == 0) {
        // add today's date
        $sql = "INSERT INTO v2_tabela_hits (data, hits) VALUES (:data, 1)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":data" => $data]);
    } else {
        // increase hit
        $sql = "SELECT hits FROM v2_tabela_hits WHERE data = :data";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":data" => $data]);
        $result = $stmt->fetch();

        $newHits = ((int) $result['hits']) + 1;
        $sql = "UPDATE v2_tabela_hits SET hits = :newHits WHERE data = :data";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([":newHits" => $newHits,
                        ":data" => $data]);
    }
}
    
$page_title = "Tabela de Estoque";

// List directory sorted reverse by time so that we retrieve the newest file

$provided_senha = $_POST['senha'];

if ($provided_senha == $tabelas_senha) {
    $tabelas_folder = dirname(__FILE__) . '/tabelas/';
    $tabelas_folder_xls = dirname(__FILE__) . '/tabelas_xls/';
    $tabelas_folder_htm = dirname(__FILE__) . '/tabelas_htm/';
    
    $files = scandir($tabelas_folder, SCANDIR_SORT_DESCENDING);
    $files_xls = scandir($tabelas_folder_xls, SCANDIR_SORT_DESCENDING);
    $files_htm = scandir($tabelas_folder_htm, SCANDIR_SORT_DESCENDING);

    $newest = $files[0];
    $newest_xls = $files_xls[0];
    $newest_htm = $files_htm[0];

    $content .= "<h3>Tabela de Estoque</h3><br><a href='/tabelas/$newest' data-ajax='false' target='_blank'>Clique aqui para baixar o PDF ($newest) <img src='img/pdf.png'></a>";
    $content .= "<br><br><br>";
    $content .= "<a href='/tabelas_xls/{$newest_xls}' data-ajax='false' target='_blank'>Clique aqui para baixar a planilha XLS ($newest_xls) <img src='img/xls.png'></a>";
    $content .= "<br><br><br>";
    $content .= "<a href='/tabelas_htm/{$newest_htm}' data-ajax='false' target='_blank'>Clique aqui para baixar a página HTML ($newest_htm) <img src='img/html.png'></a>";

    $content .= "<br><br><span style='font-size: 10px;'>Icones (c) 2009 Teambox Technologies, S.L. MIT Licensed</span>";

    // increase hit counter
    increaseHit($dbh);    
} else {
    $content = '
<br><br>
Senha incorreta. <a href="tabela.php" data-ajax="false">Tente novamente</a>
    ';
}
    
    

require_once("template_mapa.php");

?>

<?php
date_default_timezone_set("America/Sao_Paulo");

require("get_dbh.php");

$dbh->exec("update v2_produto set peso='-- (D), -- (R)', preco='--/--' where 1");

$json = file_get_contents("php://input");
$sheet = json_decode($json, true);

echo(count($sheet) . " linhas.\n");

$log_output = "";

ksort($sheet);

$timestamp = date("d/m/Y H:i");

$html = <<<HEADER
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pontual Import Brindes - Tabela de Estoque</title>
<style>
        body {
        font-family: Arial, sans-serif;
        }
        
        table {
        border-collapse: collapse;
        }
        
        td {
        white-space: nowrap;
        padding: 4px 8px;
        }
        
        tr:nth-child(even) {
        background-color: #D8E8EF;
        }

        .bl {
        font-weight: bold;
        }

        .sm {
        font-size: 0.7em;
        }
        
        .nm {
        text-align: right;
        }
</style>
</head>
<body>
<!-- exec_cv_db -->
<h3>Pontual Import Brindes - Tabela de Estoque</h3>
Data e Hora: $timestamp
<table>
        <thead>
        <tr>
        <td class="bl">Código</td>
        <td class="bl">Nome</td>
        <td class="bl">CV</td>
        <td class="bl sm">disponível</td>
        <td class="bl sm">reservado</td>
</tr>
</thead>
<tbody>
HEADER;

// wipe disp_, resv_
$dbh->exec("UPDATE v2_produto set disp_ptl=0, resv_ptl=0, disp_uni=0, resv_uni=0 WHERE 1");

$stmt = $dbh->prepare("update v2_produto set peso=:estoque, preco=:cv, disp_ptl=:disp_ptl, disp_uni=:disp_uni, resv_ptl=:resv_ptl, resv_uni=:resv_uni where codigo=:codigo");

$dbh->beginTransaction();

foreach ($sheet as $cod => $data) {

  $html .= <<<ROW
  <tr>
                <td class="bl">$cod</td>
                <td>${data["nome"]}</td>
                <td class="bl">${data["cv"]}</td>
                <td class='nm'>${data["disp"]}</td>
                <td class='nm'>${data["resv"]}</td>
                </tr>
ROW;


try {
  $stmt->execute([':estoque' => $data["disp"] . " (D), " . $data["resv"] . " (R)",
                  ':cv' => $data["cv"],
                  ':codigo' => $cod,
                  ':disp_ptl' => $data["disp_ptl"],
                  ':disp_uni' => $data["disp_uni"],
                  ':resv_ptl' => $data["resv_ptl"],
                  ':resv_uni' => $data["resv_uni"],
                  ]);

  $log_output .= $cod . " atualizado\n";
} catch (Exception $e) {
  echo($e . "\n");
}

}

$dbh->commit();

$html .= "</tbody></table></body></html>";
$tabelas_target_htm = "../../tabelas_db/";

$randomkey = base_convert(time(), 10, 16);
$uploadfile_htm = $tabelas_target_htm . "estoque_" . "{$randomkey}.html";
file_put_contents($uploadfile_htm, $html);
$log_output = "Gravado o Arquivo HTML estoque_" . $randomkey . "\n\n" . $log_output;

$dbh->exec('insert into v2_log (user_id, entry_datetime, description) values (1, NOW(), "cv")');

echo($log_output);
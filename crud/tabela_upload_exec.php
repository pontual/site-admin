<?php
require_once("get_dbh.php");
require_once("html_head_navbar.php");


function generateRandomString($length = 6) {
    $characters = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$tabelas_target_pdf = "../../tabelas/";
$tabelas_target_xls = "../../tabelas_xls/";
$tabelas_target_htm = "../../tabelas_htm/";
$atualizado = date("YmdHi", time());

$randomkey = generateRandomString(6);

$uploadfile_pdf = $tabelas_target_pdf . "estoque_{$atualizado}_" . "{$randomkey}.pdf";

$uploadfile_xls = $tabelas_target_xls . "estoque_{$atualizado}_" . "{$randomkey}.xls";
$uploadfile_htm = $tabelas_target_htm . "estoque_{$atualizado}_" . "{$randomkey}.html";

if ($_FILES["arquivo_pdf"]["error"] === 0 && $_FILES["arquivo_xls"]["error"] === 0 && $_FILES["arquivo_htm"]["error"] === 0) {
    move_uploaded_file($_FILES["arquivo_pdf"]["tmp_name"], $uploadfile_pdf);
    move_uploaded_file($_FILES["arquivo_xls"]["tmp_name"], $uploadfile_xls);
    move_uploaded_file($_FILES["arquivo_htm"]["tmp_name"], $uploadfile_htm);
    echo $_FILES["arquivo_pdf"]["tmp_name"];
    echo "<BR><BR>";
    echo $uploadfile_pdf;
    echo "<BR><BR>";
    echo $uploadfile_xls;
    echo "<BR><BR>";
    echo $uploadfile_htm;
    echo "<BR><BR>";
    echo "Sucesso.<br><br>";
    
} else {
    
    print("Houve um erro. <a href='javascript:history.back();'>Voltar</a>");
}

require_once("footer.php");
?>

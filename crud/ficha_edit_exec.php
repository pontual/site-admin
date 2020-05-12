<?php

require_once("get_dbh.php");

$campoAntigo = $_POST['campoAntigo'];
$campoNovo = $_POST['campo'];

$sth = $dbh->prepare("select count(*) as ct from v2_ficha where campo = :campo");
$sth->execute([":campo" => $campoNovo]);
$result = $sth->fetch();

if ($campoNovo === $campoAntigo || (int) $result['ct'] === 0) {
  
  $sth = $dbh->prepare("update v2_ficha set campo = :campo, valor = :valor where id = :id");
  
  $sth->execute([ ":campo" => $_POST['campo'],
                  ":valor" => $_POST['valor'],
                  ":id" => $_POST['id']]);
  
  // print("Campo atualizado.");
  
  header("Location: ficha_list.php");
} else {
  require_once("html_head_navbar.php");
  
  print("Alterações não salvas; campo $campoNovo já existe.<br><br>");
  print("Edite o campo existente ou exclua-o primeiro.<br><br>");
  print("<a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
} 

?>

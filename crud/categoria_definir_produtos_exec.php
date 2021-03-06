<?php

require_once("get_dbh.php");
require_once("lista_de_produtos_sql.php"); 

$idCategoria = $_POST["id"];
$listaString = $_POST["lista"];
$lista = explode("\n", trim($listaString));

$nomeAntigo = trim($_POST['nomeAntigo']);
$nomeNovo = trim($_POST['nome']);

$sth = $dbh->prepare("select count(*) as ct from v2_categoria where nome = :nome");
$sth->execute([":nome" => $nomeNovo]);
$result = $sth->fetch();

if ($nomeNovo === $nomeAntigo || (int) $result['ct'] === 0) {
  
  $sth = $dbh->prepare("update v2_categoria set nome = :nome where id = :id");
  
  $sth->execute([ ":nome" => $nomeNovo,
                  ":id" => $_POST['id']]);
  
  $hasErrors = false;

  deleteProdutos($dbh, $idCategoria);

  foreach ($lista as $produto) {
    $produtoExists = insertProduto($dbh, $idCategoria, strtoupper(trim($produto)));
    if (!$produtoExists) {
      $hasErrors = true;
    }
  }

  if ($hasErrors) {
    require_once("html_head_navbar.php");
  } else {
    header("Location: categoria_list.php");
  }
  
} else {
  require_once("html_head_navbar.php");
  
  print("Alterações não salvas; categoria $nomeNovo já existe.<br><br>");
  print("Edite o nome existente ou exclua-o primeiro.<br><br>");
  print("<a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
  
} 


?>

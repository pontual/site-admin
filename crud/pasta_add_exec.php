<?php

require_once("get_dbh.php");

// check if nome already exists

$nome = trim($_POST['nome']);

$sth = $dbh->prepare("select count(*) as ct from v2_pasta where nome = :nome");
$sth->execute([":nome" => $nome]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {

  $sth = $dbh->prepare("insert into v2_pasta (nome)
  values (:nome)");

  $sth->execute([ ":nome" => $nome, ]);

  header("Location: pasta_list.php");
} else {

  require_once("html_head_navbar.php");
  
  print("Nome já existe. <a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
}
?>

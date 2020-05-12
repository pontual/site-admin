<?php

require_once("get_dbh.php");

// check if nome already exists

$nome = trim($_POST['nome']);

$sth = $dbh->prepare("select count(*) as ct from v2_categoria where nome = :nome");
$sth->execute([":nome" => $nome]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {

  $sth = $dbh->prepare("insert into v2_categoria (nome)
  values (:nome)");

  $sth->execute([ ":nome" => $nome ]);

  // retrieve new id
  $sql = 'select id from v2_categoria where nome = :nome';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ':nome' => $nome ]);
  $result = $sth->fetch();
  
  // header("Location: categoria_list.php");
  header("Location: categoria_edit_form.php?id={$result['id']}");
} else {

  require_once("html_head_navbar.php");
  
  print("Nome já existe. <a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
}
?>

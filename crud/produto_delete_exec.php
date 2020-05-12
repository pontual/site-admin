<?php

require_once("get_dbh.php");

if (isset($_GET['id'])) {

  // delete from v2_produtos_de_categoria
  $sql = 'delete from v2_produtos_de_categoria where id_produto = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);

  
  // delete from v2_produto
  $sql = 'delete from v2_produto where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);

  // print("Produto excluido.");

  header("Location: produto_list.php");
} else {
  require_once("html_head_navbar.php");
  print("Nenhum id solicitado.");
  require_once("footer.php");
  
}

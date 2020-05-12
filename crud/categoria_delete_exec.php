<?php

require_once("get_dbh.php");

if (isset($_GET['id'])) {
  // delete from produtos_de_categoria
  $sql = 'delete from v2_produtos_de_categoria where id_categoria = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id'] ]);

  // delete links
  $sql = 'delete from v2_link where id_categoria = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id'] ]);
  
  // delete from categoria
  $sql = 'delete from v2_categoria where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id'] ]);

  header("Location: categoria_list.php");
} else {
  require_once("html_head_navbar.php");
  print("Nenhum id solicitado.");
  require_once("footer.php");
  
}

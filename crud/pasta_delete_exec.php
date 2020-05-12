<?php

require_once("get_dbh.php");

if (isset($_GET['id'])) {
  // delete from links
  $sql = 'delete from v2_link where id_pasta = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id'] ]);

  // delete from pasta
  $sql = 'delete from v2_pasta where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id'] ]);

  header("Location: pasta_list.php");
} else {
  require_once("html_head_navbar.php");
  print("Nenhum id solicitado.");
  require_once("footer.php");
  
}

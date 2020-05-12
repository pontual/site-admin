<?php

require_once("get_dbh.php");

if (isset($_GET['id'])) {
  
  $sql = 'delete from v2_link where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);

  header("Location: pasta_edit_form.php?id={$_GET['pasta']}");
} else {
  require_once("html_head_navbar.php");
  print("Nenhum id solicitado.");
  require_once("footer.php");
  
}

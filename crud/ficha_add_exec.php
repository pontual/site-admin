<?php

require_once("get_dbh.php");

// check if campo already exists

$sth = $dbh->prepare("select count(*) as ct from v2_ficha where campo = :campo");
$sth->execute([":campo" => $_POST["campo"]]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {

  $sth = $dbh->prepare("insert into v2_ficha (campo, valor)
  values (:campo, :valor)");

  $sth->execute([ ":campo" => $_POST['campo'],
                  ":valor" => $_POST['valor'] ]);

  // print("Novo campo inserido.");

  header("Location: ficha_list.php");
} else {

  require_once("html_head_navbar.php");
  
  print("Campo já existe. Para usar mais de um valor, separe-os com barras (/) ou outros símbolos.<br><br><a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
}
?>

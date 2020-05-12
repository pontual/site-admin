<?php

$sth = $dbh->prepare("select count(*) as ct from v2_produto where codigo = :codigo");
$sth->execute([":codigo" => $_POST['codigo']]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {
  // None found
} else {
  print("Código já existe. <a href='javascript:history.back();'>Voltar</a>");
}

?>

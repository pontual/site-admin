<?php

$pageTitle = "Editar campo de Ficha";

require_once("common.php");


if (isset($_GET['id'])) {
  
  $sql = 'select id, campo, valor from v2_ficha where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();
  
  print(generateEditForm("ficha_edit_exec.php", false, [
    "Campo" => [ "name" => "campo", "value" => $result['campo'] ],
    "Valor" => [ "name" => "valor", "value" => $result['valor'] ] ],
                         [ "id" => $result['id'],
                           "campoAntigo" => $result['campo'] ] ));


} else {
  print("Nenhum id solicitado.");
}

  require_once("footer.php");
  
?>

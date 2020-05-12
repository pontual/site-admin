<?php

function printCategoriaOptions($dbh, $currentCategoriaId) {
  // Retrieve all categorias
  
  $sql = "select id, nome from v2_categoria order by nome";
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $categorias = $sth->fetchAll();

  foreach ($categorias as $categoria) {
    print("<option value='{$categoria['id']}'");
    if ((int) $categoria['id'] === (int) $currentCategoriaId) {
      print(" selected");
    }
    print(">{$categoria['nome']}</option>");
  }
}

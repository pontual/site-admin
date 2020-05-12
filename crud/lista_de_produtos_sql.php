<?php

function produtoExists($dbh, $codigo) {
  $sql = 'select count(*) as ct from v2_produto where codigo = :codigo';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":codigo" => strtoupper($codigo) ]);
  $result = $sth->fetch();
  
  if ((int) $result['ct'] === 0) {
    return false;
  } else {
    return true;
  }
}

function insertProduto($dbh, $idCategoria, $codigo) {
  if (produtoExists($dbh, $codigo)) {
    // Check if codigo is already in categoria
    $sql = 'select id from v2_produto where codigo = :codigo';
    $sth = $dbh->prepare($sql);
    $sth->execute([ ":codigo" => strtoupper($codigo) ]);
    $idProduto = $sth->fetch()['id'];
    
    $sql = 'select count(*) as ct from v2_produtos_de_categoria where id_categoria = :idCategoria and id_produto = :idProduto';
    $sth = $dbh->prepare($sql);
    $sth->execute([ ":idCategoria" => $idCategoria,
                    ":idProduto" => $idProduto ]);
    if ((int) $sth->fetch()['ct'] === 0) {
      $sql = 'insert into v2_produtos_de_categoria (id_categoria, id_produto)
select
(select id from v2_categoria where id = :id),
(select id from v2_produto where codigo = :codigo)';
      $sth = $dbh->prepare($sql);
      $sth->execute([ ":id" => $idCategoria,
                      ":codigo" => strtoupper($codigo) ]);
    }

    return true;
  } else {
    require_once("html_head_navbar.php");

    print("Código $codigo não está cadastrado, e não foi incluido. <a href='produto_add_form.php'>Adicionar produto</a><br><br>");

    return false;
  }  
}

function deleteProdutos($dbh, $idCategoria) {
  $sql = "delete from v2_produtos_de_categoria where id_categoria = :idCategoria";
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":idCategoria" => $idCategoria ]);
}

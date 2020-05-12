<?php

require_once("../settings.php");
require_once("../db_conn.php");
require_once("html_util.php");

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// look for lista with given id

$sql = "select count(*) as ct from v2_categoria where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([ ":id" => $id ]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {
  header("Location: inexistente.php");
} else {
  $sql = "select nome from v2_categoria where id = :id";
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $id ]);
  $categoria_nome = $sth->fetch()['nome'];
  
  $page_title = "Lista de produtos - " . $categoria_nome;

  $content = "<div class='categoria_nome'>$categoria_nome</div>";
  
  $sql = "select p.codigo, p.descricao, p.peso, p.medidas, p.preco, p.atualizado from v2_produto p
inner join v2_produtos_de_categoria pc
on p.id = pc.id_produto
where pc.id_categoria = :id
order by p.codigo";

  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $id ]);
  $result = $sth->fetchAll();

  foreach ($result as $produto) {
    // print Card
    $content .= getCard($produto);
  }

  // date_default_timezone_set("America/Sao_Paulo");
  // $content .= "<div class='gerada'>Página gerada " . date("d/m/Y H:i:s") . "</div>";
  
  require_once("template.php");
}

?>

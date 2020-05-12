<?php

require_once("get_dbh.php");

// check if codigo already exists

$sth = $dbh->prepare("select count(*) as ct from v2_produto where codigo = :codigo");
$sth->execute([":codigo" => $_POST['codigo']]);
$result = $sth->fetch();

if ((int) $result['ct'] === 0) {

  // timestamp
  $atualizado = gmdate("YmdHis", time());
  
  $sth = $dbh->prepare("insert into v2_produto (codigo, descricao, peso, medidas, preco, atualizado, normalizado)
  values (:codigo, :descricao, :peso, :medidas, :preco, :atualizado, :normalizado)");

  $sth->execute([ ":codigo" => strtoupper($_POST['codigo']),
                  ":descricao" => $_POST['descricao'],
                  ":peso" => $_POST['peso'],
                  ":medidas" => $_POST['medidas'],
                  ":preco" => $_POST['preco'],
                  ":atualizado" => $atualizado,
                  ":normalizado" => normalizeChars($_POST['codigo'] . " " . $_POST['descricao']) ]);

  // upload foto and create thumbnail

  $uploadfile = $fotos_folder . $_POST['codigo'] .  "_$atualizado" . ".jpg";
  $thumbfile = $fotos_folder . $_POST['codigo'] . "_$atualizado" . "_thumb.jpg";

  if ($_FILES["arquivo_foto"]["error"] === 0) {
    $check = getimagesize($_FILES["arquivo_foto"]["tmp_name"]);
    if ($check !== false) {
      move_uploaded_file($_FILES["arquivo_foto"]["tmp_name"], $uploadfile);

      // create thumbnail
      smart_resize_image($uploadfile, null, $thumbWidth, $thumbHeight, true, $thumbfile, false, false, 100);
    }
  }

  // print("Novo produto inserido.");
  
    // header("Location: produto_list.php");
    header("Location: produto_locate_get.php?codigo=" . $_POST['codigo']);
} else {
  require_once("html_head_navbar.php");
  
  print("Código já existe. <a href='javascript:history.back();'>Voltar</a>");

  require_once("footer.php");
}

?>

<?php

require_once("get_dbh.php");

$codigoAntigo = $_POST['codigoAntigo']; 
$codigoNovo = strtoupper($_POST['codigo']); 

$sth = $dbh->prepare("select count(*) as ct from v2_produto where codigo = :codigo");
$sth->execute([":codigo" => $codigoNovo]);
$result = $sth->fetch(); 

if ($codigoNovo === $codigoAntigo || (int) $result['ct'] === 0) {  
  $sth = $dbh->prepare("update v2_produto set
codigo = :codigo,
descricao = :descricao,
peso = :peso,
medidas = :medidas,
preco = :preco,
normalizado = :normalizado
where id = :id");



  $sth->execute([ ":codigo" => $codigoNovo, 
                  ":descricao" => $_POST['descricao'],
                  ":peso" => $_POST['peso'],
                  ":medidas" => $_POST['medidas'],
                  ":preco" => $_POST['preco'],
                  ":normalizado" => normalizeChars($codigoNovo . " " . $_POST['descricao']),
                  ":id" => $_POST['id']]);

  // print("Produto atualizado.");

  if ($_FILES["arquivo_foto"]['size'] !== 0 && $_FILES["arquivo_foto"]['error'] === UPLOAD_ERR_OK) {
    // update foto
    $atualizado = gmdate("YmdHis", time());

    $sth = $dbh->prepare("update v2_produto set atualizado = :atualizado where id = :id");
    $sth->execute([ ":atualizado" => $atualizado,
                    ":id" => $_POST['id'] ]);

    $uploadfile = $fotos_folder . $codigoNovo . "_$atualizado" . ".jpg";
    $thumbfile = $fotos_folder . $codigoNovo . "_$atualizado" . "_thumb.jpg";

    $check = getimagesize($_FILES["arquivo_foto"]["tmp_name"]);
    if ($check !== false) {
      move_uploaded_file($_FILES["arquivo_foto"]["tmp_name"], $uploadfile);
      smart_resize_image($uploadfile, null, $thumbWidth, $thumbHeight, true, $thumbfile, false, false, 100);
    }

    // print("<br>");
    // print("Foto atualizada.");
  }

    // header("Location: produto_list.php");
    header("Location: produto_edit_form.php?id=" .$_POST['id'] . "&saved=1");
} else {
  require_once("html_head_navbar.php");
  print("Alterações não salvas; código $codigoNovo já existe.<br><br>");
  print("Edite o código existente ou exclua-o primeiro.<br><br>");
  print("<a href='javascript:history.back();'>Voltar</a>");
  require_once("footer.php");
} 

?>


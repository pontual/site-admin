<?php

require_once("get_dbh.php");

$sql = "select id, codigo from v2_produto where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([ ":id" => $_POST['id'] ]);
$result = $sth->fetch();

$uploadfile = $fotos_folder . $result['codigo'] . ".jpg";
$thumbfile = $fotos_folder . $result['codigo'] . "_thumb.jpg";

$check = getimagesize($_FILES["arquivo_foto"]["tmp_name"]);
if ($check !== false) {
  move_uploaded_file($_FILES["arquivo_foto"]["tmp_name"], $uploadfile);
  smart_resize_image($uploadfile, null, $thumbWidth, $thumbHeight, true, $thumbfile, false, false, 100);
}

// print("Foto atualizada.");

header("Location: produto_list.php");
?>

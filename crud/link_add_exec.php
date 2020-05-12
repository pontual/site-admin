<?php

require_once("get_dbh.php");

$idPasta = $_POST["id_pasta"];
$idCategoria = $_POST["id_categoria"];
$nome = $_POST["nome"];

$sth = $dbh->prepare("insert into v2_link (id_pasta, id_categoria, nome)
values (:id_pasta, :id_categoria, :nome)");

$sth->execute([ ":id_pasta" => $idPasta,
                ":id_categoria" => $idCategoria,
                ":nome" => $nome ]);

header("Location: pasta_edit_form.php?id=$idPasta");
?>

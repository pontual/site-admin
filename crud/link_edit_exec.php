<?php

require_once("get_dbh.php");

$sth = $dbh->prepare("update v2_link set nome = :nome, id_categoria = :id_categoria where id = :id");

$sth->execute([ ":nome" => $_POST['nome'],
                ":id_categoria" => $_POST['id_categoria'],
                ":id" => $_POST['id']]);

header("Location: pasta_edit_form.php?id={$_POST['id_pasta']}");

?>

<?php

$sql = 'select id, codigo from v2_produto where id = :id';
$sth = $dbh->prepare($sql);
$sth->execute([ ":id" => $_GET['id']]);
$result = $sth->fetch();

print($result['codigo']);
print($result['id']);

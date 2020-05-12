<?php

require_once("common.php");

if (isset($_GET['codigo'])) {
    $sql = "SELECT c.nome AS nome FROM v2_categoria AS c
INNER JOIN v2_produtos_de_categoria AS pc ON c.id = pc.id_categoria
INNER JOIN v2_produto AS p ON p.id = pc.id_produto
WHERE p.codigo = :codigo
ORDER BY c.nome";

    $sth = $dbh->prepare($sql);
    $sth->execute([":codigo" => $_GET['codigo']]);
    $listas = $sth->fetchAll();

    print("<h1>{$_GET['codigo']}</h1>");
    
    foreach ($listas as $lista) {
        print("{$lista['nome']}<br><br>");
    }
}



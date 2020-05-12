<?php
include("header.php");
?>

<h3 class="title is-3">Exclusão de Produto</h3>
<pre>
    <?php
    $dbh = getdbh();

    $produto_id = (int) ($_GET['produto_id'] ?? '0');

    try {
        $sql_delete_links = "delete from v2_produtos_de_categoria where id_produto = :produto_id";
        
        $sth = $dbh->prepare($sql_delete_links);
        $sth->execute([":produto_id" => $produto_id]);


        $sql_delete_produto = "delete from v2_produto where id = :produto_id";

        $sth = $dbh->prepare($sql_delete_produto);
        $sth->execute([":produto_id" => $produto_id]);
        echo "\nProduto excluído.\n\n";
        echo "Operação concluída.";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>

</pre>


<?php
include("footer.php");

<?php
include("header.php");
?>

<h3 class="title is-3">Exclusão de Categoria</h3>
<pre>
    <?php
    $dbh = getdbh();

    $categoria_id = (int) ($_GET['categoria_id'] ?? '0');

    try {
        $sql_delete_links = "delete from v2_produtos_de_categoria where id_categoria = :categoria_id";
        
        $sth = $dbh->prepare($sql_delete_links);
        $sth->execute([":categoria_id" => $categoria_id]);


        $sql_delete_categoria = "delete from v2_categoria where id = :categoria_id";

        $sth = $dbh->prepare($sql_delete_categoria);
        $sth->execute([":categoria_id" => $categoria_id]);
        echo "\nCategoria excluída.\n\n";
        echo "Operação concluída.";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>

</pre>


<?php
include("footer.php");

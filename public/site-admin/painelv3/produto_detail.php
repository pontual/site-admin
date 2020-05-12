<?php
include("header.php");

$produto_id = (int) ($_GET['produto_id'] ?? '0');
$dbh = getdbh();

$sql = "select codigo, descricao, medidas, atualizado, inativo from v2_produto where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([":id" => $produto_id]);
$row = $sth->fetch();

$codigo = $row['codigo'] ?? "";
$descricao = $row['descricao'] ?? "";
$medidas = $row['medidas'] ?? "";
$atualizado = $row['atualizado'] ?? "";
$inativo = $row['inativo'] ?? 0;

?>
<pre>
    <?= $codigo ?>

    <?php
    if ($atualizado) {
    ?>
        <img src="/fotos/<?= $codigo ?>_<?= $atualizado ?>_thumb.jpg" alt="foto">
    <?php
    }
    ?>
</pre>

<h5 class="title is-5">Categorias do produto</h5>
<h6 class="title is-6">Importante: se for necessário criar uma categoria nova, esta página precisa ser recarregada</h6>
<?php
// check for existing categorias
$sql = "select id_categoria from v2_produtos_de_categoria where id_produto = :produto_id";
$sth = $dbh->prepare($sql);
$sth->execute([":produto_id" => $produto_id]);
foreach ($sth->fetchAll() as $row) {
    $categorias[] = (int) $row['id_categoria'];
    echo $row['id_categoria'] . "<br>";
}
?>

DELETE

    <?php
include("footer.php");

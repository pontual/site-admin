<?php
include("header.php");

$dbh = getdbh();

$id = $_GET['produto_id'];
$sql = "select descricao from v2_produto where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([":id" => $id]);

$row = $sth->fetch();
?>

<h3 class="title is-3">Confirmar exclusão de produto</h3>

<p>
    Realmente excluir <?= $row['descricao'] ?>?
</p>
<br><br>

<a class="button is-danger" href="produto_delete.php?produto_id=<?= $id ?>">Sim, excluir</a>
<br><br><br>
<a class="button is-dark" href="produto_form.php?produto_id=<?= $id ?>">Não, voltar para última página</a>

<?php
include("footer.php");

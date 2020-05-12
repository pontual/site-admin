<?php
include("header.php");

$dbh = getdbh();

$id = $_GET['categoria_id'];
$sql = "select nome from v2_categoria where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([":id" => $id]);

$row = $sth->fetch();
?>

<h3 class="title is-3">Confirmar exclusão de categoria</h3>

<p>
    Realmente excluir <?= $row['nome'] ?>?
</p>
<br><br>

<a class="button is-danger" href="categoria_delete.php?categoria_id=<?= $id ?>">Sim, excluir</a>
<br><br><br>
<a class="button is-dark" href="categoria_form.php?categoria_id=<?= $id ?>">Não, voltar para última página</a>

<?php
include("footer.php");

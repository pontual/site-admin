<?php

$pageTitle = "Atualizar foto";

require_once("common.php");

$sql = "select id, codigo, descricao from v2_produto where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([ ":id" => $_GET["id"] ]);
$result = $sth->fetch();

?>

<h1>Produto: <?= $result['codigo'] ?></h1>

<?= $result['descricao'] ?><br>

<img src="<?= $fotos_folder ?><?= $result['codigo'] ?>_thumb.jpg" alt="<?= $result['codigo'] ?>">
<br><br>

<form action="produto_new_foto_exec.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $result['id'] ?>">
    Arquivo de foto grande sem código:<br> 
    <input type="file" name="arquivo_foto">
    <br>
    <br><br>
    <input type='submit'>
</form>


<?php

require_once("footer.php");

?>

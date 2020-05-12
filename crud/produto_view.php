<?php

require_once("common.php");

if (isset($_GET['id'])) {
  $sql = 'select codigo, descricao, peso, medidas, preco, atualizado from v2_produto where id = :id';
  $sth = $dbh->prepare($sql); 
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();
?>

    <h1>
        Produto <?= $result['codigo'] ?>
    </h1>

    <a href="produto_edit_form.php?id=<?= $_GET['id'] ?>">Editar</a> | <a href="produto_delete_confirm.php?id=<?= $_GET['id'] ?>">Excluir</a>
    <br><br>

    <?= $result['descricao'] ?><br><br>
    Peso:    <?= $result['peso'] ?><br>
    Medidas: <?= $result['medidas'] ?><br>
    Preço:   <?= $result['preco'] ?><br>

    <img src="<?= $fotos_folder ?><?= $result['codigo'] ?>_<?= $result['atualizado'] ?>_thumb.jpg" alt="<?= $result['codigo'] ?>">
<?php

    } else {
      print("Nenhum id solicitado.");
    }
    
    ?>

<?php require_once("footer.php"); ?>

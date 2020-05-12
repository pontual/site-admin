<?php

$pageTitle = "Confirmar exclusão de produto";

require_once("common.php");

if (isset($_GET['id'])) {
  
  $sql = 'select id, codigo from v2_produto where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();
  ?>

    Realmente excluir <span class="dbValue"><?= $result['codigo'] ?></span>?

    <p>
        <a href="produto_delete_exec.php?id=<?= $result['id'] ?>">Sim, excluir</a>
    </p>

    <br><br>
    
    <p>
        <a href="javascript:history.back()">Não, voltar</a>
    </p>
<?php
    
} else {
  print("Nenhum id solicitado.");
}

?>


<?php

require_once("footer.php");
  
?>

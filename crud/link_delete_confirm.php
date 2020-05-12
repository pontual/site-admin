<?php

require_once("common.php");

if (isset($_GET['id'])) {
  
  $sql = 'select id, nome, id_pasta from v2_link where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();
  ?>

    Realmente excluir <span class="dbValue"><?= $result['nome'] ?>?

    <p>
        <a href="link_delete_exec.php?id=<?= $result['id'] ?>&amp;pasta=<?= $result['id_pasta'] ?>">Sim, excluir</a>
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

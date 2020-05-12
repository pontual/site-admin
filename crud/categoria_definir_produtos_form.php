<?php

// DO NOT USE, LATEST CHANGES ARE IN categoria_edit_form.php

require_once("common.php");

// add / edit as textareas

if (isset($_GET['id'])) {
  
  $sql = 'select id, nome from v2_categoria where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $nomeResult = $sth->fetch();

  $nome = trim($nomeResult['nome']);

  $sql = 'select p.codigo from v2_produto as p inner join v2_produtos_de_categoria as c on c.id_categoria = :id_categoria and c.id_produto = p.id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id_categoria" => $_GET['id']]);
  $listaResult = $sth->fetchAll();

  $listaString = "";
  foreach ($listaResult as $listaItem) {
    $listaString .= $listaItem['codigo'] . "\n";
  }

?>
    <form action="categoria_definir_produtos_exec.php" method="POST">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <table>
            <tr><td>Nome</td><td><?= $nome ?></td></tr>
            <tr><td>Lista</td><td><textarea name="lista" rows="22" cols="12"><?= $listaString ?></textarea></td></tr>
            <tr><td>&nbsp;</td><td><input type="submit"></td></tr>
        </table>

    </form>

<?php

} else {
  print("Nenhum id solicitado.");
}

  require_once("footer.php");
  
?>

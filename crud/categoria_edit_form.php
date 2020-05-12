<?php

require_once("common.php");

if (isset($_GET['id'])) {
  
  $sql = 'select id, nome from v2_categoria where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();

  $nome = trim($result['nome']);
  
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
        <input type="hidden" name="nomeAntigo" value="<?= $nome ?>">

        <table>
            <tr><td>Nome</td><td><input name="nome" size="60" value="<?= $nome ?>" autofocus></td></tr>
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

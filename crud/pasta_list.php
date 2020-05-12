<?php

require_once("common.php");

?>
<h1>
    Menu
</h1>

<h3>
    + <a href="pasta_add_form.php">Criar nova pasta</a>
</h3>

<p>
    Uma pasta precisa de pelo menos um Link para aparecer no Menu.
</p>

<p>
    Se a pasta contém apenas um Link, a pasta é convertida num Link.
</p>

<p>
    Clique em "Editar" para adicionar Links.
</p>

<p>
    A ordem padrão das pastas é alfabética, porém, é possível usar símbolos especiais no começo do nome para colocar pastas no topo ou no fim da lista.
</p>

<p>
    Os símbolos # e $ põem a pasta no topo, e ~ (til) põe a pasta no fim.
</p>

<table>
    <tr>
        <td>&nbsp;</td>
        <td>Nome da pasta</td>
        <td>Número de links</td>
        <td>&nbsp;</td>
    </tr>
    <?php

    function countLinksInPasta($dbh, $id) {
      $sql = 'select count(*) as ct from v2_link where id_pasta = :id';
      $sth = $dbh->prepare($sql);
      $sth->execute([ ":id" => $id ]);
      return $sth->fetch()['ct'];
    }
    
    $sql = 'select id, nome, ascii(nome) as ascii from v2_pasta order by ascii';
    foreach ($dbh->query($sql) as $row) {
      $numLinks = countLinksInPasta($dbh, $row['id']);
      if ((int) $numLinks === 0) {
        $linksNotice = " (vazia)";
      } else {
        $linksNotice = "";
      }
      
      printListRow("pasta", $row['id'], [
        $row['nome'], $numLinks . $linksNotice ]);        
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

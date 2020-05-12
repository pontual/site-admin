<?php

require_once("common.php");

?>
<h1>
    Listas de produtos
</h1>

<h3>
    + <a href="categoria_add_form.php">Criar nova lista</a>
</h3>

<p>
    Uma lista de produtos é uma coleção de produtos que tenham algo em comum.
</p>

<p>
    Elas existem para facilitar a criação de Links. Vários Links como <i>Chaveiros com Lanterna</i>, e <i>Lanternas com Chaveiro</i>, que são sinônimos, podem existir em pastas diferentes. Todos eles apontam à mesma Lista de produtos.
</p>

<p>
    A adição ou remoção de um produto é feito apenas uma vez na Lista correta. Não é necessário manter duas listas separadas para estes dois Links. 
</p>

<p>
    Uma lista não aparece automaticamente nas páginas. Ela tem que ser adicionada como um Link pela configuração do <a href="pasta_list.php">Menu</a>.
</p>

<table>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Identificação</td>
        <td>Número de prods.</td>
        <td>Primeiros 3 prods.</td>
        <td>&nbsp;</td>
    </tr>
    <?php

    function countCategoriaItems($dbh, $id) {
      $sql = 'select count(*) as ct from v2_produtos_de_categoria where id_categoria = :id';
      $sth = $dbh->prepare($sql);
      $sth->execute([ ":id" => $id ]);
      return $sth->fetch()['ct'];
    }

    function getFirstThreeItems($dbh, $id) {
      $sql = 'select p.codigo as codigo from v2_produto p
inner join v2_produtos_de_categoria pc
on pc.id_produto = p.id
where pc.id_categoria = :id order by codigo limit 3';
      $sth = $dbh->prepare($sql);
      $sth->execute([ ":id" => $id ]);
      $items = $sth->fetchAll();
      $out = "";
      foreach ($items as $item) {
        $out .= $item['codigo'] . " ";
      }
      return $out . "...";
    }
    
    $sql = 'select id, nome from v2_categoria order by nome';
    foreach ($dbh->query($sql) as $row) {
      printListRowCategoria("categoria", "Editar / adicionar produtos", $row['id'], [
        $row['nome'],
        countCategoriaItems($dbh, $row['id']),
        getFirstThreeItems($dbh, $row['id']) ]);
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

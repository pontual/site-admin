<?php

require_once("common.php");
require_once("link_dropdown.php");

if (isset($_GET['id'])) {
  
  $sql = 'select id, nome from v2_pasta where id = :id';
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":id" => $_GET['id']]);
  $result = $sth->fetch();

  $nome = trim($result['nome']);
?>
    <h3>Alterar nome:</h3>
    
    <?php
    
    print(generateEditForm("pasta_edit_exec.php", false, [
      "Nome" => [ "name" => "nome", "value" => $nome ] ],
                           [ "id" => $result['id'],
                             "nomeAntigo" => $nome ]));
    ?>

    <?php
    $sql = "select p.nome as pasta_nome, c.nome as categoria_nome, k.nome as link_nome, ascii(k.nome) as ascii, k.id as link_id from v2_link as k
    inner join v2_pasta as p
    on p.id = k.id_pasta
    inner join v2_categoria as c
    on c.id = k.id_categoria
    where k.id_pasta = :id_pasta
order by ascii, link_nome";

    $sth = $dbh->prepare($sql);
    $sth->execute([ ":id_pasta" => $_GET['id'] ]);
    $result = $sth->fetchAll();
    ?>
    
    <h3>
        Links existentes:
    </h3>

    <table>
        <tr>
            <td>&nbsp;</td>
            <td>Nome do link</td>
            <td>Lista</td>
            <td>&nbsp;</td>
        </tr>
        
        <?php
        
        foreach ($result as $row) {
        print("<tr>
<td><a href='link_edit_form.php?id={$row['link_id']}'>Editar</a></td>
<td>{$row['link_nome']}</td>
<td>{$row['categoria_nome']}</td>
<td><a href='link_delete_confirm.php?id={$row['link_id']}'>Excluir</a></td>
        </tr>");
        }
        ?>
        
    </table>
    
    <h3>
        Adicionar link:
    </h3>

    <form action="link_add_exec.php" method="POST">
        <input type="hidden" name="id_pasta" value="<?= $_GET['id'] ?>">
        <table>
            <tr>
                <td>Nome</td>
                <td><input name="nome" size="60"></td>
            </tr>
            <tr>
                <td>Lista</td>
                <td>
                    <select name="id_categoria">
                        <?php

                        printCategoriaOptions($dbh, -1);
                        
                        ?>
                        
                    </select>
                </td>
            </tr>
            
            <tr><td>&nbsp;</td><td><input type="submit"></td></tr>
        </table>
    </form>

<?php
    } else {
    print("Nenhum id solicitado.");
    }

    require_once("footer.php");
    
    ?>

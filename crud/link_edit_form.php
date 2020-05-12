<?php

require_once("common.php");
require_once("link_dropdown.php");

// get link name
$sql = "select nome, id_categoria, id_pasta from v2_link where id = :id";
$sth = $dbh->prepare($sql);
$sth->execute([ ":id" => $_GET['id'] ]);
$row = $sth->fetch();
$nome = $row['nome'];
$idPasta = $row['id_pasta'];

?>
    <form action="link_edit_exec.php" method="POST">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <input type="hidden" name="id_pasta" value="<?= $idPasta ?>">
        <table>
            <tr>
                <td>Nome</td>
                <td><input name="nome" size="60" value="<?= $nome ?>"></td>
            </tr>
            <tr>
                <td>Lista</td>
                <td>
                    <select name="id_categoria">
                        <?php

                        printCategoriaOptions($dbh, $row['id_categoria']);
                        
                        ?>
                        
                    </select>
                </td>
            </tr>
            
            <tr><td>&nbsp;</td><td><input type="submit"></td></tr>
        </table>
    </form>

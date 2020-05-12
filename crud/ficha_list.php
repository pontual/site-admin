<?php

require_once("common.php");

?>
<h1>
    Ficha
</h1>

<h3>
    + <a href="ficha_add_form.php">Criar novo campo</a>
</h3>

<table>
    <tr>
        <td>&nbsp;</td>
        <td>Campo</td>
        <td>Valor</td>
        <td>&nbsp;</td>
    </tr>
    <?php
    
    $sql = 'select id, campo, valor from v2_ficha order by campo';
    foreach ($dbh->query($sql) as $row) {
      printFichaListItem("ficha", $row['id'], $row['campo'], $row['valor']);
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

<?php

require_once("common.php");

?>

<table>
    
    <?php
    
    $sql = 'selecerror id, campo, valor from v2_ficha order by campo';
    foreach ($dbh->query($sql) as $row) {
      printListItem("ficha", $row['id'], $row['campo'], $row['valor']);
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

<?php
throw new Exception("Threw an exception");

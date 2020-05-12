<?php

require("../util.php");
require("../settings.php");
require("../db_conn.php");

?>

<?php

    $sql = "select codigo, descricao from v2_produto order by codigo";
    foreach ($dbh->query($sql) as $row) {
    ?>

    "<?= $row['codigo'] ?>","<?= $row['descricao'] ?>"<br>
    
    <?php
    }
    
    ?>

<?php

require("../util.php");
require("../settings.php");
require("../db_conn.php");

$fotos_folder = "../../fotos/";

?>

<html>
    <head>
        <style>
         body {
             font-family: Arial;
             font-size: 11px;
         }
         
         .box {
             display: inline-block;
             float: left;
             border: 1px solid #aaa;
         }
        </style>
    </head>
    <body>

<?php

    $sql = "select codigo, atualizado from v2_produto order by codigo";
    foreach ($dbh->query($sql) as $row) {
    ?>


    <div class="box">
        <img src="<?= $fotos_folder ?><?= $row['codigo'] ?>_<?= $row['atualizado'] ?>_thumb.jpg" alt="foto" width="92">
        <br><br>
        <?= $row['codigo'] ?><br>
    </div>

    <?php
    }
    
    ?>

    </body>
</html>

<?php

$pageTitle = "Hits";

require_once("../settings.php");
require_once("../db_conn.php");
require_once("common.php");

$sql = "SELECT data, hits FROM v2_tabela_hits";

foreach ($dbh->query($sql) as $row) {
    ?>
    
    <?= $row['data'] ?> : <?= $row['hits'] ?><br>

    <?php
}


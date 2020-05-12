<?php

require_once("../settings.php");
require_once("../db_conn.php");

function telLink($s) {
  if (strlen($s) < 11) {
    return "011" . preg_replace("/[^0-9]+/", "", $s);
  } else {
    return "0" . preg_replace("/[^0-9]+/", "", $s);
  }
}

$sql = "select campo, valor from v2_ficha";
$sth = $dbh->query($sql);
$result = $sth->fetchAll();

$ficha = array();

foreach ($result as $row) {
  $ficha[$row['campo']] = htmlspecialchars($row['valor']);
}

?>

<table class="info_table">
    <tr>
        <td>
            <a href="index.php" data-ajax="false">
                <img src="/fotos/logo.jpg" alt="Logo">
            </a>
        </td>
        <td class="info_header table_left table_vertical_bottom">
            <!-- Pontual Import Brindes -->
            <a href="index.php" data-ajax="false">
                <?= $ficha['nome_fantasia'] ?>
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <a href="mapa.php" data-ajax="false">
                <img src="img/icomoon-location.png" alt="Endereço" title="Localização">
            </a>
        </td>
        <td class="table_left">
            <a href="mapa.php" data-ajax="false">
                <!--
                R. Antônio de Andrade, 109 - Canindé<br>
                São Paulo, SP - CEP 03034-080
                -->
                <?= $ficha['logradouro'] ?> - <?= $ficha['bairro'] ?><br>
                <?= $ficha['cidade'] ?>, <?= $ficha['estado'] ?> - CEP <?= $ficha['cep'] ?>
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <a href="tel:<?= telLink($ficha['telefone_1']) ?>" data-ajax="false">
                <img src="img/icomoon-phone.png" alt="Telefone" title="Telefone">
            </a>
        </td>
        <td class="table_left">
            <a href="tel:<?= telLink($ficha['telefone_1']) ?>" data-ajax="false"><?= $ficha['telefone_1'] ?></a>
            <?php
            if (isset($ficha['telefone_2'])) {
              print(" / <a href='tel:" . telLink($ficha['telefone_2']) . "' data-ajax='false'>{$ficha['telefone_2']}</a>");
            }

            if (isset($ficha['telefone_3'])) {
              print(" / <a href='tel:" . telLink($ficha['telefone_3']) . "' data-ajax='false'>{$ficha['telefone_3']}</a>");
            }
            ?>
        </td>
    </tr>
</table>

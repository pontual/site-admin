<!-- MENU -->
<div data-role="panel" class="jqm-navmenu-panel" data-position="left" id="menu" data-display="overlay" data-theme="b" data-ajax="false">
    <ul class="jqm-list ui-alt-icon ui-nodisc-icon">
        <li data-icon="home"><a href="index.php" data-ajax="false">Home</a></li>
        <li data-icon="false"><a href="tabela.php" data-ajax="false">Tabela de Estoque</a></li>


        <?php
        require("../db_cls.php");
        $dbh = getdbh();

        function removeSymbols($s) {
            return preg_replace('/[$#~]/u', '', $s);
        }

        function sanitizedMenu($s) {
            return htmlspecialchars(removeSymbols($s));
        }

        function getCategorias($dbh) {
            $sql = 'select id, nome from v2_categoria where inativo = 0 order by nome';
            $sth = $dbh->query($sql);
            return $sth->fetchAll();
        }

        $cats = getCategorias($dbh);
        foreach ($cats as $cat) {
            $nome = sanitizedMenu($cat['nome']);
            print("<li data-icon='false'><a href='lista.php?id=" . htmlspecialchars($cat['id']) . "' data-ajax='false'><span class='no-ellipsis'>" . htmlspecialchars($cat['nome']) . "</span></a></li>\n\n");
        }
        
        ?>
        
        <li data-icon="false"><span class="no-ellipsis">(C) 2017-2020 Pontual Exportação e Importação Ltda.</span></li>
    </ul>
</div> <!-- END MENU -->


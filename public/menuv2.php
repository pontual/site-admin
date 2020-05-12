<!-- MENU -->
<div data-role="panel" class="jqm-navmenu-panel" data-position="left" id="menu" data-display="overlay" data-theme="b" data-ajax="false">
    <ul class="jqm-list ui-alt-icon ui-nodisc-icon">
        <li data-icon="home"><a href="index.php" data-ajax="false">Home</a></li>
        <li data-icon="false"><a href="tabela.php" data-ajax="false">Tabela de Estoque</a></li>


        <?php
        require_once("get_dbh.php");
        
        function getPastas($dbh) {
          $sql = 'select p.id, p.nome, ascii(p.nome) as ascii, (select count(*) from v2_link lnk where lnk.id_pasta = p.id) as ct from v2_pasta p order by ascii, p.nome';
          $sth = $dbh->query($sql);
          return $sth->fetchAll();
        }

        function getLinks($dbh, $idPasta) {
          $sql = 'select lnk.nome, lnk.id, lnk.id_categoria as id_cat, ascii(lnk.nome) as ascii from v2_link as lnk
inner join v2_pasta p
on p.id = lnk.id_pasta
where lnk.id_pasta = :id_pasta
order by ascii, lnk.nome';
          $sth = $dbh->prepare($sql);
          $sth->execute([ ":id_pasta" => $idPasta ]);
          
          return $sth->fetchAll();
        }

        $pastas = getPastas($dbh);
        foreach ($pastas as $pasta) {
          $numLinks = (int) $pasta['ct'];
          $nome = sanitizedMenu($pasta['nome']);
          if ($numLinks === 1) {

            // Single link
            
            $link = getLinks($dbh, $pasta['id'])[0];
            print("<li data-icon='false'><a href='lista.php?id=" . htmlspecialchars($link['id_cat']) . "' data-ajax='false'><span class='no-ellipsis'>" . htmlspecialchars($link['nome']) . "</span></a></li>\n\n");
          } elseif ($numLinks > 1) {
            
            // Multiple links
            
            print("<li data-role='collapsible' data-collapsed-icon='carat-d' data-expanded-icon='carat-u' data-iconpos='right' data-inset='false'>
<h3><span class='no-ellipsis'>$nome</span></h3>
<ul>\n");
            foreach (getLinks($dbh, $pasta['id']) as $link) {
              print("  <li data-icon='false'><a href='lista.php?id=" . htmlspecialchars($link['id_cat']) . "' class='submenu-link' data-ajax='false'><span>" . sanitizedMenu(htmlspecialchars($link['nome'])) . "</span></a></li>\n");
            }
            print("</ul>\n");
          }
          // implicitly skip pasta with 0 links
        }
        
        ?>
        
        <li data-icon="false"><span class="no-ellipsis">(C) 2017-2019 Pontual Exportação e Importação Ltda.</span></li>
    </ul>
</div> <!-- END MENU -->


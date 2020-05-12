<?php

require_once("../settings.php");
require_once("../db_conn.php");
require_once("normalize_chars.php");
require_once("html_util.php");
require('xorenc.php');

$page_title = "Busca";

if (isset($_GET['q'])) {
  $buscaOrig = htmlentities($_GET['q']);

  $busca = trim(preg_replace("/[^a-z0-9\s\/\-]+/", "", normalizeChars($_GET['q'])));

  // add wildcards on whitespace
  $busca = preg_replace("/\s/", "%", $busca);
  
  $content = "<div class='categoria_nome'>Busca: $buscaOrig</div>";

// get last cv time
$log_sql = "select entry_datetime from v2_log where description='cv' order by entry_datetime desc limit 1";
$log_sth = $dbh->prepare($log_sql);
$log_sth->execute();
$log_result = $log_sth->fetch();

  $content .= "<br>Dados atualizados em " . date("d/m/Y H:i", strtotime($log_result['entry_datetime']));

$content .= <<<END

<div class="ui-grid-a">
<div id="senhaCollapsible" data-role="collapsible" class="ui-block-a">
  <h4>Login de Cliente</h4>
  <p>
  <b>Aviso:</b> Os dados têm apenas caráter informativo.
Confirme as condições com sua vendedora antes de fazer seu pedido.
  </p>
  <p>
Os dados representam o estoque no instante exibido (por exemplo, 25/07/19 11:32), e não em tempo real.
  </p>
  <form id="senhaForm">
    <input id="senhaText" type="password" placeholder="Digite a senha aqui...">
    <input id="senhaSubmit" type="submit" value="Fazer Login">
  </form>
  <div data-role="popup" id="senhaIncorreta">
  <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
  <p>Senha incorreta. Tente novamente.</p>
  </div>

  <div data-role="popup" id="senhaCorreta">
  <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
  <p>
  <br><br>
Bem-vindo(a), cliente!
  <br><br><br>
  </p>
  </div>

</div>
<div class="ui-block-b">
<form>
<input type="button" value="Fazer Logoff" data-theme="b" onclick="logoff();">
</div>
</div>

<script>
document.getElementById("senhaForm").addEventListener("submit",
function(event) { event.preventDefault(); confirmarSenha(); });
</script>
END;

  $cvs = "";

  // count total produtos for pagination
  $sql = "select count(*) as ct from v2_produto where normalizado like :query and inativo = 0";
  $sth = $dbh->prepare($sql);
  $sth->execute([ ":query" => "%$busca%" ]);
  $result = $sth->fetch();
  $totalRows = $result['ct'];

  if ((int) $totalRows === 0) {
    $content .= "<div class='categoria_nome'>Nenhum produto encontrado.</div>";
  } else {
   
    $rowsPerPage = 12;
    $totalPages = ceil($totalRows / $rowsPerPage);

    if (isset($_GET['pg']) && is_numeric($_GET['pg'])) {
      $currentPage = (int) $_GET['pg'];
    } else {
      $currentPage = 1;
    }

    if ($currentPage > $totalPages) {
      $currentPage = $totalPages;
    }

    if ($currentPage < 1) {
      $currentPage = 1;
    }

    $offset = ($currentPage - 1) * $rowsPerPage;

    $previousPage = $currentPage - 1;
    $nextPage = $currentPage + 1;

    // current page (not a link)
    $content .= "<div class='busca_pagina'>Página $currentPage</div>";
    
    // Pagination links 
    $numPageLinks = 3;
    $buscaEncoded = urlencode($buscaOrig);

    $content .= "<div class='pages'>\n";
    
    if ($currentPage > 1) {
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=1' data-ajax='false'>Início</a>&nbsp;";
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=$previousPage' data-ajax='false'>&lt; Anterior</a>&nbsp;";
    } else {
      $content .= ""; // Início &lt; Anterior&nbsp;";
    }

    // numbered links
    $leftmostPage = max(1, $currentPage - $numPageLinks);
    for ($i = $leftmostPage; $i < $currentPage; $i++) {
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=$i' data-ajax='false'>$i</a>&nbsp;";
    }

    // current page (not a link)
    $content .= "$currentPage";

    $rightmostPage = min($totalPages, $currentPage + $numPageLinks);
    for ($i = $currentPage + 1; $i <= $rightmostPage; $i++) {
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$i' data-ajax='false'>$i</a>";
    }

    if ($currentPage < $totalPages) {
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$nextPage' data-ajax='false'>Próxima &gt;</a>";
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$totalPages' data-ajax='false'>Fim</a>";
    } else {
      $content .= ""; // &nbsp;Próxima &gt; Fim";
    }

    $content .= "</div>"; 

    $sql = "select p.codigo, p.descricao, p.peso, p.medidas, p.preco, p.atualizado from v2_produto p
where p.normalizado like :query and p.inativo = 0
order by p.codigo
limit $offset, $rowsPerPage";

    $sth = $dbh->prepare($sql);
    $sth->execute([ ":query" => "%$busca%" ]);
    $result = $sth->fetchAll();

    foreach ($result as $produto) {
      // print Card
      $content .= getCard($produto);
      $cvs .= "\"cv${produto['codigo']}\": \"" . xorenc($produto['peso'] . "<br>" . $produto['preco'], $senhaconsulta) . "\",\n";
    }

    $content .= "<div class='pages'>\n";
    
    if ($currentPage > 1) {
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=1' data-ajax='false'>Início</a>&nbsp;";
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=$previousPage' data-ajax='false'>&lt; Anterior</a>&nbsp;";
    } else {
      $content .= ""; // Início &lt; Anterior&nbsp;";
    }

    // numbered links
    $leftmostPage = max(1, $currentPage - $numPageLinks);
    for ($i = $leftmostPage; $i < $currentPage; $i++) {
      $content .= "<a href='busca.php?q=$buscaEncoded&amp;pg=$i' data-ajax='false'>$i</a>&nbsp;";
    }

    // current page (not a link)
    $content .= "$currentPage";

    $rightmostPage = min($totalPages, $currentPage + $numPageLinks);
    for ($i = $currentPage + 1; $i <= $rightmostPage; $i++) {
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$i' data-ajax='false'>$i</a>";
    }

    if ($currentPage < $totalPages) {
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$nextPage' data-ajax='false'>Próxima &gt;</a>";
      $content .= "&nbsp;<a href='busca.php?q=$buscaEncoded&amp;pg=$totalPages' data-ajax='false'>Fim</a>";
    } else {
      $content .= ""; // &nbsp;Próxima &gt; Fim";
    }

    $content .= "</div>"; 

  }
} else {  // no query given
  $content = "<h3>Digite o código ou descrição acima, no campo de busca.</h3>";
}

$content .= "<script>const cvs = {\n";
$content .= $cvs;
$content .= "};</script>";

require_once("template.php");

?>

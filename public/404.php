<?php

$page_title = "Erro 404";

$content = '
<script>
function openMenu() {
  $(window).scrollTop(0);
  $(window).scrollLeft(0);
  $("#menu").panel("open");
}
</script>

<button class="index_menu" onclick="openMenu();" data-inline="true">Nossos Produtos</button>

<div class="not_found">
Erro 404<br> 
    Página não encontrada<br>
As páginas antigas foram removidas. <br>Por favor clique no botão acima ou no Menu, no canto superior à esquerda.<br><br> 
    <a href="index.php" data-ajax="false">Voltar ao Homepage</a>

</div>';

require_once("template.php");

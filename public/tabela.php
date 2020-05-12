<?php

$page_title = "Tabela de Estoque";

$content = '
<h3>Tabela de Estoque</h3>
<div class="ui-grid-b">

  <div class="ui-block-a"></div>
  <div class="ui-block-b">
<form action="tabela_baixar.php" method="post" class="ui-grid-b" data-ajax="false">
Digite a senha de cliente: <input type="password" name="senha" size="10" autofocus>
<b>Aviso:</b> Os dados são apenas de caráter informativo. Confirme com sua vendedora antes de fazer pedidos.<br>
<input type="submit" value="Continuar">
</form>
  </div>
  <div class="ui-block-c"></div>
</div>

';

require_once("template_tabela.php");

?>

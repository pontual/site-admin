<?php
$page_title = "Homepage";

$content = '
<script>
function openMenu() {
  $(window).scrollTop(0);
  $(window).scrollLeft(0);
  $("#menu").panel("open");
}
</script>

<button class="index_menu" onclick="openMenu();" data-inline="true">Nossos Produtos</button>

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

  <div data-role="popup" id="senhaCorreta">
  <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
  <p>
  <br><br>
Bem-vindo(a), cliente!
  <br><br><br>
  </p>
  </div>

  </div>
</div>
<div class="ui-block-b">
<form>
<input type="button" value="Fazer Logoff" data-theme="b" onclick="logoff();">
</div>
</div>

<script>
let cvs = "";

document.getElementById("senhaForm").addEventListener("submit",
function(event) { event.preventDefault(); confirmarSenha(); });
</script>

<br>

<!--
<a href="lista.php?id=80" data-ajax="false">
<h1>Liquidação de Chaveiros</h1>
<h1>Nossa Senhora Aparecida</h1>
<img src="img/chaveiros_aparecida_amostras.png" alt="chaveiros"><br>
</a>
-->

<!--
<a href="http://pontualimportbrindes.com.br/lista.php?id=83" data-ajax="false">
    <img src="novidades20170906/novidades.jpg" alt="novidades">
</a>
<br><br>

<a href="http://pontualimportbrindes.com.br/lista.php?id=86" data-ajax="false">
    <img src="novidades20170906/pwr.jpg" alt="power banks">
</a>
<br><br>

<a href="http://pontualimportbrindes.com.br/lista.php?id=23" data-ajax="false">
    <img src="novidades20170906/kitsman.jpg" alt="kits manicure">
</a>
<br><br>
-->

<!--
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
-->
';


require_once("templateIndex.php");

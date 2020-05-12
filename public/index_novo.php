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
<br><br>
';

require_once("template.php");

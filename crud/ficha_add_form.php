<?php

$pageTitle = "Criar campo para Ficha";

require_once("common.php");

print(generateForm("ficha_add_exec.php", [
  "Campo (ex. telefone)" => "campo",
  "Valor (ex. 3312-8845)" => "valor" ]));

require_once("footer.php");

?>

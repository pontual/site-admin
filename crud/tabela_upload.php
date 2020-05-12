<?php

$pageTitle = "Fazer upload de Tabela";

require_once("common.php");

?>
<br>
<form action="tabela_upload_exec.php" method="POST" enctype="multipart/form-data">
    Arquivo HTM: <input type="file" name="arquivo_htm">
    <br><br>
    Arquivo PDF: <input type="file" name="arquivo_pdf">
    <br><br>
    Arquivo XLS: <input type="file" name="arquivo_xls">
    <br><br>
    <input type="submit">
</form>


<?php

require_once("footer.php");

?>

<?php

require_once("common.php");

?>

<form action="categoria_add_exec.php" method="POST">
    <table>
        <tr><td>Nome</td><td><input name="nome" size="60" autofocus></td></tr>
        <tr><td>&nbsp;</td><td><input type="submit"></td></tr>
    </table>
</form>

<?php

require_once("footer.php");

?>

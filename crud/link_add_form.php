<?php

require_once("common.php");

?>

<form action="link_add_exec.php" method="POST">
    <table>
        <tr><td>Nome</td><td><input name="nome" size="60" autofocus></td></tr>
        <tr><td>Pasta</td>
            <td>
                <select name="pasta">
                    <option>123</option>
                </select>
            </td>
        </tr>

        <tr><td>Categoria</td>
            <td>
                <select name="categoria">
                    <option>333</option>
                </select>
            </td>
        </tr>
        
        <tr><td>&nbsp;</td><td><input type="submit"></td></tr>
    </table>
</form>

<?php

require_once("footer.php");

?>

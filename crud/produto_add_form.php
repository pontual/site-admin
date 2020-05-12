<?php

$pageTitle = "Criar novo produto";

require_once("common.php");

?>

<form action="produto_add_exec.php" method="POST" enctype="multipart/form-data">
    <table>
        <?php
        
        print(generateRows([
          "Código" => "codigo",
          "Descrição" => "descricao",
          "Peso (gramas)" => "peso",
          "Medidas (L x C x A, cm)" => "medidas",
          "Código de preço" => "preco",
        ]));

        ?>
        <tr>
            <td>Arquivo de foto<br>grande sem código</td>
            <td><input type="file" name="arquivo_foto"></td>
        </tr>
        <tr><td>&nbsp;</td><td><input type='submit'></td></tr>
    </table>
</form>


<?php

require_once("footer.php");

?>

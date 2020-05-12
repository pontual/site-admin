<?php
include("header.php");
?>

<h3 class="title is-3">Fazer Upload de Tabelas CV</h3>
<script src="js/jquery.js"></script>
<script src="js/xlsx.js"></script>

<p>
    Grave a tabela do Sistema da Pontual e da União:
</p>

<p>
    Na tela principal, clique em <b>Movimento</b> na barra superior. Em seguida, clique em <b>Lista de Preços</b> e <b>Lista disponível</b>.
</p>

<p>
    Na janela que aparecer, clique na flecha verde para prosseguir.
</p>

<p>
    No topo, clique no ícone verde com um X (Excel). Grave com o nome "PTL" para o sistema da Pontual, e "UNI" para União.
</p>

<p>
    Faça upload das duas planilhas nesta página.
</p>
    

<br><br>
<form>
    <input type="hidden" id="phpTarget" value="exec_cv_db.php">
    <fieldset>
        <div class="field">
            <label class="label">Arquivo Excel da Pontual</label>
            <div class="control">
                <input class="input" type="file" id="fileInput1">
            </div>
        </div>

        <br><br>
        <div class="field">
            <label class="label">Arquivo Excel da União</label>
            <div class="control">
                <input class="input" type="file" id="fileInput2">
            </div>
        </div>

        <input type="button" class="button is-primary" id="continue" value="Continuar">
    </fieldset>
</form>

<br>

<pre id="errors" style="color: red;"></pre><br>
<pre id="out"></pre>

<script src="js/xlsx-to-array-dispresv.js"></script>

<?php
require("footer.php");

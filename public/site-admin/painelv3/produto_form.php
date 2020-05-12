<?php
include("header.php");

$produto_id = (int) ($_GET['produto_id'] ?? '0');
$dbh = getdbh();

if ($produto_id != 0) {
    $crud_action = 'update';
    $submit_label = "Atualizar Produto";
    $sql = "select codigo, descricao, medidas, atualizado, inativo from v2_produto where id = :id";
    $sth = $dbh->prepare($sql);
    $sth->execute([":id" => $produto_id]);

    $row = $sth->fetch();
} else {
    $crud_action = 'create';
    $submit_label = "Criar Produto";
    $row = null;
}

$codigo = $row['codigo'] ?? "";
$descricao = $row['descricao'] ?? "";
$medidas = $row['medidas'] ?? "";
$atualizado = $row['atualizado'] ?? "";

// existing categorias
$categorias = [];

?>
<div class="columns">
    <div class="column is-three-quarters">
        <h3 class="title is-3"><?= $submit_label ?></h3>
        <form method="post" action="produto_exec.php" enctype="multipart/form-data" class="pure-form pure-form-aligned">
	    <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
	    <input type="hidden" name="produto_id" value="<?= $produto_id ?>">

            <fieldset>
                <h5 class="title is-5">Informações do produto</h5>

                <div class="field">
                    <label class="label">Código</label>
                    <div class="control">
                        <input class="input" name="codigo" value="<?= $codigo ?>" autofocus>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" name="descricao" value="<?= $descricao ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Medidas</label>
                    <div class="control">
                        <input class="input" name="medidas" value="<?= $medidas ?>">
                    </div>
                </div>

                <div class="field">
	            <label class="checkbox">
	                <input type="checkbox"
                               name="inativo"
                               value="1"
                               <?= $row['inativo'] == 1 ? "checked" : "" ?>
                        >
	                Inativo no site
	            </label>
	        </div>

                <div class="field">
                    <label class="label">Foto</label>
                    <div class="control">
                        <?php
                        if ($atualizado) {
                        ?>
                            <img src="/fotos/<?= $codigo ?>_<?= $atualizado ?>_thumb.jpg" alt="foto">
                        <?php
                        }
                        ?>
                        <input class="input" type="file" name="arquivo_foto">
                    </div>
                </div>

                <h5 class="title is-5">Categorias do produto</h5>
                <h6 class="title is-6">Importante: se for necessário criar uma categoria nova, esta página precisa ser recarregada</h6>
                <div style="height: 12em; overflow-y: scroll; border: 1px solid #CCC; padding: 5px;">
                    <?php
                    // check for existing categorias
                    if ($crud_action == "update") {
                        $sql = "select id_categoria from v2_produtos_de_categoria where id_produto = :produto_id";
                        $sth = $dbh->prepare($sql);
                        $sth->execute([":produto_id" => $produto_id]);
                        foreach ($sth->fetchAll() as $row) {
                            $categorias[] = (int) $row['id_categoria'];
                        }
                    }
                    
                    foreach ($dbh->query("select id, nome, inativo from v2_categoria order by nome") as $row) {
                    ?>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox"
                                       name="produto_cat[]"
                                       value="<?= $row['id'] ?>"
                                       <?= in_array($row['id'], $categorias) ? "checked" : "" ?>
                                >
                                <?= $row['nome'] ?> <?= $row['inativo'] == 1 ? "(inativo)" : "" ?>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                
                <br>
                
	        <input type="submit" class="button is-primary" value="<?= $submit_label ?>">
                
                <?php
                if ($crud_action == "update") {
                ?>
                    
                    <br><br>
                    <hr>
                    <div class="container">
                        <a class="button is-danger is-pulled-right" href="produto_confirm_delete.php?produto_id=<?= $produto_id ?>">Excluir produto</a>
                    </div>

                <?php
                }
                ?>
            </fieldset>
        </form>
    </div>
</div>

<?php
include("footer.php");

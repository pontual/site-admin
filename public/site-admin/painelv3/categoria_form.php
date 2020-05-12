<?php
include("header.php");

$categoria_id = (int) ($_GET['categoria_id'] ?? '0');

if ($categoria_id != 0) {
    $crud_action = 'update';
    $submit_label = "Atualizar categoria";
    $dbh = getdbh();
    $sql = "select nome, inativo from v2_categoria where id = :id";
    $sth = $dbh->prepare($sql);
    $sth->execute([":id" => $categoria_id]);

    $row = $sth->fetch();
} else {
    $crud_action = 'create';
    $submit_label = "Criar categoria";
    $row = null;
}

$nome = $row['nome'] ?? "";
?>
<div class="columns">
    <div class="column is-three-quarters">

        <h3 class="title is-3"><?= $submit_label ?></h3>
        <form method="post" action="categoria_exec.php" class="pure-form pure-form-aligned">
            <input type="hidden" name="crud_action" value="<?= $crud_action ?>">
            <input type="hidden" name="categoria_id" value="<?= $categoria_id ?>">
            <fieldset>
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" name="nome" value="<?= $nome ?>" autofocus>
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

	        <br>
	        <input type="submit" class="button is-primary" value="<?= $submit_label ?>">
            </fieldset>
        </form>

        <?php
        if ($crud_action == "update") {
        ?>
            
            <br>
            <hr>
            <div class="container">
                <a class="button is-danger is-pulled-right" href="categoria_confirm_delete.php?categoria_id=<?= $categoria_id ?>">Excluir categoria</a>
            </div>
            <br><br><br>
            <h5 class="title is-5">Produtos nesta categoria</h5>
            <table class="table is-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Categorias</th>
                    </tr>
                </thead>
                
                <tbody>

                    <?php
                    // get produtos that belong in this categoria

                    $sql = "select p.id, p.codigo, p.descricao, p.inativo, GROUP_CONCAT(c.nome order by c.nome separator ' / ') as cats
from v2_categoria as c
inner join v2_produtos_de_categoria as pc on c.id = pc.id_categoria
inner join v2_produto as p on p.id = pc.id_produto
where p.id in (select id_produto from v2_produtos_de_categoria where id_categoria = :id_categoria)
group by p.id
order by p.inativo, p.codigo";

                    $sql_plain = "select p.id, p.codigo, p.descricao from v2_produto as p
        inner join v2_produtos_de_categoria as pc on pc.id_produto = p.id
        inner join v2_categoria as c on pc.id_categoria = c.id
        where c.id = :id_categoria order by p.codigo";

                    $sth = $dbh->prepare($sql);
                    $sth->execute([":id_categoria" => $categoria_id]);

                    foreach ($sth->fetchAll() as $row) {
                    ?>
                        <tr>
                            <td><a href="produto_form.php?produto_id=<?= $row['id'] ?>"><?= $row['codigo'] ?></a></td>
                            <td><?= $row['descricao'] ?></td>
                            <td><?= $row['cats'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    
                </tbody>
            </table>
    </div>
</div>

        <?php
        }

        include("footer.php");

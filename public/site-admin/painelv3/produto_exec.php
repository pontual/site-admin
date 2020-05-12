<?php
include("header.php");
include("smart_resize_image.php");
include("normalize_chars.php");
?>

<h3 class="title is-3">Processamento de Produto</h3>
<pre>

<?php
$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$atualizado = gmdate("YmdHis", time());

$produto_id = (int) ($_POST['produto_id'] ?? "0");
$produto_cat = $_POST['produto_cat'] ?? null;

$sql_arguments = [':codigo' => $_POST['codigo'],
                  ':descricao' => $_POST['descricao'], 
                  ':medidas' => $_POST['medidas'],
                  ':normalizado' => normalizeChars($_POST['codigo'] . " " . $_POST['descricao']),
                  ':inativo' => (int) ($_POST['inativo'] ?? "0")];

if ($crud_action == "create") {
    echo "Criando {$_POST['codigo']}\n\n";

    $sql = "insert into v2_produto (codigo, descricao, medidas, atualizado, normalizado, inativo) values (:codigo, :descricao, :medidas, :atualizado, :normalizado, :inativo)";

    $sql_arguments = array_merge($sql_arguments, [':atualizado' => $atualizado]);
    
} elseif ($crud_action == "update") {
    echo "Atualizando {$_POST['codigo']}\n\n";

    $sql = "update v2_produto set codigo = :codigo, descricao = :descricao, medidas = :medidas, normalizado = :normalizado, inativo = :inativo where id = :id";
    $sql_arguments = array_merge($sql_arguments, [':id' => $produto_id]);
    
    // delete from v2_produtos_de_categoria
    try {
        $sth = $dbh->prepare("delete from v2_produtos_de_categoria where id_produto = :id_produto");
        $sth->execute([":id_produto" => $produto_id]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// run action on produto
$sth = $dbh->prepare($sql);

try {
    $sth->execute($sql_arguments);

    // get id of altered produto
    if ($crud_action == 'create') {
        $altered_id = $dbh->lastInsertId();
    } elseif ($crud_action == 'update') {
        $altered_id = $produto_id;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

// add to v2_produtos_de_categoria
if ($produto_cat) {
    $dbh->beginTransaction();

    $sql = "insert into v2_produtos_de_categoria (id_produto, id_categoria) values (:id_produto, :id_categoria)";
    $sth = $dbh->prepare($sql);
    
    foreach ($produto_cat as $cat_id_str) {
        $cat_id = (int) $cat_id_str;
        $sth->execute([":id_produto" => $altered_id,
                       ":id_categoria" => $cat_id]);
    }
    $dbh->commit();
}


// handle foto
$fotos_folder = "../../fotos/";

if (isset($_FILES['arquivo_foto']) && $_FILES['arquivo_foto']['size'] !== 0 && $_FILES['arquivo_foto']['error'] === UPLOAD_ERR_OK) {
    echo "Fazendo upload de foto.\n";

    if ($crud_action == "update") {
        $sth = $dbh->prepare("update v2_produto set atualizado = :atualizado where id = :id");
        $sth->execute([ ":atualizado" => $atualizado,
                        ":id" => $produto_id ]);
    }

    $codigoNovo = strtoupper($_POST['codigo']);
    $uploadfile = $fotos_folder . $codigoNovo . "_$atualizado" . ".jpg";
    $thumbfile = $fotos_folder . $codigoNovo . "_$atualizado" . "_thumb.jpg";

    $check = getimagesize($_FILES["arquivo_foto"]["tmp_name"]);
    if ($check !== false) {
        move_uploaded_file($_FILES["arquivo_foto"]["tmp_name"], $uploadfile);
        smart_resize_image($uploadfile, null, $thumbWidth, $thumbHeight, true, $thumbfile, false, false, 100);
    }

}

echo "Operação concluída.\n";
echo "</pre>";
    ?>
<br>
    <a class="button is-primary" href="produto_form.php?produto_id=<?= $altered_id ?>">Visualizar produto</a>

<?php

include("footer.php");

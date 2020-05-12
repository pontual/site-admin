<?php
include("header.php");
?>

<h3 class="title is-3">Processamento de Categoria</h3>
<pre>

<?php
$dbh = getdbh();

$crud_action = $_POST['crud_action'];
$categoria_id = (int) ($_POST['categoria_id'] ?? "0");

$sql_arguments = [':nome' => $_POST['nome'],
                  ':inativo' => (int) ($_POST['inativo'] ?? "0")];

if ($crud_action == "create") {    
    echo "Criando {$_POST['nome']}\n";

    $sql = "insert into v2_categoria (nome, inativo) values (:nome, :inativo)";
    
} elseif ($crud_action == "update") {
    echo "Atualizando {$_POST['nome']}\n\n";

    $sql = "update v2_categoria set nome = :nome, inativo = :inativo where id = :id";
    $sql_arguments = array_merge($sql_arguments, [':id' => $categoria_id]);
}

$sth = $dbh->prepare($sql);

try {
    $sth->execute($sql_arguments);
    echo "\nOperação concluída.\n";
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "</pre>";

include("footer.php");

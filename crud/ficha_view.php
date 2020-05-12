<?php

require_once("common.php");

?>

<table>
    
    <?php

    if (isset($_GET['id'])) {
      $sql = 'select campo, valor from v2_ficha where id = :id';
      $sth = $dbh->prepare($sql); 
      $sth->execute([ ":id" => $_GET['id']]);
      $result = $sth->fetch();

      print("{$result['campo']}: {$result['valor']}"); 
    } else {
      print("Nenhum id solicitado.");
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

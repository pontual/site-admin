<?php

require_once("common.php");

?>

<table>
    
    <?php

    if (isset($_GET['id'])) {
      $sql = 'select nome from v2_categoria where id = :id';
      $sth = $dbh->prepare($sql); 
      $sth->execute([ ":id" => $_GET['id']]);
      $result = $sth->fetch();

      print("{$result['nome']}"); 
    } else {
      print("Nenhum id solicitado.");
    }
    
    ?>
</table>

<?php require_once("footer.php"); ?>

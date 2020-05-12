<p>
    <?php

    // in addition to $DEBUG being true, $ENABLE_DROP_ALL must also be
    // true
    
    $ENABLE_DROP_ALL = false;
    // $ENABLE_DROP_ALL = true;
    
    require_once("https_redirect.php");
    require_once("html_head.php");
    require_once("settings.php");
    require_once("db_conn.php");
    require_once("tables.php");

    function tableExistsP($dbh, $tableName) {
      $stmt = $dbh->prepare("show tables like '$tableName'");
      $stmt->execute();
      return $stmt->rowCount() !== 0;
    }

    function dropTable($dbh, $tableName, $columns) {
      if (tableExistsP($dbh, $tableName)) {
        try {
          $dbh->exec("drop table $tableName");
          print("DROPPED table $tableName");
        } catch (PDOException $e) {
          print("Error " . $e->getMessage() . "<br>");
        }
      } else {
        print("DOES NOT EXIST: Table $tableName");
      }
      print("<br>");
    }

    if ($DEBUG && $ENABLE_DROP_ALL) {
      foreach (array_reverse($TABLES) as $tableName => $columns) {
        dropTable($dbh, $tableName, $columns);
      }
      print("Completed dropping tables");
    } else {
      print("Switch to debug mode and enable drop to drop all tables.");
      
    }

    ?>

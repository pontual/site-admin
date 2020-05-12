<p>
    <?php

    // require_once("https_redirect.php");
    require_once("settings.php");
    require_once("db_conn.php");
    require_once("tables.php");

    function tableExistsP($dbh, $tableName) {
      $stmt = $dbh->prepare("show tables like '$tableName'");
      $stmt->execute();
      return $stmt->rowCount() !== 0;
    }

    function createTable($dbh, $tableName, $columns) {
      if (!tableExistsP($dbh, $tableName)) {
        try {
          $dbh->exec("create table if not exists $tableName
        ($columns) engine=InnoDB");
          print("CREATED table $tableName");
        } catch (PDOException $e) {
          print("Error " . $e->getMessage() . "<br>");
        }
      } else {
        print("ALREADY EXISTS: table $tableName");
      }
      print("<br>");
    }

    foreach ($TABLES as $tableName => $columns) {
      createTable($dbh, $tableName, $columns);
    }

    print("Completed installation");
    ?>

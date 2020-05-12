<?php

function getConnection($dbHost, $dbUser, $dbPassword) {
  try {
    // TODO FETCH MODE
    $dbh = new PDO($dbHost, $dbUser, $dbPassword,
                   [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_EMULATE_PREPARES, false,
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]);
    return $dbh;
  } catch (PDOException $e) {
    print("Error " . $e->getMessage() . "<br>");
    die();
  }
}

$dbh = getConnection($dbHost, $dbUser, $dbPassword);

?>

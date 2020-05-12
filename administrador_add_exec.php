<?php

require_once("https_redirect.php");
require_once("settings.php");
require_once("db_conn.php");
require_once("html_head.php");

// check if username already exists
$sthCheckUsername = $dbh->prepare("select count(*) from v2_administrador where username = :username");
$sthCheckUsername->execute([':username' => $_POST['username']]);
$checkUsernameResult = $sthCheckUsername->fetchColumn();

if ($checkUsernameResult === "0") {  // username not found
  
  // check again if password and passwordRepeated are the same
  if ($_POST['password'] !== $_POST['passwordRepeated']) {
    
    print('Senhas devem ser idênticas. <a href="javascript:history.back()">Tente novamente.</a>');
  } else {

    // check codigoDeAutorizacao
    if ($_POST['codigoDeAutorizacao'] === $codigoDeAutorizacao) {
      // proceed with account creation
      $sqlCreateUser = "insert into v2_administrador (email, username, password_hash)
values (:email, :username, :password_hash)";
      $sth = $dbh->prepare($sqlCreateUser);
      $sth->execute([":email" => $_POST['email'],
                     ":username" => $_POST['username'],
                     ":password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT)]);
      print('Conta criada com sucesso.');
    } else {
      print('Código de autorização incorreta. <a href="javascript:history.back()">Tente novamente.</a>');
    }
  }
} else {
  print('Nome de usuário indisponível. <a href="javascript:history.back()">Tente novamente.</a>');
}

?>

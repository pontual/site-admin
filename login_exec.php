<?php

session_start();

function auth($username, $password) {
  return false;
}

if(isset($_POST['username']) && isset($_POST['password'])) {
  if(auth($_POST['username'], $_POST['password'])) {
    // auth okay, setup session
    $_SESSION['user'] = $_POST['username'];

    // redirect to required page
    header("Location: index.php");
  } else {
    // didn't auth go back to login
    header("Location: login_form.php?message=unauthorized");
  }
} else {
  // username and password not given so go back to login
  header("Location: login_form.php");
}

?>

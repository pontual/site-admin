<?php

require_once("settings.php");

if ($DEBUG) {
  $redirect_url = "https://127.0.0.1/kitwebv2/index.php";
} else {
  $redirect_url = "https://pontualimportbrinde1.websiteseguro.com/kitwebv2/";
}

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    header("Location: $redirect_url");
    exit;
}

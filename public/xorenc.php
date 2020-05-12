<?php

require("xorenc_secrets.php");


function xorenc($i, $k) {
  if (strlen($i) < 1 || strlen($k) < 1) {
    return "";
  }
  
  $c = "";
  while(strlen($k) < strlen($i)) {
    $k .= $k;
  }
  for ($j = 0; $j < strlen($i); $j++) {
    $v1 = ord($i[$j]);
    $v2 = ord($k[$j]);
    $x = $v1 ^ $v2;
    $h = str_pad(dechex($x), 2, "0", STR_PAD_LEFT);
    $c .= $h;
  }
  return $c;
}

<?php

require_once("smart_resize_image.php");
require_once("normalize_chars.php");

function generateRows($labelNamesArray) {
  $out = "";
  $autofocus = " autofocus";
  foreach ($labelNamesArray as $label => $name) {
    $out .= "<tr><td>$label</td><td><input name='$name' size='60'{$autofocus}></td></tr>\n";
    $autofocus = "";
  }
  return $out;  
}

function generateForm($target, $labelNamesArray) {
  $autofocus = " autofocus";
  $out = "<form action='$target' method='POST'>";
  $out .= "<table>\n";
  foreach ($labelNamesArray as $label => $name) {
    $out .= "<tr><td>$label</td><td><input name='$name' size='60'{$autofocus}></td></tr>\n";
    $autofocus = "";
  }

  $out .= "<tr><td>&nbsp;</td><td><input type='submit'></td></tr>\n";
  $out .= "</table>";
  $out .= "</form>";
  return $out;  
}

function generateEditForm($target, $multipart, $labelValuesArray, $hiddenValues) {
  if ($multipart) {
    $out = "<form action='$target' method='POST' enctype='multipart/form-data'>";
  } else {
    $out = "<form action='$target' method='POST'>";
  }

  // output hidden values
  foreach ($hiddenValues as $name => $value) {
    $out .= "<input type='hidden' name='$name' value='$value'>";
  }
  
  $out .= "<table>\n";
  $autofocus = " autofocus";
  foreach ($labelValuesArray as $label => $values) {
    if ($label === "fileLink") {
      $out .= "<tr><td>{$values['name']}</td><td><input type='file' name='{$values['value']}'></td></tr>";
    } else {
      $out .= "<tr><td>$label</td><td><input name='{$values['name']}' value='{$values['value']}' size='60'{$autofocus}></td></tr>\n";
      $autofocus = "";
    }
  }

  $out .= "<tr><td>&nbsp;</td><td><input type='submit'></td></tr>\n";
  $out .= "</table>";
  $out .= "</form>";
  return $out;
}

function printPairRow($label, $value) {
  print("
<tr>
  <td>$label</td>
  <td>$value</td>
</tr>");
}

function printFichaListItem($tableName, $id, $label, $value) {
  print("
<tr>
  <td><a href='{$tableName}_edit_form.php?id=$id'>Editar</a></td>
  <td>$label</td>
  <td>$value</td>
  <td><a href='{$tableName}_delete_confirm.php?id=$id'>Excluir</a></td>
</tr>");
}

function printListRow($tableName, $id, $valuesArray) {
  $out = "<tr>";
  $out .= "<td><a href='{$tableName}_edit_form.php?id=$id'>Editar</a></td>";
  foreach ($valuesArray as $value) {
    $out .= "<td>$value</td>";
  }
  $out .= "<td><a href='{$tableName}_delete_confirm.php?id=$id'>Excluir</a></td>";
  $out .= "</tr>";
  print($out);
}

function printListRowCategoria($tableName, $customLeft, $id, $valuesArray) {
  $out = "<tr>";
  $out .= "<td><a href='{$tableName}_edit_form.php?id=$id'>$customLeft</a></td>";
  $out .= "<td><a href='/lista.php?id=$id' target='_blank'>Ver no site</a></td>";
  foreach ($valuesArray as $value) {
    $out .= "<td>$value</td>";
  }
  $out .= "<td><a href='{$tableName}_delete_confirm.php?id=$id'>Excluir</a></td>";
  $out .= "</tr>";
  print($out);
}

function removeSymbols($s) {
  return preg_replace('/[$#~]/u', '', $s);
}

function sanitizedMenu($s) {
  return htmlspecialchars(removeSymbols($s));
}


?>

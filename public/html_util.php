<?php

function formatPeso($s) {
    if (trim($s) !== "") {
        return "$s g";
    }
}

function formatMedidas($s) {
    $parts = explode('x', $s);
    $out = $parts[0];
    for ($i = 1; $i < count($parts); $i++) {
        $out .= " x {$parts[$i]}";
    }
    return $out . " cm";
}

function hsc($s) {
    htmlspecialchars($s);
}

function img_foto($codigo, $atualizado, $isThumb) {
    if ($isThumb) {
        $thumb = "_thumb";
    } else {
        $thumb = "";
    }
    
    return "<img src='" .
           htmlspecialchars("/fotos/{$codigo}_{$atualizado}{$thumb}.jpg") .
           "' alt='" . htmlspecialchars($codigo) . "'>";           
}

function line_if_nonempty($s) {
    $t = trim($s);
    if ($t !== "") {
        return "<br>" . htmlspecialchars($t);
    }
}

function display_if_nonempty($s) {
    $t = trim($s);
    if ($t !== "") {
        return htmlspecialchars($t);
    }
}

function getCard($produto) {
    $content = "";
    
    $content .= "<!-- CARD -->\n";
    $content .= "  <div class='card card-3'>\n";
    $content .= "    <a href='#' class='produtos' id='" . htmlspecialchars($produto['codigo']) . "_" . htmlspecialchars($produto['atualizado']) . "'>";

    $content .= img_foto($produto['codigo'], $produto['atualizado'], true);
    $content .= "</a>\n";
    $content .= line_if_nonempty($produto['codigo']);
    // $content .= display_if_nonempty($produto['codigo']) . " &nbsp; " . display_if_nonempty($produto['preco']);
    $content .= line_if_nonempty($produto['descricao']);
    $content .= line_if_nonempty(formatPeso($produto['peso']));
    $content .= line_if_nonempty(formatMedidas($produto['medidas']));
    // $content .= line_if_nonempty($produto['preco']);
    
    $content .= "</div>\n";
    return $content;
}


?>

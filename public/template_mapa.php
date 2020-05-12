<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Pontual Import Brindes - Pontual Exportação e Importação Ltda. - <?php echo $page_title; ?></title>
        <?php require_once("stylesheets.html"); ?>
    </head>
    <body>
        <?php require_once("html_util.php"); ?>
        
        <?php require_once("js_scripts.html"); ?>

        <?php // require_once("static_menu.html");
        require_once("menu.php");
        ?>
        
        <!-- Dynamic page title in data-title -->
        <div data-role="page" data-theme="a" data-title="Pontual Import Brindes - Pontual Exportação e Importação Ltda. - <?php echo $page_title ?>" data-ajax="false" id="mapa-page">

            <?php require_once("header.php"); ?>

            <div class="center-div" data-role="content">

                <!-- Endereço, Telefones -->
                <?php require_once("contact.php"); ?>

                <?php if (isset($content)) { echo $content; } ?>

                <?php
                // DEBUG HERE

                ?>
            </div>
            
            <!-- Footer -->
            <?php require_once("footer.php"); ?>
            <!-- END Footer -->

        </div>

        <?php require_once("last_js_scripts.html"); ?>

    </body>
</html>

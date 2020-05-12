<?php

$pageTitle = "Login";

require_once("https_redirect.php");
require_once("html_head.php");

?>
<body>
    <?php
    
    include("navbar.php");

    if (isset($_GET['message'])) {
      if ($_GET['message'] === 'unauthorized') {
        print("<p>Usuário e senha incorreta. Tente novamente.</p>");
      }
    }
    
    ?>
    
    <form action="login_exec.php" method="POST">
        <table>
            <tr>
                <td>Nome de usuário</td>
                <td><input name="username"></td>
            </tr>
            <tr>
                <td>Senha</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </form>
</body>

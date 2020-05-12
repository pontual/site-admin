<?php

$pageTitle = "Criar usuário";

require_once("https_redirect.php");
require_once("html_head.php");

?>
<body>
    
    <form action="administrador_add_exec.php" method="POST">
        <table>
            <tr>
                <td>Email</td>
                <td><input name="email"></td>
            </tr>
            <tr>
                <td>Nome de usuário</td>
                <td><input name="username"></td>
            </tr>
            <tr>
                <td>Senha</td>
                <td><input type="password" name="password" id="pw1"></td>
            </tr>
            <tr>
                <td>Repetir senha</td>
                <td><input type="password" name="passwordRepeated" id="pw2"> <span id="passwordsMatch"></span></td>
            </tr>
            <tr>
                <td>Código de autorização</td>
                <td><input type="password" name="codigoDeAutorizacao"></td>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" id="submitInput" disabled></td>
            </tr>
        </table>
        
    </form>

    <script>
     var passwordInput = document.getElementById("pw1");
     var passwordRepeatedInput = document.getElementById("pw2");
     var passwordsMatchSpan = document.getElementById("passwordsMatch");
     var submitInput = document.getElementById("submitInput");
     
     function checkPassword() {
       var passwordValue= passwordInput.value;
       var passwordRepeatedValue = passwordRepeatedInput.value;

       if (passwordValue.length > 0 && passwordValue === passwordRepeatedValue) {
         passwordsMatchSpan.innerHTML = "OK";
         submitInput.disabled = false;
       } else {
         passwordsMatchSpan.innerHTML = "";
         submitInput.disabled = true;
       }
     }

     passwordInput.onkeyup = checkPassword;
     passwordRepeatedInput.onkeyup = checkPassword;
    </script>
</body>

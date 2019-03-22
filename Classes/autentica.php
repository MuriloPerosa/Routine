<?php

session_start();
//VERIFICA SE O USUÁRIO ESTÁ LOGADO.
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

?>

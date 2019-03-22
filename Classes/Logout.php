<?php
//FINALIZA A SESSÃO - LOGOUT.
  session_start();
  unset($_SESSION["user"]);
  header("Location: index.php");
  exit();
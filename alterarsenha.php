<?php
//REQUIRE(S):
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';

$usr = new DAOusuarios();
$usuario = $usr->listByCod($_SESSION["user"]);
$erro = 0; //NENHUM ERRO;

if (isset($_POST["save"])) { // ALTERAR SENHA;
    If ($_POST["novasenha"] == $_POST["confsenha"]) { //VERIFICA SE A SENHA NOVA E A CONFIRMAÇÃO SÃO IGUAIS.
        if (password_verify($_POST["antigasenha"], $usuario["senha"])) { //VERIFICA A SENHA DE USUÁRIO ATUAL.
            $usr->updateSenha($_POST["novasenha"], $_SESSION["user"]); // ALTERA A SENHA.
            header('Location: agenda.php');
            exit();
        } else {
            $erro = 1; //SENHA INCORRETA;
            $msg = "SENHA INCORRETA!";
        }
    } else {
        $erro = 2; //SENHAS DIFERENTES;
        $msg = "AS SENHAS INFORMADAS NÃO SÃO IGUAIS!";
    }
}

//VERIFICA POST DE "logout" - REALIZAR LOGOUT;
if (isset($_POST["logout"])) {
    require_once './Classes/Logout.php';
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alterar Senha</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>

        
        <div class="navbar navbar-default">
            <div class="container">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <form method="post" class="form">
                            <button name="logout" id="logout" class="btn btn-danger">
                                <i class="glyphicon glyphicon-log-out"></i> SAIR </button>
                        </form>
                    </div>
                </div>

                <div>
                    <h1>ALTERAR SENHA</h1>
                </div>
            </div>
        </div>


        <div class="container">
                <form method="post">             
                    <div class="form-group">
                        <label for="novasenha" class="control-label">Nova Senha:</label>
                        <input type="password" name="novasenha" id="novasenha" 
                               class="form-control" placeholder="Nova Senha" required="" minlength="8">
                    </div>

                    <div class="form-group">
                        <label for="confsenha" class="control-label">Confirma Nova Senha:</label>
                        <input type="password" name="confsenha" id="confsenha" 
                               class="form-control" placeholder="Confrima Nova Senha" required="" minlength="8">
                    </div>
                    
                      <?php
                        if ($erro == 2) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                    '</div>';
                        }
                      ?>

                    <div class="form-group">
                        <label for="antigasenha" class="control-label">Senha Atual:</label>
                        <input type="password" name="antigasenha" id="antigasenha" required="" class="form-control"
                               placeholder="Senha Atual" minlength="8">
                    </div>
                    
                      <?php
                        if ($erro == 1 ) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                    '</div>';
                        }
                     ?>
                    
                    <div class="form-group">
                        <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="SALVAR" style="margin-top: 30px;">
                    </div>

                    <div class="form-group">
                        <a href="alterarusuario.php" class="btn btn-block btn-danger">CANCELAR</a>
                    </div>

                </form>
                <hr>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!--Inclui Script para confirmação de Logout (CONFRIMAÇÔES GERAIS)-->
        <script src="js/confirma.js"></script>
    </body>
</html>
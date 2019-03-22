<?php
//REQUIRE(S):
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';


$usr = new DAOusuarios();
$usuario = $usr->listByCod($_SESSION["user"]);
$erro = 0; //NENHUM ERRO;


if (isset($_POST["delete"])) {//DELETE 
    if (password_verify($_POST["senha"], $usuario["senha"])) {//TESTA SE A SENHA INFORMADA É A CORRETA.
        require_once './Classes/DAOtarefas.php';
        require_once './Classes/DAOlocais.php';
        $loc = new DAOlocais();
        $tar = new DAOtarefas();

        $loc->updateByUsuario($usr->listRoutine()['codigoUsuario'], $_SESSION["user"]); //Atualiza todos os locais para o Usuário padrão.
        $tar->deleteAllByUsuario($_SESSION["user"]); //Deleta todas as tarefas deste usuários.
        $usr->delete($_SESSION["user"]); //deleta usuário;
        require_once './Classes/Logout.php';
    } else {
        $erro = 1; //SENHA INCORRETA
        $msg = "SENHA INCORRETA!";
    }
}

//VERIFICA POST DE "logout" - REALIZAR LOGOUT;
if (isset($_POST["logout"])) {
    require_once './Classes/Logout.php';
//SE A SESSÃO É DE ADMINISTRADOR, IMPEDE QUE ACESSE ESTA PÁGINA - PARA NÃO PERMITIR A EXCLUSÃO.
}else if($_SESSION["user"] == $usr->listRoutine()["codigoUsuario"]){
    header("Location: alterarusuario.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Excluir Conta</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
 
        <div class="navbar navbar-default">
            <div class="container">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <form method="post" class="form">
                            <button name="logout" id="logout" class="btn btn-danger"><i class="glyphicon glyphicon-log-out"></i> SAIR </button>
                        </form>
                    </div>
                </div>

                <div>
                    <h1>EXCLUIR CONTA</h1>
                </div>
            </div>
        </div>


        <div class="container">
            
            <div class="alert alert-danger" style="text-align: center">
                ATENÇÃO: EXCLUIR ESTA CONTA É UMA AÇÃO PERMANENTE E EXCLUÍRA TODAS AS TAREFAS RELACIONADAS A ELA!
            </div>
            
                <form role="form" method="post" autocomplete="off">

                    <div class="form-group">
                        <label for="nome" class="control-label">Nome:</label>
                        <input type="text" disabled name="nome" id="nome" class="form-control" 
                               value=" <?php echo $usuario["nome"] ?>"  maxlength="50" autofocus="" required="">
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">E-mail:</label>
                        <input type="email" disabled name="email" id="email" class="form-control" maxlength="50" 
                               value="<?php echo $usuario["email"]; ?>" required="">
                    </div>


           
                    <div class="form-group">
                        <label for="senha" class="control-label">Senha:</label>
                        <input type="password" name="senha" minlength="8"
                               id="senha" class="form-control" placeholder="Senha Atual" required="">
                    </div>
                    
                     <?php
                        if ($erro == 1) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                    '</div>';
                        }
                     ?>


                        <div class="form-group">

                            </button>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="delete" class="btn btn-block btn-warning" value="EXCLUIR CONTA" 
                                   style="margin-top: 30px;">
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
    </body>
</html>


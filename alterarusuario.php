<?php
//REQUIRE(S):
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';


$usr = new DAOusuarios();
$usuario = $usr->listByCod($_SESSION["user"]);
$erro = 0; //NENHUM ERRO;


if (isset($_POST["save"])) {//UPDATE
    if ($usr->listByEmail($_POST["email"]) && $_POST["email"]!= $usuario["email"]) { //VERIFICA SE O EMAIL JÀ FOI CADASTRADO.
        $erro = 3; //Endereço de e-mail já cadastrado.
        $msg = "ENDEREÇO DE E-MAIL INVÁLIDO!";
    }else if (password_verify($_POST["senha"], $usuario["senha"])) {//TESTA SE A SENHA INFORMADA É A CORRETA.
        //REALIZA UPDATE EM TODOS OS CAMPOS DE USUARIOS (EXCETO SENHA).
        $usr->update($_POST["nome"], $_POST["email"], $_POST["data"], $_SESSION["user"]); 
        header('Location: agenda.php');
        exit();
    } else {
        $erro = 1; //SENHA INCORRETA
        $msg = "SENHA INCORRETA!";
    }
}

if($_SESSION["user"] == $usr->listRoutine()["codigoUsuario"]){
    $erro = 2; //NÃO PERMITIDO ALTERAR O ADMINISTRADOR!
    $msg = "NÃO PERMITIDO ALTERAR O ADMINISTRADOR!";
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
        <title>Editar Usuário</title>

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
                    <h1>EDITAR USUÁRIO</h1>
                </div>
            </div>
        </div>

        <div  class="container">
        
                    <?php  
                        if ($erro == 2) {
                            echo '<div class="alert alert-danger" style="text-align: center;">'
                            .$msg.
                                 '</div>';
                        }
                     ?>
            

             <form method="post" autocomplete="off">
                <fieldset <?php if ($erro == 2) { echo 'disabled';} ?>>
                    <div class="form-group">
                        <label for="nome" class="control-label">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" 
                               value="<?php if ($erro == 1 || $erro == 3){ echo $_POST["nome"];}else{echo $usuario["nome"];} ?>"
                               maxlength="50" autofocus="" required="">
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" maxlength="50" 
                               value="<?php if ($erro == 1 || $erro == 3){ echo $_POST["email"];}else {echo $usuario["email"];} ?>" required="">
                    </div>
                    
                    <?php
                        
                        if ($erro == 3) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                 '</div>';
                        }
                    
                    ?>

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

                </fieldset>
                 
                        <div class="form-group">
                            <a href="alterarsenha.php" class="btn bg-info">
                                <i class="glyphicon glyphicon-lock"> ALTERAR SENHA</i>
                            </a>
                        </div>

                      
                 <fieldset <?php if ($erro == 2) { echo 'disabled';} ?>>
                        <div class="form-group">
                            <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="SALVAR">
                        </div>

                        <div class="form-group">
                            <a href="deleteusuario.php" id="delete" class="btn btn-block btn-warning">EXCLUIR CONTA</a>
                        </div>
                      </fieldset>
                 
                        <div class="form-group">
                            <a href="agenda.php" class="btn btn-block btn-danger">CANCELAR</a>
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

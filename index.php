<?php
session_start();//INICIA A SESSÃO;
$erro = 0; //NENHUM ERRO;

if (isset($_POST["login"])) { //LOGIN
    require_once './Classes/DAOusuarios.php'; //REQUIRE DE DAOUSUARIOS;
    $usuario = new DAOusuarios();
    $x = $usuario->listByEmail($_POST["email"]); //VERIFICA USUARIO PELO EMAIL;
    //TESTA A SENHA INFORMADA COM A SENHA DO USUÁRIO
    if ($usuario && password_verify($_POST["senha"], $x["senha"])) {

        $_SESSION["user"] = $x["codigoUsuario"];
        header('Location: agenda.php');
        exit();
    } else {
        $erro = 1; //USUÁRIO OU SENHA INVÁLIDOS;
        $msg = "E-MAIL OU SENHA INVÁLIDOS!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Routine - HOME</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>

    <div class="jumbotron" style="background-color: #5ca56b; color:#ffffff ">
        <div class="container">

            <h1>ROUTINE</h1>
            <h3>AGENDA VIRTUAL - ORGANIZE SUA VIDA: QUANDO QUISER E ONDE ESTIVER</h3>
        </div>
    </div>
    <div class="container">

        <h2>ENTRAR:</h2>
        <br>
        <?php
        if ($erro == 1) {
            echo '<div class="alert alert-danger">'
            . $msg .
            '</div>';
        }
        ?>
        <form method="post" id="login" >
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" 
                       value="<?php if ($erro == 1) {echo $_POST["email"];}; ?>
                       "name="email" placeholder="usuario@email.com" autofocus="" required="">
            </div>
            <div class="form-group">
                <label for="senha">SENHA:</label>
                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required="">
            </div>
            <div class="form-group">
                <input type="submit" id="login" name="login" class="btn btn-block btn-success" value="ENTRAR" style="margin-top: 10px;">
            </div>
            <div class="form-group">
                <a href="registro.php" class="btn btn-block btn-info">REGISTRAR-SE</a>
            </div>

        </form>
        <hr>
    </div>
    
    <div class="navbar navbar-default" style="text-align: center">
        <h5>Universidade de Passo Fundo</h5>
        <h5>Análise e Desenvolvimento de Sistemas</h5>
        <h5>Desenvolvimento para Web</h5>
        <h5>Murilo Perosa - 158117</h5>
    </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
<?php


$erro = 0; // NENHUM ERRO;

if (isset($_POST["save"])) { //TESTA O BOTÃO DE REGISTRAR.
    //REQUIRE(S):
    require_once './Classes/DAOusuarios.php';
    $p = new DAOusuarios();

    if ($p->listByEmail($_POST["rgemail"])) { //VERIFICA SE O EMAIL JÀ FOI CADASTRADO.
        $erro = 1; //Endereço de e-mail já cadastrado.
        $msg = "ENDEREÇO DE E-MAIL INVÁLIDO!";
    } else {

        if ($_POST["rgsenha"] == $_POST["rgconfirmasenha"]) { //TESTA  SE A SENHA DIGITADA E A CONFIRMAÇÃO SÃO IGUAIS.        

                $p->insert($_POST["rguser"], $_POST["rgemail"], $_POST["rgsenha"], $_POST["rgdata"]); // INSERE EM "Usuarios".
                header('Location: index.php');
                exit();
        } else {//SE AS SENHAS NÃO SÃO IGUAIS.
            $erro = 2; //SENHAS NÃO SÃO IGUAIS;
            $msg = "AS SENHAS INFORMADAS NÃO SÃO IGUAIS!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Resgitrar-se</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="navbar navbar-default">
            <div class="container">
                <h1>CRIAR NOVA CONTA</h1>
            </div>
        </div>

        <div id="registro" class="container">

                <form method="post" autocomplete="off">

                    <div class="form-group">
                        <label for="rguser" class="form-horizontal">Nome de Usuário:</label>
                        <input type="text" name="rguser" id="rguser" class="form-control"  placeholder="Nome de Usuário" 
                                autofocus="" required="" value="<?php if ($erro != 0) { echo $_POST["rgemail"];}?>" 
                                maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="rgemail" class="form-horizontal">E-mail:</label>
                        <input type="email" name="rgemail" id="rgemail" 
                               class="form-control" placeholder="usuario@email.com" required="" value=" 
                                   <?php if ($erro != 0) { echo $_POST["rgemail"];}?>"maxlength="50">
                    </div>

                    <?php
                    if ($erro == 1) {
                        echo '<div class="alert alert-danger">'
                        . $msg .
                        '</div>';
                    }
                    ?>

                    <div class="form-group">
                        <label for="rgsenha" class="form-horizontal">Senha:</label>
                        <input type="password" name="rgsenha" id="rgsenha" class="form-control" 
                               placeholder="Senha" minlength="8" required="">
                    </div>

                    <div class="form-group">
                        <label for="rgconfirmasenha" class="form-horizontal">Confirme a Senha:</label>
                        <input type="password" name="rgconfirmasenha" id="rgconfirmasenha" class="form-control" 
                               placeholder="Confirme a Senha" minlength="8" required="" >
                    </div>


                        <?php
                        if ($erro == 2) {
                            echo '<div class="alert alert-danger">'
                            . $msg .
                            '</div>';
                        }
                        ?>


                    <div class="form-group">
                        <input type="submit" id="btn-registrar" name="save" class="btn btn-block btn-success" 
                               value="REGISTAR-SE" style="margin-top: 30px;">
                    </div>
                    
                    <div class="form-group">
                        <a href="index.php" class="btn btn-block btn-danger">CANCELAR</a>
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
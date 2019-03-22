<?php
//REQUIRE(S):
require_once './Classes/DAOlocais.php';
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';
require_once './Classes/DAOtarefas.php';


$p = new DAOlocais();

$local = $p->listByCod($_GET["cod"]);
$usuario = $p->listByCod($_SESSION["user"]);
$verificaExclusão = new DAOtarefas;
$erro = 0; //NENHUM ERRO;
//
//VERIFICA SE O USUÁRIO É O "CIRADOR" DO LOCAL.
if ($local["codigoUsuario"] != $_SESSION["user"]) {
    $erro = 1; //USUÁRIO NÃO TEM PERMISSÃO PARA ALTERAR;
    $msg = 'VOCÊ NÃO TEM PERMISSÃO PARA ALTERAR ESTE LOCAL!';

    //VERIFICA SE O LOCAL PODE SER EXLUÍDO;
} else if ($verificaExclusão->listByLocal($_GET["cod"])) {
    $erro = 3; //NÃO É POSSÍVEL EXCLUUIR LOCAL;
    $msg = "Não é possível excluir este local!";
};

if (isset($_POST['save'])) { // UPDATE LOCAL;
    if ($p->listByDesc($_POST["local"])) { //VERIFICA SE O LOCAL JÁ ESTÁ CADASTRADO
        $erro = 2; //LOCAL JÁ CADASTRADO;
        $msg = "LOCAL JÁ CADASTRADO!";
    } else {
        $p->update($_POST["cod"], $_POST["local"], $_SESSION["user"]);
        header('Location: locais.php');
        exit();
    }

//VERIFICA SE DELETE FOI POSTADO.
} else if (isset($_POST['delete'])) {// DELETE LOCAL;
    if ($verificaExclusão->listByLocal($_GET["cod"])) {
    $erro = 3; //NÃO É POSSÍVEL EXCLUUIR LOCAL;
    $msg = "Não é possível excluir este local!";
}else{ 
    $p->delete($_POST["cod"]);
    header('Location: locais.php');
    exit();
}
    // VERIFICA SE O CÓDIGO DO LOCAL NÃO ESTÁ NA QUERY STRING.
} else if (!isset($_GET["cod"]) || empty($_GET["cod"]) || !$p->listByCod($_GET["cod"])) {
    header('Location: locais.php');
    exit();
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
        <title>Editar Local</title>
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
                    <h1>EDITAR LOCAL</h1>
                </div>
            </div>
        </div>



        <div class="container">    
            <?php
            if ($erro == 1 || $erro == 3) {
                echo '<div class="alert alert-warning" style="text-align: center">'
                . $msg .'</div>';}?>
            
            <form method="post" autocomplete="off">
                <fieldset <?php if ($erro == 1) { echo 'disabled';} ?>>    
                    <div class="form-group">
                        <label for="cod" class="form-horizontal">Código Local:</label>
                        <input type="number" name="cod" required="" id="cod" class="form-control" 
                               value="<?php echo$local['codigoLocal']; ?>" readonly="">
                    </div>
                    <div class="form-group">
                        <label for="local" class="form-horizontal">Local:</label>
                        <input type="text" name="local" required="" maxlength="50" id="local" 
                               class="form-control" autofocus="" value="<?php if ($erro == 2) { echo $_POST["local"];
                                } else {echo $local['descricaoLocal'];}
                                ?>">
                    </div>

                    <?php
                    if ($erro == 2) {
                        echo '<div class="alert alert-danger">'
                        . $msg .
                        '</div>';
                    }
                    ?>



                    <div class="form-group">
                        <label for="criadorlocal" class="form-horizontal">Criador:</label>
                        <input type="text" name="criadorlocal" required="" id="criadorlocal" 
                               class="form-control" value="<?php 
                                $u = new DAOusuarios();
                                //LISTA O LOCAL PELO CÓDIGO.
                                echo $u->listByCod($local['codigoUsuario'])['nome']?>" readonly="">
                    </div>
                
                
                <div class="form-group">
                    <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="SALVAR">
                </div>

                <div class="form-group">
                    <button name="delete" id="delete" class="btn btn-block btn-warning">EXCLUIR</button>
                </div>
                    </fieldset>
                <div class="form-group">
                    <a href="locais.php" class="btn btn-block btn-danger">CANCELAR</a>
                </div>
             </form>
            
            <hr>
        </div>


        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!--Inclui Script para confirmação de Logout (CONFRIMAÇÔES GERAIS)-->
        <script src="js/confirma.js"></script>
    </body>
</html>
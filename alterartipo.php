<?php
//REQUIRE(S):
require_once './Classes/DAOtiposTarefas.php';
require_once './Classes/autentica.php';
require_once './Classes/DAOtarefas.php';

$p = new DAOtiposTarefas();
$verificaExclusão = new DAOtarefas();
$val = $p->listByCod($_GET["cod"]);
$erro = 0; //NENHUM ERRO;
//VERIFICA SE É POSSÍVEL EXCLUIR O TIPO;
if ($verificaExclusão->listByTipo($_GET["cod"])) {
    $erro = 2; //NÃO É POSSÍVEL EXCLUIR O TIPO;
    $msg = "NÃO É POSSÍVEL EXCLUIR ESTE TIPO DE TAREFA!";
}

if (isset($_POST["save"])) { // UPDATE;
    if ($p->listByDesc($_POST["tipotarefa"])) {
        $erro = 1; //TIPO JÁ CADASTRADO;
        $msg = "TIPO DE TAREFA JÁ CADASTRADO!";
    } else {
        $p->update($_POST['cod'], $_POST['tipotarefa']); //UPDATE;
        header('Location: tiposdetarefas.php');
        exit();
    }
} else if (isset($_POST["delete"])) { // DELETE;
   if ($verificaExclusão->listByTipo($_GET["cod"])) {
    $erro = 2; //NÃO É POSSÍVEL EXCLUIR O TIPO;
    $msg = "NÃO É POSSÍVEL EXCLUIR ESTE TIPO DE TAREFA!";
}else{
    $delete = $p->delete($_POST['cod']);
          header('Location: tiposdetarefas.php');
          exit();
}
    // VERIFICA SE O CÓDIGO DE TIPO NÃO FOI PASSADO NA QUERYSTRING.";      
} else if (!isset($_GET["cod"]) || empty($_GET["cod"]) || !$p->listByCod($_GET["cod"])) {
    header('Location: tiposdetarefas.php');
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
        <title>Editar Tipo de Tarefa</title>
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
                    <h1>EDITAR TIPO DE TAREFA</h1>
                </div>
            </div>
        </div>


        <div class="container"> 
            <form class="navbar-form" method="post">
                <div class="form-group">
                    <label for="cod" class="form-horizontal">Código:</label>
                    <input type="number" name="cod" id="cod" class="form-control" required="" value="<?php echo $_GET['cod']; ?>" 
                           readonly="">
                </div>
                <div class="form-group">
                    <label for="tipotarefa" class="form-horizontal">Tipo:</label>
                    <input type="text" name="tipotarefa" id="tipotarefa" class="form-control" required="" autofocus="" 
                           value="<?php echo $val['descricaoTipo']; ?>" maxlength="50"a>
                </div>


                <div class="form-group">
                    <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="SALVAR" required="">
                </div>
                <div class="form-group">
                    <button name="delete" id="delete" type="submit" class="btn btn-block btn-warning" <?php if ($erro == 2){echo 'disabled';}?>>
                        EXCLUIR</button>
                </div>
                <div class="form-group">
                    <a href="tiposdetarefas.php" class="btn btn-block btn-danger">CANCELAR</a>
                </div>

            </form>
            
                        
                    <?php if ($erro == 1){
                        echo '<div class="alert alert-danger" style="text-align: center">'
                        . $msg .
                        '</div>';
                    }?>
            
                                
                    <?php if ($erro == 2){
                        echo '<div class="alert alert-warning" style="text-align: center">'
                        . $msg .
                        '</div>';
                    }?>
            
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
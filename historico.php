<?php
//REQUIRE(S);
require_once './Classes/DAOtarefas.php';
require_once './Classes/DAOusuarios.php';
require_once './Classes/DAOlocais.php';
require_once './Classes/DAOtiposTarefas.php';
require_once './Classes/autentica.php';


$local = new DAOlocais();
$tipo = new DAOtiposTarefas();
$tar = new DAOtarefas();
$usuario = new DAOusuarios();
$sltipo = $tipo->listAll();
$x = ''; //variável para controlar o 'selected' na tag <select>;
$erro = 0;

//VERIFICA SE "q" ESTÁ NA QUERYSTRING;
if (isset($_GET["q"]) && !empty($_GET["q"])) { //SE "q" É DIFERENTE DE 'todos';
    if ($_GET["q"] != 'todos') {//SE "q" É DIFERENTE DE 'todos';
        $x = $_GET["q"];
        $agenda = $tar->listAllByUsuarioTipoTarefa($_SESSION["user"], $_GET["q"]);
    } else {// SE "q" NÃO ESTÁ NA QUERYSTRING;
        $agenda = $tar->listAllByUsuario($_SESSION["user"]);
    }
} else {
    $agenda = $tar->listAllByUsuario($_SESSION["user"]);
}

if (!$agenda) { //VERIFCA SE O HISTÓRICO ESTÁ VAZIO;
    $erro = 1; //NENHUMA TAREFA ENCONTRADA.
    $msg = 'Nenhuma tarefa encontrada! - <a href="novatarefa.php">Adicione uma tarefa</a> ou altere tipo pesquisado.';
}


if (isset($_POST["print"])) {//VERIFICA O POST DE "print" - GERAR PDF;
    if (isset($_GET["q"])) {
        if ($_GET["q"] == 'todos') {//GERAR PDF DE "TODOS" - TIPOS DE TAREFAS;
            header("Location: PDF/pdf_historico.php");
        } else {//GERAR PDF DE APENAS UM TIPO DE TAREFAS;
            header("Location: PDF/pdf_historico.php?q=" . $_GET["q"]);
        }
    } else {//GERAR PDF DE TODOS OS TIPOS DE TAREFAS;
        header("Location: PDF/pdf_historico.php");
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
        <title>Histórico de <?php
            echo $usuario->listByCod($_SESSION["user"])["nome"];?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="navbar navbar-default">
            <div class="container">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <form method="post" class="form">
                            <button name="print" class="btn btn-default"  <?php if ($erro == 1) {
                                                                                    echo "disabled";}?>>
                                <i class="glyphicon glyphicon-print"></i> IMPRIMIR </button>
                            <button name="logout" id="logout" class="btn btn-danger"><i class="glyphicon glyphicon-log-out"></i> SAIR </button>
                        </form>
                    </div> 
                </div>

                <h1 style="text-transform: uppercase">HISTÓRICO DE <?php
            echo $usuario->listByCod($_SESSION["user"])["nome"];?></h1>    
            </div>
        </div>



        <div class="container">
            <form class="navbar-form" method="get">
                <div class="input-group">
                    <select  id="q" name="q" autofocus="" class="form-control" required="">
                        <option value="">Filtrar por Tipo</option>
                        <option value="todos" <?php
                                                if ($x == 'todos') {
                                                    echo ' selected=""; ';
                                                }?>
                                > Todos os Tipos</option>
                                <?php
                                foreach ($sltipo as $slt) {
                                    echo '<option ';
                                    if ($slt["codigoTipo"] == $x) {
                                        echo ' selected="" ';
                                    }
                                    echo ' value="'
                                    . $slt["codigoTipo"] .
                                    '"> ';
                                    echo $slt["descricaoTipo"];
                                    echo ' </option>';
                                }
                                ?>
                    </select>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search "></i></button>

                    </div>
                </div>   
                <div class="form-group"> 
                    <a href="novatarefa.php" class="btn btn-success" ><i class="glyphicon glyphicon-plus"></i> NOVA TAREFA</a>
                    <a href="agenda.php" class="btn btn-success" ><i class="glyphicon glyphicon-list"></i> AGENDA</a>
                    <a href="locais.php" class="btn btn-success" ><i class="glyphicon glyphicon-globe"></i> LOCAIS</a>
                    <a href="tiposdetarefas.php" class="btn btn-success" ><i class="glyphicon glyphicon-wrench"></i> TIPOS DE TAREFAS</a>
                    <a href="alterarusuario.php" class="btn btn-success" ><i class="glyphicon glyphicon-user"></i> CONTA</a>           
                </div>
            </form> 

            <div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>

                            <th><center>DATA</center></th>
                    <th><center>TAREFA</center></th>
                    <th><center>TIPO</center></th>
                    <th><center>LOCAL</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($agenda as $tarefa) {
                            $descTipo = $tipo->listByCod($tarefa['codigoTipo'])['descricaoTipo'];
                            $descLocal = $local->listByCod($tarefa['codigoLocal'])['descricaoLocal'];
                            $data = new DateTime($tarefa['data']);

                            echo "<tr>" .
                            '<td align="center">'
                            . $data->format('d/m/Y')
                            . '</td>'
                            . '<td align="center">'
                            . '<a href=alterartarefa.php?cod=' . $tarefa['codigoTarefa'] . '>'
                            . $tarefa['descricaoTarefa']
                            . '</a></td>'
                            . '<td align="center">'
                            . $descTipo
                            . '</td>'
                            . '<td align="center">'
                            . $descLocal
                            . '</td>'
                            . '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <div style="text-align: center">
                    <?php
                    if ($erro == 1) {
                        echo '<div class="alert alert-success">'
                        . $msg .
                        '</div>';
                    }
                    ?>
                </div>
            </div>
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


              

              
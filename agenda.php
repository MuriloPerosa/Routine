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
$erro = 0; //NENHUM ERRO; 

//VERIFICA SE "q" ESTÁ NA QUERYSTRING;
if (isset($_GET["q"]) && !empty($_GET["q"])) {
    if ($_GET["q"] != 'todos') { //SE "q" É DIFERENTE DE 'todos';
        $x = $_GET["q"];
        $agenda = $tar->listByUsuarioTipo($_SESSION["user"], $_GET["q"]);
    } else { //SE "q" É IGUAL A 'todos';
        $agenda = $tar->listByUsuarioCD($_SESSION["user"]);
    }
} else { // SE "q" NÃO ESTÁ NA QUERYSTRING;
    $agenda = $tar->listByUsuarioCD($_SESSION["user"]);
}

if (!$agenda) { // VERIFICA SE AGENDA ESTÁ VAZIA.
    $erro = 1; //NENHUMA TAREFA ENCONTRADA.
    $msg = 'Nenhuma tarefa encontrada! - <a href="novatarefa.php">Adicione uma tarefa</a> ou altere tipo pesquisado.';
}

if (isset($_POST["print"])) { //VERIFICA O POST DE "print" - GERAR PDF;
    if (isset($_GET["q"])) {
        if ($_GET["q"] == 'todos') { //GERAR PDF DE "TODOS" - TIPOS DE TAREFAS;
            header("Location: PDF/pdf_agenda.php");
        } else { //GERAR PDF DE APENAS UM TIPO DE TAREFAS;
            header("Location: PDF/pdf_agenda.php?q=" . $_GET["q"]);
        }
    } else {//GERAR PDF DE TODOS OS TIPOS DE TAREFAS;
        header("Location: PDF/pdf_agenda.php");
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
        <title>Agenda de <?php
            echo $usuario->listByCod($_SESSION["user"])["nome"];
            ?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>


        <div class="navbar navbar-default">
            <div class="container">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <form method="post" class="form">
                            <button name="print" class="btn btn-default" <?php if ($erro == 1 || $erro == 2) {
                                                                                    echo "disabled";
                                                                                }?>>
                                <i class="glyphicon glyphicon-print"></i> IMPRIMIR </button>
                            <button name="logout" id="logout" class="btn btn-danger"><i class="glyphicon glyphicon-log-out"></i> SAIR </button>
                        </form>
                    </div> 
                </div>
                <h1 style="text-transform: uppercase">AGENDA DE <?php
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
                                                    } ?>
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
                    <a href="historico.php" class="btn btn-success" ><i class="glyphicon glyphicon-list"></i> HISTÓRICO</a>
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
                    
                    if ($erro == 2) {
                        echo '<div class="alert alert-warning">'
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


              
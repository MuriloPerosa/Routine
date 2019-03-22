<?php

//REQUIRE(S):
require_once './Classes/DAOtiposTarefas.php';
require_once './Classes/autentica.php';

$p = new DAOtiposTarefas();
$tab = $p->listAll(); 
$erro = 0; //NENHUM ERRO;

//VERIFICA SE HÁ TIPOS DE TAREFAS CADASTRADOS;
if(!$p->listAll()){
    $erro = 1; //NENHUM TIPO DE TAREFA CADASTRADO!
    $msg = "Nenhum tipo de tarefa cadastrado!";
}

if (isset($_POST["save"])) { //INSERIR TIPO;
    if($p->listByDesc($_POST["tipo"])){
        $erro = 2; //TIPO DE TAREFA JÁ CADASTRADO!;
        $msg = "TIPO DE TAREFA JÁ CADASTRADO";
    }else{//INSERE TIPO;
        $p->insert($_POST["tipo"]);
        header('Location: tiposdetarefas.php');
        exit();

    };
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
        <title>Tipos de Tarefas</title>

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
                    <h1>TIPOS DE TAREFAS</h1>
                </div>
            </div>
        </div>

            <div class="container">
                <form class="navbar-form" autocomplete="off" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" id="tipo" name="tipo" autofocus="" maxlength="50" 
                               required="" placeholder="Adicionar tipo de Tarefa" value="<?php if($erro == 2) echo $_POST["tipo"]?>">
                        <div class="input-group-btn">
                            <button class="btn btn-success" name="save" id="save" type="submit">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>

                        </div>
                    </div>
                    <a href="agenda.php" class="btn btn-success" >
                        <i class="glyphicon glyphicon-list"></i> AGENDA</a>
                </form> 
                
             <?php if ($erro == 2){
             echo '<div class="alert alert-danger">'
                . $msg .
                '</div>';
           }?>
            
                <hr>
            </div>

            <div class="container">
                <div>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><center>CÓDIGO</center></th>
                        <th><center>TIPO</center></th>

                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tab as $tabela) {
                                //LISTA TODOS OS TIPOS DE TAREFAS.
                                echo "<tr>" .
                                '<td align="center">'
                                . $tabela['codigoTipo']
                                . '</td>'
                                . '<td align="center">'
                                . '<a href=alterartipo.php?cod=' . $tabela['codigoTipo']. '>'
                                . $tabela['descricaoTipo']
                                . '</a></td>'
                                . '</tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                                    
                <?php if ($erro == 1){
                echo '<div style="text-align: center" class="alert alert-success">'
                        . $msg .
                        '</div>';
              }?>
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

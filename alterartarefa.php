    <?php
//REQUIRE(S):
require_once './Classes/DAOtarefas.php';
require_once './Classes/DAOtiposTarefas.php';
require_once './Classes/DAOlocais.php';
require_once './Classes/autentica.php';

$tar = new DAOtarefas();
$tarefa = $tar->listByCod($_GET["cod"]);

$tipo = new DAOtiposTarefas();
$sltipo = $tipo->listAll();

$loc = new DAOlocais();
$local = $loc->listAll();

$erro = 0; //NENHUM ERRO;

if (isset($_POST["save"])) { // UPDATE TAREFA.
    
    $dataAtual = date("Y-m-d"); //ATRIBUI PARA A VARIÁVEL O VALOR DA DATA ATUAL;
    
    if ($_POST["data"] < $dataAtual) { //TESTA SE A NOVA DATA DE TAREFA JÁ PASSOU
       $erro = 1;//DATA QUE JÁ PASSOU SELECIONADA;
       $msg = 'DATA INVÁLIDA - DATA JÁ PASSADA FOI SELECIONADA!';
    } else {
        $tar->update($_POST["desc"], $_POST["data"], $_POST["local"], $_POST["tipo"], $_GET["cod"]);
        header('Location: agenda.php');
        exit();
    }
} else if (isset($_POST["delete"])) { // DELETE TAREFA.
    $tar->delete($_GET["cod"]);
    header('Location: agenda.php');
    exit();
} else if (!isset($_GET["cod"]) || empty ($_GET["cod"]) || !$tar->listByCod($_GET["cod"])) { //VERIFICA SE O CÓDIGO DE TAREFA NÃO FOI PASSADO NA QUERYSTRING.
    header('Location: agenda.php');
    exit();
}

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
        <title>Editar Tarefa</title>

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
                    <h1>EDITAR TAREFA</h1>
                </div>
            </div>
        </div>


        <div class="container">

                <form method="post" autocomplete="off">

                    <div class="form-group">
                        <label for="desc" class="control-label">Descrição:</label>
                        <input type="text" name="desc" id="desc" class="form-control" 
                               value="<?php if($erro == 1){echo $_POST["desc"];}else{echo $tarefa["descricaoTarefa"];} ?>" autofocus="" maxlength="50" required="">
                    </div>

                    <div class="form-group">
                        <label for="data" class="control-label">Data:</label>
                        <input type="date" name="data" id="data" class="form-control" 
                               value="<?php if($erro == 1){echo $_POST['data'];}else{echo $tarefa["data"];} ?>" required="">
                    </div>
                    
                    <?php
                        if (isset($msg)) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                    '</div>';
                        }
                     ?>

                    <div class="form-group">
                        <label for="tipo" class="control-label">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-control" required="">
                            <option value="">Selecione o tipo da Tarefa</option>
                            
                            <?php
                            //EXIBE OS TIPOS DE TAREFAS CADASTRADOS PARA SELEÇÃO.
                            if($erro == 1){                            
                            foreach ($sltipo as $tipo) {
                                echo '<option ';
                                
                                //FAZ COM QUE O TIPO ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($tipo["codigoTipo"] == $_POST["tipo"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $tipo["codigoTipo"] .
                                '"> ';
                                echo $tipo["descricaoTipo"];
                                echo ' </option>';
                            }
                                
                            }else{
                                                            
                            foreach ($sltipo as $tipo) {
                                echo '<option ';
                                
                                //FAZ COM QUE O TIPO ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($tipo["codigoTipo"] == $tarefa["codigoTipo"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $tipo["codigoTipo"] .
                                '"> ';
                                echo $tipo["descricaoTipo"];
                                echo ' </option>';
                            }
                            }

                            ?>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="local" class="control-label">Local:</label>
                        <select name="local" id="local" class="form-control" required="">
                            <option value="">Selecione o local da Tarefa</option>
                            
                            <?php
                            if($erro == 1){ 
                                
                            //EXIBE OS LOCAIS CADASTRADOS PARA SELEÇÃO.
                            foreach ($local as $sllocal) {
                                echo '<option ';
                                
                                //FAZ COM QUE O LOCAL ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($sllocal["codigoLocal"] == $_POST["local"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $sllocal["codigoLocal"] .
                                '"> ';
                                echo $sllocal["descricaoLocal"];
                                echo ' </option>';
                            }
                            }else{
                                
                            //EXIBE OS LOCAIS CADASTRADOS PARA SELEÇÃO.
                            foreach ($local as $sllocal) {
                                echo '<option ';
                                
                                //FAZ COM QUE O LOCAL ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($sllocal["codigoLocal"] == $tarefa["codigoLocal"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $sllocal["codigoLocal"] .
                                '"> ';
                                echo $sllocal["descricaoLocal"];
                                echo ' </option>';
                            }
                            }
                            
                            ?>
                            
                        </select>
                    </div>


                    <div class="form-group">
                        <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="SALVAR" style="margin-top: 30px;">
                    </div>
              
                
                    <div class="form-group">
                        <button name="delete" id="delete" class="btn btn-block btn-warning">EXCLUIR</button>
                    </div>

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
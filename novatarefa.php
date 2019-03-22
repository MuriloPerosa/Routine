<?php
//REQUIRE(S):
require_once './Classes/DAOtarefas.php';
require_once './Classes/DAOtiposTarefas.php';
require_once './Classes/DAOlocais.php';
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';

$loc = new DAOlocais();
$tip = new DAOtiposTarefas();
$usuario = new DAOusuarios();
$tar = new DAOtarefas();

$erro = 0; //NENHUM ERRO;

if (isset($_POST["save"])) { // INSERIR TAREFA;
    $dataAtual = date('Y-m-d');
    if ($_POST["data"] < $dataAtual) { //TESTA SE A DATA DE TAREFA JÁ PASSOU
        $erro = 1; // DATA INVÁLIDA;
        $msg = 'DATA INVÁLIDA - DATA JÁ PASSADA FOI SELECIONADA!';
    } else { //INSERE TAREFA;
        $tar->insert($_POST["desc"], $_POST["data"], $_POST["local"], $_POST["tipo"], $_SESSION["user"]);
        header('Location: agenda.php');
        exit();
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
        <title>Nova Tarefa</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        

        <div class="navbar navbar-default">
            <div class="container">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <form method="post" class="form">
                            <button name="logout" id="logout" class="btn btn-danger">
                                <i class="glyphicon glyphicon-log-out"></i> SAIR </button>
                        </form>
                    </div>
                </div>

                <div>
                    <h1>NOVA TAREFA</h1>
                </div>
            </div>
        </div>
        
        <div class="container">
           
                
                <form method="post" autocomplete="off">
                    
                    <div class="form-group">
                        <label for="desc" class="control-label">Descrição:</label>
                        <input type="text" name="desc" id="desc" class="form-control" value="<?php if($erro == 1){echo $_POST["desc"];}?>"
                               placeholder="Descrição da tarefa" autofocus="" required="" maxlength="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="data" class="control-label">Data</label>
                        <input type="date" name="data" id="data" value="<?php if($erro == 1){echo $_POST["data"];}?>" 
                               class="form-control" placeholder="Data" required="">
                    </div>
                    
                     <?php
                        if ($erro == 1) {
                            echo '<div class="alert alert-danger">'
                            .$msg.
                                    '</div>';
                        }
                     ?>
                    
                      <div class="form-group">
                        <label for="local" class="control-label">Local:</label>
                        <select name="local" id="local" class="form-control" value="<?php if($erro == 1){echo $_POST["local"];}?>" required="">
                            <option value="">Selecione o local da Tarefa</option> 
                                <?php
                            
                         if($erro == 1){                            
                            foreach ($loc->listAll() as $local) {
                                echo '<option ';
                                
                                //FAZ COM QUE O TIPO ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($local["codigoLocal"] == $_POST["local"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $local["codigoLocal"] .
                                '"> ';
                                echo $local["descricaoLocal"];
                            echo ' </option>';}
                            }else{
                                //EXIBE TODOS OS LOCAIS CADASTRADOS COMO OPÇÕES.
                                foreach ($loc->listAll() as $local) {
                                    echo '<option value="'
                                    . $local["codigoLocal"]
                                            . ''
                                            .'">';
                                    echo $local["descricaoLocal"];
                                }
                                }
                                ?>
                        </select>
                      </div>
                        
                      <div class="form-group">
                        <label for="tipo" class="control-label">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-control" required="">
                            <option value="">Selecione o tipo da Tarefa</option>
                             <?php
                             if($erro == 1){
                                foreach ($tip->listAll() as $tipo) {
                                echo '<option ';
                                
                                //FAZ COM QUE O TIPO ATUAL DA TAREFA SEJA PRÉ-SELECIONADO. 
                                if ($tipo["codigoTipo"] == $_POST["tipo"]) {
                                    echo ' selected="" ';
                                }
                                echo 'value="'
                                . $tipo["codigoTipo"] .
                                '"> ';
                                echo $tipo["descricaoTipo"];
                            echo ' </option>';}
                             }else{
                               //EXIBE TODOS OS TIPOS DE TAREFAS CADASTRADOS COMO OPÇÕES.
                                foreach ($tip->listAll() as $tipo) {
                                    echo '<option value="'
                                    . $tipo["codigoTipo"]
                                            . '">';
                                    echo $tipo["descricaoTipo"];
                                    echo '</option>';
                                }
                             }
                                ?>
                             

                        </select>
                      </div>
                    
                    
                      <div class="form-group">
                        <label for="usuario" class="control-label">Usuário:</label>
                        <input name="usuario" id="usuario" class="form-control" readonly="" required="" value="<?php  
                        echo $usuario->listByCod($_SESSION["user"])['nome'];//INFORMA O USUÁRIO PELO CÓDIGO.?>" >
                      </div>
                    
                    
                    <div class="form-group">
                        <input type="submit" id="save" name="save" class="btn btn-block btn-success" value="ADICIONAR" style="margin-top: 30px;">
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
<?php
//REQUIRE(S):
require_once './Classes/DAOlocais.php';
require_once './Classes/DAOusuarios.php';
require_once './Classes/autentica.php';

$p = new DAOlocais(); 
$u = new DAOusuarios();
$local = $p->listAll(); // LISTAR LOCAIS;
$erro = 0; //NENHUM ERRO;

if(!$p->listAll()){
    $erro = 1; //NENHUM LOCAL CADASTRADO.
    $msg = "Nenhum local cadastrado!";
}
if (isset($_POST["save"])) { //INSERIR;
    if($p->listByDesc($_POST["local"])){
        $erro = 2; //LOCAL JÁ CADASTRADO.
        $msg = "LOCAL JÁ CADASTRADO!";
    }else{//INSERE;
      $p->insert($_POST["local"], $_SESSION["user"]);
      header("Location: locais.php");
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
        <title>Locais</title>

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
                    <h1>LOCAIS</h1>
                </div>
            </div>
        </div>


        <div class="container">
            <form class="navbar-form" id="addLocalForm" method="post" autocomplete="off">   
                <div class="input-group">
                    <input type="text" class="form-control" id="local" name="local" required="" 
                           maxlength="50" autofocus="" placeholder="Adicionar Local" value="<?php if($erro == 2) { echo $_POST['local']; }?>">
                    <div class="input-group-btn">
                        <button class="btn btn-success" name="save" id="save" type="submit"><i class="glyphicon glyphicon-plus"></i></button>

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
                    <th><center>LOCAL</center></th>
                    <th><center>CRIADOR</center></th>

                    </tr>
                    </thead>
                    <tbody>

                        <?php
                        //Exibe a tabela com todos os lugares, seus códigos e o nome de quem os inseriu/alterou;
                        foreach ($local as $loc) {
                            echo "<tr>" .
                            '<td align="center">'
                            . $loc['codigoLocal']
                            . '</td>'
                            . '<td align="center">'
                            . '<a href=alterarlocal.php?cod=' . $loc['codigoLocal'] . '>'
                            . $loc['descricaoLocal']
                            . '</a></td>'
                            . '<td align="center">'
                            . $u->listByCod($loc['codigoUsuario'])['nome']
                            . '</td>'
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
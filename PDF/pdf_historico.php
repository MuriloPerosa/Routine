<?php
require_once '../Bibliotecas/MPDF/mpdf.php';
require_once '../Classes/DAOtarefas.php';
require_once '../Classes/DAOusuarios.php';
require_once '../Classes/DAOlocais.php';
require_once '../Classes/DAOtiposTarefas.php';
require_once '../Classes/autentica.php';

$local = new DAOlocais();
$tipo = new DAOtiposTarefas();
$tar = new DAOtarefas();
$usuario = new DAOusuarios();
$sltipo = $tipo->listAll();
$dia = new DateTime();


if (isset($_GET["q"])){
    $txttipo = " ". $tipo->listByCod($_GET["q"])["descricaoTipo"];
    $agenda = $tar->listAllByUsuarioTipoTarefa($_SESSION["user"], $_GET["q"]);
} else {
    $txttipo = ' Todos os Tipos';
    $agenda = $tar->listAllByUsuario($_SESSION["user"]);
}

    
    $pdf= new mPDF('c', 'A4');
    $pdf->SetDisplayMode("fullpage");
    $pdf->WriteHTML('<h1 style="text-transform: uppercase; text-align: center ">HISTÓRICO DE '. $usuario->listByCod($_SESSION["user"])["nome"].
            '</h1> <hr> <br> <h3>Tipo de Tarefa:'.$txttipo.'</h3>');
    
   
    
    $html = '<table border=0 width=100%> <tr> <td> <center><table border="0">
                    <thead>
                        <tr>

                            <th><center>DATA</center></th>
                                                <th></th>

                    <th><center>TAREFA</center></th>
                    <th></th>
                    <th><center>TIPO</center></th>
                    <th> </th>
                    <th><center>LOCAL</center></th>
                    </tr>
                    </thead>
                    <tbody>';
                        
                        foreach ($agenda as $tarefa) {
        
                            $descTipo = $tipo->listByCod($tarefa['codigoTipo'])['descricaoTipo'];
                            $descLocal = $local->listByCod($tarefa['codigoLocal'])['descricaoLocal'];
                            $data = new DateTime($tarefa['data']);

                            $html = $html . "<tr>" .
                            '<td align="center"> '
                            . $data->format('d/m/Y')
                            .  '</td> <td>  |  </td>'
                            . ' <td align="center"> '
                            . $tarefa['descricaoTarefa']
                            . '</a></td> <td>  |  </td>'
                            . '<td align="center"> '
                            . $descTipo
                            . ' </td><td>  |  </td> '
                            . ' <td align="center"> '
                            . $descLocal
                            . ' </td> '
                            . ' </tr> ';
                        }
                        
                   $html = $html . "</tbody> </table></center> </td></tr></table>";
                   
                   $html= $html . '<hr> '
                           . '<br> <h5 style=" text-align: center">Routine - Data: '.$dia->format('d/m/Y H:i:s').'</h5>';
                   
                   $pdf->WriteHTML ($html);
    $pdf->Output('historico.pdf', 'I');
    exit();
    
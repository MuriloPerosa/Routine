<?php

require_once 'DAO.php';

class DAOtarefas extends DAO {

    //REALIZA INSERÇÃO EM TAREFAS.
    function insert($desc, $data, $local, $tipo, $user) {
        $sql = DAO::$db->prepare("Insert into tarefas(descricaoTarefa, data, codigoLocal, codigoUsuario, codigoTipo) "
                . "values (:desc, :data, :local, :user, :tipo)");
        $sql->execute(array(':desc' => $desc, ':data' => $data, ':local' => $local, ':user' => $user, ':tipo' => $tipo));
    }

    //REALIZA UPDATE EM TAREFAS;
    function update($desc, $data, $loc, $tipo, $cod) {
        $sql = DAO::$db->prepare("UPDATE tarefas SET descricaoTarefa = :desc, data = :data, codigoLocal= :loc, codigoTipo = :tipo "
                . "WHERE codigoTarefa = :cod;");
        $sql->execute(array(':desc' => $desc, ':data' => $data, ':loc' => $loc, ':tipo' => $tipo, ':cod' => $cod));
    }

    //DELETA DE TAREFAS;
    function delete($cod) {
        $sql = DAO::$db->prepare("DELETE FROM tarefas WHERE codigoTarefa = :cod;");
        $sql->execute(array(':cod' => $cod));
    }

    //LISTA TODAS AS TAREFAS DO USUÁRIO CUJAS DATAS SÃO IGUAIS OU SUPERIORES A DATA ATUAL.
    function listByUsuarioCD($cod) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoUsuario = :cod AND data >= current_date ORDER BY data;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetchALL();
    }

    //LISTA TODAS AS TAREFAS DE UM USUÁRIO PELO TIPO CUJA DATA AINDA NÃO PASSOU;
    function listByUsuarioTipo($cod, $tipo) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoUsuario = :cod AND data >= current_date AND codigoTipo = :tipo ORDER BY data");
        $sql->execute(array(':cod' => $cod, ':tipo' => $tipo));
        return $sql->fetchALL();
    }

    //LISTA TUDO A RESPEITO DA TAREFA CUJO CÓDIGO É PASSADO POR PARÂMETRO.
    function listByCod($cod) {
        $sql = DAO::$db->prepare("SELECT codigoTarefa, descricaoTarefa, data, codigoUsuario, codigoLocal, codigoTipo "
                . " FROM tarefas WHERE codigoTarefa = :cod;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetch();
    }

    // FUNÇÕES PARA O HISTÓRICO.
    //LISTA TODAS AS TAREFAS DO USUÁRIO SEM RESTRIÇÕES DE DATA.
    function listAllByUsuario($cod) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoUsuario = :cod ORDER BY data;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetchALL();
    }

    //LISTA TODAS AS TAREFAS DO USUÁRIO SEM RESTRIÇÕES DE DATA.
    function listAllByUsuarioTipoTarefa($cod, $tipo) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoUsuario = :cod AND codigoTipo = :tipo ORDER BY data;");
        $sql->execute(array(':cod' => $cod, ':tipo' => $tipo));
        return $sql->fetchALL();
    }

    //FUNÇÕES EXTRAS;
    //VERUFUCAR SE A EXCLUSÃO DO TIPO É POSSÍVEL;
    //LISTA TODAS AS TAREFAS PELO TIPO;
    function listByTipo($tipo) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoTipo = :tipo;");
        $sql->execute(array(':tipo' => $tipo));
        return $sql->fetchALL();
    }

    //VERUFUCAR SE A EXCLUSÃO DO LOCAL É POSSÍVEL;    
    //LISTA TODAS AS TAREFAS PELO LOCAL;
    function listByLocal($local) {
        $sql = DAO::$db->prepare("SELECT * "
                . " FROM tarefas WHERE codigoLocal = :local;");
        $sql->execute(array(':local' => $local));
        return $sql->fetchALL();
    }

    //DELETA TODAS AS TAREFAS DE UM USUÁRIO;
    function deleteAllByUsuario($cod) {
        $sql = DAO::$db->prepare("DELETE FROM tarefas WHERE codigoUsuario = :cod;");
        $sql->execute(array(':cod' => $cod));
    }

}

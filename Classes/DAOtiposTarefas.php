<?php

require_once 'DAO.php';

class DAOtiposTarefas extends DAO {

    // REALIZA INSERÇÃO EM TIPOS DE TAREFAS.
    function insert($tipo) {
        $sql = DAO::$db->prepare("Insert into tiposTarefas(descricaoTipo) values (:tipo);");
        $sql->execute(array(':tipo' => $tipo));
    }

    // REALIZA UPDATE EM TIPOS DE TAREFAS.
    function update($cod, $tipo) {
        $sql = DAO::$db->prepare("UPDATE tiposTarefas SET descricaoTipo = :tipo WHERE codigoTipo = :cod;");
        $sql->execute(array(':tipo' => $tipo, ':cod' => $cod));
    }

    // DELETA DE TIPOS DE TAREFAS.
    function delete($cod) {
        $sql = DAO::$db->prepare("DELETE FROM tiposTarefas WHERE codigoTipo = :cod;");
        $sql->execute(array(':cod' => $cod));
    }

    // LISTA TUDO DE TIPOS DE TAREFAS.
    function listAll() {
        $sql = parent::$db->prepare("Select * from tiposTarefas Order by descricaoTipo;");
        $sql->execute();
        return $sql->fetchAll();
    }

    // LISTA TUDO DO TIPO DE TAREFA CUJO CÓDIGO É PASSADO POR PARÂMETRO.
    function listByCod($cod) {
        $sql = DAO::$db->prepare("Select * from tiposTarefas where codigoTipo = :cod;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetch();
    }

    // LISTA TUDO DO TIPO DE TAREFA CUJA DESCRIÇÃO É PASSADA POR PARÂMETRO.
    function listByDesc($desc) {
        $sql = DAO::$db->prepare("Select * from tiposTarefas where descricaoTipo = :desc;");
        $sql->execute(array(':desc' => $desc));
        return $sql->fetch();
    }

}

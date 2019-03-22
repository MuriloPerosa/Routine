<?php

//REQUIRE(S):
require_once 'DAO.php';

class DAOlocais extends DAO {

    //INSERE EM LOCAIS.
    function insert($local, $criador) {
        $sql = DAO::$db->prepare("Insert into locais(descricaoLocal, codigoUsuario) values (:local, :criador);");
        $sql->execute(array(':local' => $local, ':criador' => $criador));
    }

    //REALIZA UPDATE EM LOCAIS.
    function update($cod, $local, $criador) {
        $sql = DAO::$db->prepare("UPDATE locais SET descricaoLocal = :local, codigoUsuario = :criador WHERE codigoLocal = :cod;");
        $sql->execute(array(':local' => $local, ':cod' => $cod, ':criador' => $criador));
    }

    //DELETA DE LOCAIS.
    function delete($cod) {
        $sql = DAO::$db->prepare("DELETE FROM locais WHERE codigoLocal = :cod;");
        $sql->execute(array(':cod' => $cod));
    }

    //LISTA TUDO DE LOCAIS.
    function listAll() {
        $sql = parent::$db->prepare("Select * from locais Order by descricaoLocal;");
        $sql->execute();
        return $sql->fetchAll();
    }

    //LISTA TUDO DO LOCAL CUJO CÓDIGO É PASSADO POR PARÂMETRO.
    function listByCod($cod) {
        $sql = DAO::$db->prepare("Select * from locais where codigoLocal = :cod;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetch();
    }

    // LISTA TUDO DO LOCAL CUJA DESCRIÇÃO É PASSADA POR PARÂMETRO.
    function listByDesc($desc) {
        $sql = DAO::$db->prepare("Select * from locais where descricaoLocal = :desc;");
        $sql->execute(array(':desc' => $desc));
        return $sql->fetch();
    }

    //REALIZA UPDATE NOS LOCAIS CUJO CODIGOUSUARIO É PASSADO POR PARAMETRO.
    //SERVE PARA SETAR O CRIADOR COMO O USUÁRIO PADRÃO NA HORA DA EXCLUSÃO DE UMA CONTA;
    function updateByUsuario($adm, $cod) {
        $sql = DAO::$db->prepare("UPDATE locais SET codigoUsuario = :adm WHERE codigoUsuario = :cod;");
        $sql->execute(array(':adm' => $adm, ':cod' => $cod));
    }

}

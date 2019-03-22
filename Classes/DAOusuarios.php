<?php

require_once 'DAO.php';

class DAOusuarios extends DAO {

//REALIZA INSERÇÃO EM USUARIOS.    
    function insert($nome, $email, $senha, $data) {

        $sql = DAO::$db->prepare("INSERT INTO usuarios (nome, email, senha)"
                . "VALUES (:nome, :email, :senha)");
        $sql->execute(array(':nome' => $nome, ':email' => $email, ':senha' => password_hash($senha, PASSWORD_DEFAULT)));
    }

    //REALIZA UPDATE EM USUARIOS - MENOS DE SENHA.
    function update($nome, $email, $data, $cod) {

        $sql = DAO::$db->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE codigousuario = :cod");
        $sql->execute(array(':nome' => $nome, ':email' => $email, ':cod' => $cod));
    }

    //REALIZA UPDATE DE SENHA.
    function updateSenha($senha, $cod) {

        $sql = DAO::$db->prepare("UPDATE usuarios SET senha = :senha WHERE codigousuario = :cod");
        $sql->execute(array(':senha' => password_hash($senha, PASSWORD_DEFAULT), ':cod' => $cod));
    }

    //LISTA TUDO A RESPEITO DO USUÁRIO CUJO CÓDIGO É PASSADO POR PARÂMETRO.
    function listByCod($cod) {
        $sql = DAO::$db->prepare("Select * from usuarios where codigoUsuario = :cod;");
        $sql->execute(array(':cod' => $cod));
        return $sql->fetch();
    }

    //LISTA TUDO A RESPEITO DE USUÁRIO COM DETERMINADO EMAIL - (LOGIN);
    function listByEmail($email) {
        $sql = DAO::$db->prepare("SELECT * FROM usuarios WHERE email = :email;");
        $sql->execute(array(":email" => $email));
        return $sql->fetch();
    }

    //REALIZA DELETE EM USUARIOS.
    function delete($cod) {

        $sql = DAO::$db->prepare("DELETE FROM usuarios WHERE codigousuario = :cod");
        return $sql->execute(array(':cod' => $cod));
    }

    //LISTA TUDO A RESPEITO DE USUÁRIO COM O EMAIL DE routine_web@gmail.com - ADM; 
    //SERVE PARA SETAR USUÁRIO PADRÃO;
    function listRoutine() {
        $sql = DAO::$db->prepare("SELECT * FROM usuarios WHERE email = 'routine_web@gmail.com';");
        $sql->execute();
        return $sql->fetch();
    }

}

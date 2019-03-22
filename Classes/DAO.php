<?php

//REALIZA CONEXÃO COM O BANCO DE DADOS.

class DAO {

    static protected $db;

    function __construct() {
        if (!isset(DAO::$db)) {
            
            DAO::$db = new PDO("mysql:host=localhost;dbname=db_routine", "root", "");
            DAO::$db->exec("SET CHARACTER SET utf8"); // DEFINE O TIPO DE CARACTERE;
           
        }
    }

}





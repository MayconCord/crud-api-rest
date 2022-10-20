<?php

namespace App\Core;

class Model {

    private static $conexao;

    public static function getConn(){

        if(!isset(self::$conexao)){
            self::$conexao = new \PDO("mysql:host=localhost;port=3306;dbname=rest_4tit;", "root", "123456");
        }

        return self::$conexao;
    }

}

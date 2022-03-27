<?php

namespace App\Core;

class Model {

    private static $conexao;

    public static function getConn()
    {

        if (!isset(self::$conexao)) {
            self::$conexao = new \PDO("mysql:host=127.0.0.1;port=3306;dbname=api_cidadao;", "root", "@Jxn9sid4");
        }

        return self::$conexao;
    }

}
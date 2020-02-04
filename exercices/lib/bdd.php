<?php

class BDD {

    protected static $_instance = null;

    static function getConnexion() {
        if(is_null(self::$_instance)) {
            $user ='root';
            $password = '0000';
            self::$_instance = new PDO('mysql:host=localhost;dbname=parcAuto', $user, $password);
        }
        return self::$_instance;
    }
}

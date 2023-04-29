<?php
    $host = "localhost";
    $user = "user";
    $password_db = "password";
    $database= "softwaresupplydb";

    class Database{
        public  static $db;
        public static function connect(){
            self::$db = new mysqli("localhost", "user", "password", "softwaresupplydb");
            self::$db->set_charset("utf8");
            if(self::$db->connect_error){
                die("Connection failed: " . self::$db->connect_error);
            }
        }
    }
?>

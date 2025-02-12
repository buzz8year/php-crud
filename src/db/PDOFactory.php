<?php

namespace db;

class PDOFactory
{
        protected static $pdo_written_instance;
        protected static $pdo_red_instance;
        
        public static function readInstance()
        {
                return self::writeInstance();
        }
        
        public static function writeInstance()
        {
                // NOTE: Condition required for testing
                if (!isset(self::$pdo_written_instance)) 
                        self::instantiateMySQL();
                
                return self::$pdo_written_instance;
        }
        
        public static function instantiateMySQL()
        {
                $dsn = sprintf("mysql:host=%s;port=%u;dbname=%s;charset=UTF8", MYSQL_HOST, MYSQL_PORT, MYSQL_DB);
                
                self::$pdo_written_instance = new \PDO($dsn, MYSQL_USER, MYSQL_PASS, array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',
                    \PDO::ATTR_EMULATE_PREPARES => false
                ));
                
                self::$pdo_written_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    
}

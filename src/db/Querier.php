<?php

namespace db;

class Querier
{

    protected static $pdo_written_instance;
    protected static $pdo_red_instance;


    public static function writeInstance()
    {
        // EXPLAIN: Condition will be required on future unit testing
        if (!isset(self::$pdo_written_instance)) 
        {
            self::$pdo_written_instance = new \PDO(
                sprintf("mysql:host=%s;port=%u;dbname=%s;charset=UTF8", MYSQL_HOST, MYSQL_PORT, MYSQL_DB),
                MYSQL_USER,
                MYSQL_PASS,
                array( // EXPLAIN: ...
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',
                    \PDO::ATTR_EMULATE_PREPARES => false
                )
            );

            // EXPLAIN: ...
            self::$pdo_written_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo_written_instance;
    }

    public static function readInstance()
    {
        return self::writeInstance();
    }
}
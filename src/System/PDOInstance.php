<?php

namespace Koenig\SQLQueryBuilder\System;

trait PDOInstance
{
    private $db;

    public function getPDO($config = null) {
        /* Here its own implementation of the interface */
        $dbHost = 'localhost';
        $dbName = 'git';
        $dbUser = 'root';
        $dbPass = '';
        $this->db = new \PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass,
            [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
            ]
        );
    }

    public function db() {
        return $this->db;
    }
}

<?php

namespace Classes;

require __DIR__.'/../../vendor/autoload.php';

use MysqliDb;

const TABLE = 'projects';

// TODO: PHPDoc all functions.
class Db
{

    protected $conn;

    // Make it real singleton.
    public function __construct()
    {
        if (empty($this->conn)) {
            $db_config = include __DIR__ . '/../../app/config/db.php';
            $this->conn = new MysqliDb($db_config['host'], $db_config['user'], $db_config['password'], $db_config['db']);
        }
    }

    public function getAll()
    {
        return $this->conn->get(TABLE);
    }

    public function getFromTo($start, $limit)
    {
        return $this->conn->get(TABLE, [$start, $limit]);
    }

    private function drop() 
    {
        $this->conn->rawQuery('DROP TABLE `' . TABLE . '`');
    }

    private function recreate() 
    {
        $this->conn->rawQuery(
            'CREATE TABLE `' . TABLE . '` (
      `id` bigint(20) NOT NULL,
      `p_id` bigint(20) NOT NULL,
      `name` varchar(255) NOT NULL,
      `link` varchar(2048) NOT NULL,
      `employer_name` varchar(255) NOT NULL,
      `employer_login` varchar(255) NOT NULL,
      `budget` decimal(10,2) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
      '
        );
        $this->conn->rawQuery(
            'ALTER TABLE `' . TABLE . '`
        ADD PRIMARY KEY (`id`);'
        );
        $this->conn->rawQuery(
            'ALTER TABLE `' . TABLE . '`
        MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;'
        );
    }

    public function refreshData($items) 
    {
        $this->drop();
        $this->recreate();
        $keys = Array('p_id', 'name', 'link', 'employer_name', 'employer_login', 'budget');
        return $this->conn->insertMulti(TABLE, $items, $keys);
    }

}
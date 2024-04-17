<?php

namespace connect;

use PDO;
use PDOStatement;

class ConnectionPDO
{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = 'Lavieestbelle!44';

    public $conn;

    public function connect()
    {
        return new PDO("mysql:host=$this->servername;dbname=PlanetsDB", $this->username, $this->password);
    }
}
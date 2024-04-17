<?php

namespace modeleUser;

use connect\ConnectionPDO;

include __DIR__ . "/dbConnexion.php";


class User extends ConnectionPDO
{
    public $pdo;
    public $connection;
    public $val;

    public function __construct()
    {
        $this->pdo = new ConnectionPDO();
        $this->connection = $this->pdo->connect();
    }

    public function getAllPlanets()
    {
        $this->val = $this->connection->prepare("SELECT * FROM Planets");
        $this->val->execute();
        return $this->val->fetchAll();
    }

    public function getPlanetsByName($name)
    {
        $query = "SELECT * FROM planets where name = :name;";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function insertData($name, $desc, $imgLink)
    {
        $query = "INSERT INTO planets (name, description,image_link)
                      VALUES  (:name, :desc,:imgLink);";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':imgLink', $imgLink);

        $stmt->execute();
        return  $this->connection->lastInsertId();
    }

}
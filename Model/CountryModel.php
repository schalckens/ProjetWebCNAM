<?php

namespace Model;

use \PDO;

class CountryModel
{
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create($name)
    {
        $sql = "INSERT INTO country (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name)]);
    }
    public function read($id)
    {
        $sql = "SELECT * FROM country WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
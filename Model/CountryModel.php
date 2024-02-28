<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class CountryModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    public function create($name) {
        $sql = "INSERT INTO country (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    public function read($id) {
        $sql = "SELECT * FROM country WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        $sql = "UPDATE country SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM country WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class DirectorModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    public function create($name) {
        $sql = "INSERT INTO director (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    public function read($id) {
        $sql = "SELECT * FROM director WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        $sql = "UPDATE director SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM director WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findByName($name) {
        $sql = "SELECT * FROM director WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createIfNotExists($name) {
        $director = $this->findByName($name);
        if ($director) {
            return $director['id'];
        } else {
            $this->create($name);
            return $this->db->lastInsertId();
        }
    }
}
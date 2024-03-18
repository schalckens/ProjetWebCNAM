<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class GenreModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }
    
    public function create($name) {
        $sql = "INSERT INTO genre (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    public function read($id) {
        $sql = "SELECT * FROM genre WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        $sql = "UPDATE genre SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM genre WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findByName($name) {
        $sql = "SELECT * FROM genre WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createIfNotExists($name) {
        $genre = $this->findByName($name);
        if ($genre) {
            return $genre['id'];
        } else {
            $this->create($name);
            return $this->db->lastInsertId();
        }
    }

}
<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class ActorModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    public function create($name, $profile_path) {
        $sql = "INSERT INTO actor (name, profile_path) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $profile_path]);
    }

    public function read($id) {
        $sql = "SELECT * FROM actor WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $profile_path) {
        $sql = "UPDATE actor SET name = ?, profile_path = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $profile_path, $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM actor WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findByName($name) {
        $sql = "SELECT * FROM actor WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createIfNotExists($name, $profile_path) {
        $actor = $this->findByName($name);
        if ($actor) {
            return $actor['id'];
        } else {
            $this->create($name, $profile_path);
            return $this->db->lastInsertId();
        }
    }
}
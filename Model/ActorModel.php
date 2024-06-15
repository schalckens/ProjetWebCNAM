<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class ActorModel
{
    private $db; // Instance de la base de données

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
    }

    // Créer un nouvel acteur
    public function create($name, $profile_path) {
        $sql = "INSERT INTO actor (name, profile_path) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $profile_path]);
    }

    // Lire les informations d'un acteur par ID
    public function read($id) {
        $sql = "SELECT * FROM actor WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'un acteur par ID
    public function update($id, $name, $profile_path) {
        $sql = "UPDATE actor SET name = ?, profile_path = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $profile_path, $id]);
    }

    // Supprimer un acteur par ID
    public function delete($id) {
        $sql = "DELETE FROM actor WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouver un acteur par nom
    public function findByName($name) {
        $sql = "SELECT * FROM actor WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un acteur s'il n'existe pas déjà
    public function createIfNotExists($name, $profile_path) {
        $actor = $this->findByName($name);
        if ($actor) {
            return $actor['id']; // Retourner l'ID de l'acteur existant
        } else {
            $this->create($name, $profile_path); // Créer un nouvel acteur
            return $this->db->lastInsertId(); // Retourner l'ID du nouvel acteur
        }
    }
}

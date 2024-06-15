<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class DirectorModel
{
    private $db; // Instance de la base de données

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
    }

    // Créer un nouveau réalisateur
    public function create($name) {
        $sql = "INSERT INTO director (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    // Lire les informations d'un réalisateur par ID
    public function read($id) {
        $sql = "SELECT * FROM director WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'un réalisateur par ID
    public function update($id, $name) {
        $sql = "UPDATE director SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }

    // Supprimer un réalisateur par ID
    public function delete($id) {
        $sql = "DELETE FROM director WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouver un réalisateur par nom
    public function findByName($name) {
        $sql = "SELECT * FROM director WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un réalisateur s'il n'existe pas déjà
    public function createIfNotExists($name) {
        $director = $this->findByName($name);
        if ($director) {
            return $director['id']; // Retourner l'ID du réalisateur existant
        } else {
            $this->create($name); // Créer un nouveau réalisateur
            return $this->db->lastInsertId(); // Retourner l'ID du nouveau réalisateur
        }
    }
}

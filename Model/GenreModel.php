<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class GenreModel
{
    private $db; // Instance de la base de données

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
    }
    
    // Créer un nouveau genre
    public function create($name) {
        $sql = "INSERT INTO genre (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    // Lire les informations d'un genre par ID
    public function read($id) {
        $sql = "SELECT * FROM genre WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'un genre par ID
    public function update($id, $name) {
        $sql = "UPDATE genre SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }

    // Supprimer un genre par ID
    public function delete($id) {
        $sql = "DELETE FROM genre WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouver un genre par nom
    public function findByName($name) {
        $sql = "SELECT * FROM genre WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un genre s'il n'existe pas déjà
    public function createIfNotExists($name) {
        $genre = $this->findByName($name);
        if ($genre) {
            return $genre['id']; // Retourner l'ID du genre existant
        } else {
            $this->create($name); // Créer un nouveau genre
            return $this->db->lastInsertId(); // Retourner l'ID du nouveau genre
        }
    }
}

<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class CountryModel
{
    private $db; // Instance de la base de données

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
    }

    // Créer un nouveau pays
    public function create($name) {
        $sql = "INSERT INTO country (name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name]);
    }

    // Lire les informations d'un pays par ID
    public function read($id) {
        $sql = "SELECT * FROM country WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'un pays par ID
    public function update($id, $name) {
        $sql = "UPDATE country SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $id]);
    }

    // Supprimer un pays par ID
    public function delete($id) {
        $sql = "DELETE FROM country WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouver un pays par nom
    public function findByName($name) {
        $sql = "SELECT * FROM country WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un pays s'il n'existe pas déjà
    public function createIfNotExists($name) {
        $country = $this->findByName($name);
        if ($country) {
            return $country['id']; // Retourner l'ID du pays existant
        } else {
            $this->create($name); // Créer un nouveau pays
            return $this->db->lastInsertId(); // Retourner l'ID du nouveau pays
        }
    }
}

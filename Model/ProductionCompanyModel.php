<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class ProductionCompanyModel
{
    private $db; // Instance de la base de données

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
    }

    // Créer une nouvelle société de production
    public function create($name, $logoPath, $originCountry) {
        $sql = "INSERT INTO production_company (name, logo_path, origin_country) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $logoPath, $originCountry]);
    }

    // Lire les informations d'une société de production par ID
    public function read($id) {
        $sql = "SELECT * FROM production_company WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'une société de production par ID
    public function update($id, $name, $logoPath, $originCountry) {
        $sql = "UPDATE production_company SET name = ?, logo_path = ?, origin_country = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $logoPath, $originCountry, $id]);
    }

    // Supprimer une société de production par ID
    public function delete($id) {
        $sql = "DELETE FROM production_company WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouver une société de production par nom
    public function findByName($name) {
        $sql = "SELECT * FROM production_company WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une société de production si elle n'existe pas déjà
    public function createIfNotExists($name, $logoPath, $originCountry) {
        $productionCompany = $this->findByName($name);
        if ($productionCompany) {
            return $productionCompany['id']; // Retourner l'ID de la société existante
        } else {
            $this->create($name, $logoPath, $originCountry); // Créer une nouvelle société
            return $this->db->lastInsertId(); // Retourner l'ID de la nouvelle société
        }
    }
}

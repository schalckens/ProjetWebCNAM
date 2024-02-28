<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class ProductionCompanyModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }
    
    public function create($name, $logoPath, $originCountry) {
        $sql = "INSERT INTO production_company (name, logo_path, origin_country) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $logoPath, $originCountry]);
    }

    public function read($id) {
        $sql = "SELECT * FROM production_company WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $logoPath, $originCountry) {
        $sql = "UPDATE production_company SET name = ?, logo_path = ?, origin_country = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $logoPath, $originCountry, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM production_company WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

}
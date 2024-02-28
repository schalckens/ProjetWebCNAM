<?php

namespace Model;
use PdoProjetWeb;
use PDO;

class UserModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    public function create($username, $mail, $isAdmin, $password) {
        $sql = "INSERT INTO user (username, mail, isAdmin, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function read($id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $mail, $isAdmin, $password) {
        $sql = "UPDATE user SET username = ?, mail = ?, isAdmin = ?, password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($password, PASSWORD_DEFAULT), $id]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


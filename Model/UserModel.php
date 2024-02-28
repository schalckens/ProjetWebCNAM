<?php

namespace Model;

use \PDO;

class UserModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create($username, $mail, $isAdmin, $mdp)
    {
        $sql = "INSERT INTO user (username, mail, isAdmin, mdp) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($mdp, PASSWORD_DEFAULT)]);
    }
    public function read($id)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $mail, $isAdmin, $mdp)
    {
        $sql = "UPDATE user SET username = ?, mail = ?, isAdmin = ?, mdp = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($mdp, PASSWORD_DEFAULT), $id]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


<?php

namespace Model;

use PdoProjetWeb;
use PDO;

class UserModel
{
    private $db;

    // Constructeur : initialise la connexion à la base de données.
    public function __construct()
    {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    // Crée un nouvel utilisateur avec les informations fournies et hash le mot de passe.
    public function create($username, $mail, $isAdmin, $password)
    {
        $sql = "INSERT INTO user (username, mail, isAdmin, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($password, PASSWORD_DEFAULT)]);
    }

    // Lit et retourne les informations d'un utilisateur spécifique par son ID.
    public function read($id)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Met à jour les informations d'un utilisateur existant, y compris le mot de passe hashé.
    public function update($id, $username, $mail, $isAdmin, $password)
    {
        $sql = "UPDATE user SET username = ?, mail = ?, isAdmin = ?, password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $mail, $isAdmin, password_hash($password, PASSWORD_DEFAULT), $id]);
    }

    // Supprime un utilisateur de la base de données par son ID.
    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Trouve et retourne un utilisateur par son nom d'utilisateur.
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retourne tous les utilisateurs de la base de données, sans leurs mots de passe.
    public function getAllUsers()
    {
        $sql = "SELECT id, username, mail, isAdmin FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistre un token de vérification pour un utilisateur spécifique par son ID.
    public function saveVerificationToken($id, $verificationToken)
    {
        $sql = "UPDATE user SET verification_token = :verificationToken WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':verificationToken', $verificationToken);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupère un utilisateur par son token de vérification.
    public function getUserByToken($token)
    {
        $sql = "SELECT * FROM user WHERE verification_token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Trouve et retourne un utilisateur par son email.
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE mail = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Marque le email d'un utilisateur comme vérifié et efface son token de vérification.
    public function markEmailAsVerified($id)
    {
        $sql = "UPDATE user SET is_verified = 1, verification_token = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // Enregistre un token de réinitialisation de mot de passe pour un email donné.
    public function savePasswordResetToken($email, $token)
    {
        $sql = "INSERT INTO password_resets (email, token, created_at) VALUES (:email, :token, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email, 'token' => $token]);
    }

    // Récupère un enregistrement de réinitialisation de mot de passe par son token.
    public function getPasswordResetByToken($token)
    {
        $sql = "SELECT * FROM password_resets WHERE token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Met à jour le mot de passe d'un utilisateur, identifié par son email, avec un nouveau mot de passe hashé.
    public function updateUserPassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = :password WHERE mail = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['password' => $hashedPassword, 'email' => $email]);
    }

    // Supprime un token de réinitialisation de mot de passe de la base de données pour éviter sa réutilisation.
    public function invalidateResetToken($token)
    {
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
    }

    // Vérifie si un nom d'utilisateur existe déjà dans la base de données.
    public function usernameExists($username)
    {
        $sql = "SELECT COUNT(*) FROM user WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Vérifie si un email existe déjà dans la base de données.
    public function emailExists($email)
    {
        $sql = "SELECT COUNT(*) FROM user WHERE mail = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }






}


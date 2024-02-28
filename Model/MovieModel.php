<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class MovieModel
{
    private $db;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
    }

    public function create($title, $releaseDate, $overview, $posterPath, $originalLanguage)
    {
        $sql = "INSERT INTO movie (title, releaseDate, overview, posterPath, originalLanguage) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage]);
    }

    public function read($id)
    {
        $sql = "SELECT * FROM movie WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $releaseDate, $overview, $posterPath, $originalLanguage) 
    {
        $sql = "UPDATE movie SET title = ?, releaseDate = ?, overview = ?, posterPath = ?, originalLanguage = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM movie WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

}
<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class MovieModel
{
    private $db;

    private $genreModel;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
        $this->genreModel = new GenreModel();
    }

    public function create($title, $releaseDate, $overview, $posterPath, $originalLanguage, $genres)
    {
        $sql = "INSERT INTO movie (title, release_date, overview, poster_path, original_language) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage]);
        $movieID = $this->db->lastInsertId();

        foreach ($genres as $genre) {
            $genreID = $this->genreModel->createIfNotExists($genre);
            $sql = "INSERT INTO movie_genre (movie_id, genre_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$movieID, $genreID]);
        }

        return $movieID;
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
        $sql = "UPDATE movie SET title = ?, release_date = ?, overview = ?, poster_path = ?, original_language = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM movie WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getAllMovies()
    {
        $sql = "SELECT * FROM movie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
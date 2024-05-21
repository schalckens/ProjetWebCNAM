<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class MovieModel
{
    private $db;

    private $genreModel;
    private $directorModel;
    private $countryModel;
    private $productionCompanyModel;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
        $this->genreModel = new GenreModel();
        $this->directorModel = new DirectorModel();
        $this->countryModel = new CountryModel();
        $this->productionCompanyModel = new ProductionCompanyModel();
    }

    public function create($title, $releaseDate, $overview, $posterPath, $originalLanguage, $genres, $directors, $countries, $productionCompanies)
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

        foreach ($directors as $director) {
            $directorID = $this->directorModel->createIfNotExists($director);
            $sql = "INSERT INTO movie_director (movie_id, director_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$movieID, $directorID]);
        }

        foreach ($countries as $country) {
            $countryID = $this->countryModel->createIfNotExists($country);
            $sql = "INSERT INTO movie_country (movie_id, country_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$movieID, $countryID]);
        }

        foreach ($productionCompanies as $productionCompany) {
            $productionCompanyID = $this->productionCompanyModel->createIfNotExists($productionCompany['name'], $productionCompany['logo_path'], $productionCompany['origin_country']);
            $sql = "INSERT INTO movie_production (movie_id, production_company_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$movieID, $productionCompanyID]);
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
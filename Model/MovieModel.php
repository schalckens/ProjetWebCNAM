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
    private $actorModel;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb();
        $this->genreModel = new GenreModel();
        $this->directorModel = new DirectorModel();
        $this->countryModel = new CountryModel();
        $this->productionCompanyModel = new ProductionCompanyModel();
        $this->actorModel = new ActorModel();
    }

    public function create($title, $releaseDate, $overview, $posterPath, $originalLanguage, $genres, $directors, $countries, $productionCompanies, $actors)
    {
        $sql = "SELECT COUNT(*) FROM movie WHERE title = ? AND release_date = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $releaseDate]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Movie with the same name and date already exists
            echo '<script type="text/javascript">alert("Movie already in the database!");</script>';
            return false;
        }

        try{
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

        foreach ($actors as $actor) {
            $actorID = $this->actorModel->createIfNotExists($actor['name'], $actor['profile_path']);
            $sql = "INSERT INTO movie_actor (movie_id, actor_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$movieID, $actorID]);
        }

        return $movieID;
    }
    catch(Exception $e){
        error_log($e->getMessage());
        return false;
    }
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

    public function getMovieByName($title)
    {
        $sql = "SELECT * FROM movie WHERE title = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMovieWithDetailsByName($title)
    {
        $sql = "SELECT * FROM movie WHERE title = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT genre.* FROM genre INNER JOIN movie_genre ON genre.id = movie_genre.genre_id WHERE movie_genre.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['genres'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT director.* FROM director INNER JOIN movie_director ON director.id = movie_director.director_id WHERE movie_director.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['directors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT country.* FROM country INNER JOIN movie_country ON country.id = movie_country.country_id WHERE movie_country.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT production_company.* FROM production_company INNER JOIN movie_production ON production_company.id = movie_production.production_company_id WHERE movie_production.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['production_companies'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT actor.* FROM actor INNER JOIN movie_actor ON actor.id = movie_actor.actor_id WHERE movie_actor.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['actors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $movie;
    }

}
<?php

namespace Model;
use PdoProjetWeb;
use \PDO;

class MovieModel
{
    private $db; // Instance de la base de données

    private $genreModel;
    private $directorModel;
    private $countryModel;
    private $productionCompanyModel;
    private $actorModel;

    public function __construct() {
        $this->db = PdoProjetWeb::getPdoProjetWeb(); // Initialisation de la connexion à la base de données
        // Initialisation des modèles associés
        $this->genreModel = new GenreModel();
        $this->directorModel = new DirectorModel();
        $this->countryModel = new CountryModel();
        $this->productionCompanyModel = new ProductionCompanyModel();
        $this->actorModel = new ActorModel();
    }

    // Créer un nouveau film avec tous les détails associés
    public function create($title, $releaseDate, $overview, $posterPath, $originalLanguage, $genres, $directors, $countries, $productionCompanies, $actors)
    {
        // Vérifier si le film existe déjà
        $sql = "SELECT COUNT(*) FROM movie WHERE title = ? AND release_date = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $releaseDate]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Film déjà existant
            echo '<script type="text/javascript">alert("Movie already in the database!");</script>';
            return false;
        }

        try {
            // Insérer les informations de base du film
            $sql = "INSERT INTO movie (title, release_date, overview, poster_path, original_language) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage]);
            $movieID = $this->db->lastInsertId();

            // Insérer les genres associés
            foreach ($genres as $genre) {
                $genreID = $this->genreModel->createIfNotExists($genre);
                $sql = "INSERT INTO movie_genre (movie_id, genre_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$movieID, $genreID]);
            }

            // Insérer les réalisateurs associés
            foreach ($directors as $director) {
                $directorID = $this->directorModel->createIfNotExists($director);
                $sql = "INSERT INTO movie_director (movie_id, director_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$movieID, $directorID]);
            }

            // Insérer les pays associés
            foreach ($countries as $country) {
                $countryID = $this->countryModel->createIfNotExists($country);
                $sql = "INSERT INTO movie_country (movie_id, country_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$movieID, $countryID]);
            }

            // Insérer les sociétés de production associées
            foreach ($productionCompanies as $productionCompany) {
                $productionCompanyID = $this->productionCompanyModel->createIfNotExists($productionCompany['name'], $productionCompany['logo_path'], $productionCompany['origin_country']);
                $sql = "INSERT INTO movie_production (movie_id, production_company_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$movieID, $productionCompanyID]);
            }

            // Insérer les acteurs associés
            foreach ($actors as $actor) {
                $actorID = $this->actorModel->createIfNotExists($actor['name'], $actor['profile_path']);
                $sql = "INSERT INTO movie_actor (movie_id, actor_id) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$movieID, $actorID]);
            }

            return $movieID;
        } catch(Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Lire les informations d'un film par ID
    public function read($id)
    {
        $sql = "SELECT * FROM movie WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations d'un film par ID
    public function update($id, $title, $releaseDate, $overview, $posterPath, $originalLanguage) 
    { 
        $sql = "UPDATE movie SET title = ?, release_date = ?, overview = ?, poster_path = ?, original_language = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $releaseDate, $overview, $posterPath, $originalLanguage, $id]);
    }

    // Supprimer un film par ID
    public function delete($id)
    {
        $sql = "DELETE FROM movie WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Obtenir tous les films
    public function getAllMovies()
    {
        $sql = "SELECT * FROM movie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir un film par titre
    public function getMovieByName($title)
    {
        $sql = "SELECT * FROM movie WHERE title = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtenir un film avec tous les détails associés par titre
    public function getMovieWithDetailsByName($title)
    {
        // Obtenir les informations de base du film
        $sql = "SELECT * FROM movie WHERE title = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtenir les genres associés
        $sql = "SELECT genre.* FROM genre INNER JOIN movie_genre ON genre.id = movie_genre.genre_id WHERE movie_genre.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['genres'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtenir les réalisateurs associés
        $sql = "SELECT director.* FROM director INNER JOIN movie_director ON director.id = movie_director.director_id WHERE movie_director.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['directors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtenir les pays associés
        $sql = "SELECT country.* FROM country INNER JOIN movie_country ON country.id = movie_country.country_id WHERE movie_country.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['countries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtenir les sociétés de production associées
        $sql = "SELECT production_company.* FROM production_company INNER JOIN movie_production ON production_company.id = movie_production.production_company_id WHERE movie_production.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['production_companies'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtenir les acteurs associés
        $sql = "SELECT actor.* FROM actor INNER JOIN movie_actor ON actor.id = movie_actor.actor_id WHERE movie_actor.movie_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$movie['id']]);
        $movie['actors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $movie;
    }
}

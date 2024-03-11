<?php

namespace Controler;
use Model\MovieModel;
use \TMDB;

class MovieControler
{
    private $movieModel;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieName = $_POST['movieName'] ?? null;
            if ($movieName) {
                $_SESSION['movieSearch'] = TMDB::searchMovies($movieName);
                $this->manageMovies();
            } else {
                echo "Veuillez saisir un nom de film.";
            }
        } else {
            $this->manageMovies();
        }
    }

    public function clearSearch()
    {
        $_SESSION['movieSearch'] = [];
        $this->manageMovies();
    }

    public function addMovie($id)
    {
        $movie = TMDB::getMovie($id);

        $success = $this->movieModel->create($movie['title'], $movie['release_date'], $movie['overview'] , $movie['poster_path'], $movie['original_language']);

        if (!$success) {
            throw new \Exception('Erreur lors de l\'ajout du film');
        }
        $this->manageMovies();
    }

    public function deleteMovie($id)
    {
        $success = $this->movieModel->delete($id);
        if (!$success) {
            throw new \Exception('Erreur lors de la suppression du film');
        }
        $this->manageMovies();
    }

    public function manageMovies()
    {
        $_SESSION['movies'] = $this->movieModel->getAllMovies();
        include 'View/manageMovie.php';
    }
}
?>
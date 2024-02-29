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
                $moviesSearch = TMDB::searchMovies($movieName);
                include 'View/manageMovie.php';
            } else {
                echo "Veuillez saisir un nom de film.";
            }
        } else {
            include 'View/manageMovie.php';
        }
    }

    public function addMovie($id)
    {
        $movie = TMDB::getMovie($id);
       
        $movieModel = new MovieModel();
        $movieDate = date('Y-m-d', strtotime($movie['release_date']));

        $success = $movieModel->create($movie['title'], $movie['release_date'], $movie['overview'] , $movie['poster_path'], $movie['original_language']);

        echo $success ? 'Film ajouté' : 'Erreur lors de l\'ajout du film';
        include 'View/manageMovie.php';
    }
}
?>
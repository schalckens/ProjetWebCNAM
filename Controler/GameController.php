<?php

namespace Controler;
use Controler\MovieControler;

class GameController{

    private $movieController;

    public function __construct()
    {
        $this->movieController = new MovieControler();
    }

    public function getRandomMovie()
    {
        $movies = $this->movieController->getAllMovies();
        $movie = $movies[array_rand($movies)];
        return $this->movieController->getMovieDetails($movie['title']);
    }

    public function compareMovie($movieName)
    {
        $randomMovie = $_SESSION['randomMovie']['title'];
        if ($movieName === $randomMovie) {
            $_SESSION['randomMovie'] = $this->getRandomMovie();
            echo json_encode($_SESSION['randomMovie']);
        } else {
            echo "false";
        }
    }

}
?>
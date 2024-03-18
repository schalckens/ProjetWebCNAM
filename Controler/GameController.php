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
        //echo $movies[array_rand($movies)]['title'];
        return $movies[array_rand($movies)];
    }

    public function compareMovie($movieName)
    {
        echo "Movie name: " . $movieName . ", randomMovie: " . $_SESSION['randomMovie'] . " ";
        $randomMovie = $_SESSION['randomMovie'];
        if ($movieName === $randomMovie) {
            echo "Bravo !";
        } else {
            echo "Dommage !";
        }
    }

}
?>
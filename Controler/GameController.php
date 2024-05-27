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
        $randomMovie = $_SESSION['randomMovie'];
        $comparedMovie = $this->movieController->getMovieDetails($movieName);

        $compareData = [
            'title' => $movieName === $randomMovie['title'] ? 'match' : 'no match',
            'debugRandomMovie' => $randomMovie['title'],
        ];


        if ($compareData['title'] === 'match') {
            $_SESSION['randomMovie'] = $this->getRandomMovie();
            $compareData['debugRandomMovie'] = $_SESSION['randomMovie']['title'];
        }

        echo json_encode($compareData);
    }

    public function getCurrentMovie()
    {
        return $_SESSION['randomMovie'];
    }

}
?>
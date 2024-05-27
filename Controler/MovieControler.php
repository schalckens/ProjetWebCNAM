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
        $moviePath = 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'];

        //echo json_encode($movie);

        $success = $this->movieModel->create($movie['title'], 
        $movie['release_date'],
        $movie['overview'], 
        $moviePath, 
        $movie['original_language'], 
        $movie['genres'], 
        $movie['directors'], 
        $movie['countries'], 
        $movie['production_companies'],
        $movie['actors']);

        header('Location: /manageMovie');
        exit();
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

    public function getMoviesByInput($input)
    {
        $moviesAll = $this->movieModel->getAllMovies();
        $movies = [];

         // Normalize the input string
        $normalizedInput = strtolower(str_replace(' ', '', $input));
        
        foreach ($moviesAll as $movie) {
            // Normalize the title string
            $normalizedTitle = strtolower(str_replace(' ', '', $movie['title']));

            if (str_contains($normalizedTitle, $normalizedInput) !== false) {
                $movies[] = $movie;
            }
        }

        echo json_encode($movies);
    }

    public function getMovieDetails($input)
    {
        $movie = $this->movieModel->getMovieWithDetailsByName($input);
        return $movie;
    }

    public function getAllMovies()
    {
        return $this->movieModel->getAllMovies();
    }
}
?>
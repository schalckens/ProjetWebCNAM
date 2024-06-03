<?php

namespace Controller;
use Controller\MovieController;

class GameController{

    private $movieController;

    public function __construct()
    {
        $this->movieController = new MovieController();
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


        
        {

            foreach ($comparedMovie['actors'] as $actor) {
                if (in_array($actor, $randomMovie['actors'])) {
                    $compareData['matchedActors'][$actor['name']] = "match";
                }
            }

            foreach ($comparedMovie['directors'] as $director) {
                if (in_array($director, $randomMovie['directors'])) {
                    $compareData['matchedDirectors'][$director['name']] = "match";
                }
            }

            foreach ($comparedMovie['genres'] as $genre) {
                if (in_array($genre, $randomMovie['genres'])) {
                    $compareData['matchedGenres'][$genre['name']] = "match";
                }
            }

            foreach ($comparedMovie['countries'] as $country) {
                if (in_array($country, $randomMovie['countries'])) {
                    $compareData['matchedCountries'][$country['name']] = "match";
                }
            }

            foreach ($comparedMovie['production_companies'] as $productionCompany) {
                if (in_array($productionCompany, $randomMovie['production_companies'])) {
                    $compareData['matchedProductionCompanies'][$productionCompany['name']] = "match";
                }
            }

            $compareData['original_language'] = $randomMovie['original_language'] === $comparedMovie['original_language'] ? 'match' : 'no match';

            $compareDate = $comparedMovie['release_date'];
            $movieDate = $randomMovie['release_date'];

            if ($compareDate > $movieDate) {
                $compareData['release_date'] = 'later';
            } else if ($compareDate < $movieDate) {
                $compareData['release_date'] = 'earlier';
            } else {
                $compareData['release_date'] = 'same';
            }
        }

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
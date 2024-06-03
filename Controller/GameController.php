<?php

namespace Controller;

use Controller\MovieController;

class GameController
{

    private $movieController;

    // Constructeur pour initialiser le MovieController
    public function __construct()
    {
        $this->movieController = new MovieController();
    }

    // Méthode pour obtenir un film aléatoire
    public function getRandomMovie()
    {
        $movies = $this->movieController->getAllMovies(); // Récupère tous les films
        $movie = $movies[array_rand($movies)]; // Sélectionne un film aléatoire
        return $this->movieController->getMovieDetails($movie['title']); // Renvoie les détails du film sélectionné
    }

    // Méthode pour comparer un film donné avec un film aléatoire
    public function compareMovie($movieName)
    {
        $randomMovie = $_SESSION['randomMovie']; // Récupère le film aléatoire stocké en session
        $comparedMovie = $this->movieController->getMovieDetails($movieName); // Récupère les détails du film à comparer

        // Initialisation des données de comparaison
        $compareData = [
            'title' => $movieName === $randomMovie['title'] ? 'match' : 'no match',
            'debugRandomMovie' => $randomMovie['title'],
        ];

        // Compare les acteurs des deux films
        foreach ($comparedMovie['actors'] as $actor) {
            if (in_array($actor, $randomMovie['actors'])) {
                $compareData['matchedActors'][$actor['name']] = "match";
            }
        }

        // Compare les réalisateurs des deux films
        foreach ($comparedMovie['directors'] as $director) {
            if (in_array($director, $randomMovie['directors'])) {
                $compareData['matchedDirectors'][$director['name']] = "match";
            }
        }

        // Compare les genres des deux films
        foreach ($comparedMovie['genres'] as $genre) {
            if (in_array($genre, $randomMovie['genres'])) {
                $compareData['matchedGenres'][$genre['name']] = "match";
            }
        }

        // Compare les pays de production des deux films
        foreach ($comparedMovie['countries'] as $country) {
            if (in_array($country, $randomMovie['countries'])) {
                $compareData['matchedCountries'][$country['name']] = "match";
            }
        }

        // Compare les sociétés de production des deux films
        foreach ($comparedMovie['production_companies'] as $productionCompany) {
            if (in_array($productionCompany, $randomMovie['production_companies'])) {
                $compareData['matchedProductionCompanies'][$productionCompany['name']] = "match";
            }
        }

        // Compare les langues originales des deux films
        $compareData['original_language'] = $randomMovie['original_language'] === $comparedMovie['original_language'] ? 'match' : 'no match';

        // Compare les dates de sortie des deux films
        $compareDate = $comparedMovie['release_date'];
        $movieDate = $randomMovie['release_date'];
        
        if ($compareDate > $movieDate) {
            $compareData['release_date'] = 'later';
        } else if ($compareDate < $movieDate) {
            $compareData['release_date'] = 'earlier';
        } else {
            $compareData['release_date'] = 'same';
        }

        // Si les titres correspondent, génère un nouveau film aléatoire pour la session
        if ($compareData['title'] === 'match') {
            $_SESSION['randomMovie'] = $this->getRandomMovie();
            $compareData['debugRandomMovie'] = $_SESSION['randomMovie']['title'];
        }

        echo json_encode($compareData); // Renvoie les résultats de la comparaison en JSON

    }

    // Méthode pour obtenir le film actuel stocké en session
    public function getCurrentMovie()
    {
        return $_SESSION['randomMovie'];
    }

}
?>
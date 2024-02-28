<?php
require_once('vendor/autoload.php');
require_once('Controler/TMDB.php');


echo '<br> <br> Results for searchMovies: <br>';
$movies = TMDB::searchMovies('matrix');
foreach($movies as $movie) {

    $movieFull = TMDB::getMovie($movie->id);
    echo $movieFull['title'] . ' ';
    echo $movieFull['release_date'] . ' ';
    echo $movieFull['original_language'] . '<br>';
    echo $movieFull['overview'] . '<br>';
    echo '<img src="https://image.tmdb.org/t/p/w500/' . $movieFull['poster_path'] . '" width="100"><br>';
    echo 'Directors: ';
    foreach($movieFull['directors'] as $director) {
        echo $director . ' / ';
    }
    echo '<br>';
    echo 'Genres: ';
    foreach($movieFull['genres'] as $genre) {
        echo $genre . ' / ';
    }
    echo '<br>';
}

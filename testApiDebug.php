<?php
require_once('vendor/autoload.php');
require_once('Controler/TMDB.php');


echo "genres: ";
$genres = TMDB::getGenres(603);
foreach($genres as $genre) {
    echo $genre . ' / ';
}

echo '<br>';

echo "directors: ";
$directors = TMDB::getDirectors(603);
foreach($directors as $director) {
    echo $director . ' / ';
}

echo '<br> <br> Results for searchMovies: <br>';
$movies = TMDB::searchMovies('matrix');
foreach($movies as $movie) {
    echo $movie->title . ' ';
    echo $movie->release_date . ' ';
    echo $movie->original_language . '<br>';
    echo '<img src="https://image.tmdb.org/t/p/w500/' . $movie->poster_path . '" width="100"><br>';
    
    echo $movie->overview . '<br>';
    
    echo '<br>';
}

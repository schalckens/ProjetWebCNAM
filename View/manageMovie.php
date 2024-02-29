<main>
    <h1>Back Office</h1>
    <section>
        <h2>Gestion des films</h2>
    </section>

<form method="POST" action="/manageMovie">
    <input type="text" name="movieName" placeholder="Nom de film" required>
    <button type="submit">Rechercher</button>
</form>

<?php

if (isset($moviesSearch) && !empty($moviesSearch))
{
    echo '<ul>';
    foreach ($moviesSearch as $movie) {
        echo '<li>';
        echo $movie->title . ' ' . $movie->release_date . ' ' . $movie->original_language . '<br>'; 
        echo '<img src="https://image.tmdb.org/t/p/w500/' . $movie->poster_path . '" width="100">' . '<br>';
        echo '<a href="/manageMovie/add/' . htmlspecialchars($movie->id) . '">Add movie</a>';
        echo '</li>';
    }
    echo '</ul>';
}
?>
</main>
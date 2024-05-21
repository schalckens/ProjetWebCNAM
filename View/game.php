<?php
include 'View/header.php';
?>

<?php
echo '<div id="randomMovie">' . $_SESSION["randomMovie"]["title"] . '</div>';
?>

<body>
    <input type="text" name="movieName" id="inputMovie" placeholder="Nom de film">
    <select class="form-select form-select-lg mb-3" id="movieTitles" size="5"></select>
    <div id="movieInfo"></div>
</body>

<?php
require_once 'Includes/Resources.php';
?>

<script>
    $("#inputMovie").on("input", function () {
        var movieName = $("#inputMovie").val();
        if (movieName === "") {
            $("#movieTitles").empty();
            return;
        }

        $.ajax({
            url: "/gameMovie/search/" + movieName,
            method: "GET",
            success: function (response) {
                try {
                    var movies = JSON.parse(response);
                    $("#movieTitles").empty();

                    if (movies.length !== 0) {
                        movies.forEach(function (movie) {
                            $("#movieTitles").append('<option value="' + movie.title + '">' + movie.title + '</option>');
                        });
                    } else {
                        $("#movieTitles").empty();
                        $("#movieTitles").append("<option>No movie found</option>");
                    }
                } catch (error) {
                    console.error("Invalid JSON format:", error);
                }
            }
        });
    });

    $('#movieTitles').on('change', function () {
        var movieName = $(this).val();
        $.ajax({
            url: "/gameMovie/compareMovie/" + movieName,
            method: "GET",
            success: function (response) {
                if (response === "false") {
                    alert("Dommage, ce n'est pas le bon film.");
                } else {
                    var movie = JSON.parse(response);
                    alert("Bravo, vous avez trouvé le bon film !");
                    $("#randomMovie").text(movie.title);
                    showMovieCard(movie);
                }
            }
        });
    });

    function showMovieCard(movie) {
        var htmlContent = `<div class="card" style="width: 16rem;">
            <img class="card-img-top" src="${movie.poster_path}" alt="Movie poster image">
            <div class="card-body">
                <h5 class="card-title">Titre : ${movie.title}</h5>
                <p class="card-text">Résumé : ${movie.overview}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Date de sortie : ${movie.release_date}</li>
                <li class="list-group-item">Genre : ${movie.movie_genre}</li>
                <li class="list-group-item">Pays : ${movie.movie_country}</li>
                <li class="list-group-item">Langue originale : ${movie.original_language}</li>
                <li class="list-group-item">Réalisateurs : ${movie.movie_director}</li>
                <li class="list-group-item">Acteurs : ${movie.movie_actors}</li>
                <li class="list-group-item">Production : ${movie.movie_production}</li>
            </ul>
            </div>`;
        document.getElementById("movieInfo").innerHTML = htmlContent;
    }
</script>

<?php
include 'View/footer.php';
?>
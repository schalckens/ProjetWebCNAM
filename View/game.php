<?php
include 'View/header.php';
?>

<body>
    <div style="margin: 2% 15% 5% 15%">
        <h1>Le Mystère du Film du Jour</h1>
        <p>Bienvenue, détectives cinéphiles,</p>
        <p>Chaque jour, un nouveau mystère vous attend. Votre mission, si vous l'acceptez, est de deviner le film du jour. Entrez le titre du film que vous pensez être le bon, et nous vous donnerons des indices pour vous guider vers la solution. Utilisez votre sens de la déduction et votre connaissance du cinéma pour résoudre l'énigme. Bonne chance !</p>
        
        <label for="film-guess"><h2>Entrez le titre du film :<h2></label>
        <input type="text" name="movieName" id="inputMovie" placeholder="Nom de film">
        <select class="form-select form-select-lg mb-3" id="movieTitles" size="5"></select>
        <div id="movieInfo"></div>
    </div>
</body>

<?php
require_once 'Includes/Resources.php';
?>

<script>
    var currentMovie;

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

    $('#movieTitles').on('click', function() {
        var movieName = $(this).val();
        $.ajax({
            url: "/gameMovie/getMovieDetails/" + movieName,
            method: "GET",
            success: function(response) {
                try {
                    var movie = JSON.parse(response);
                    console.log(movie);
                    showMovieCard(movie);
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
                compareData = JSON.parse(response);
                console.log(compareData)
                if(compareData.title == 'match')
                {
                    alert("Bravo, vous avez trouvé le bon film !");
                }
                else{
                    alert("Dommage, ce n'est pas le bon film.");
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
                <li class="list-group-item">Genres : 
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
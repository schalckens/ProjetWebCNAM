<?php
include 'View/header.php';
?>

<body>
    <div style="margin: 2% 15% 5% 15%">
        <h1>Le Mystère du Film du Jour</h1>
        <p>Bienvenue, détectives cinéphiles,</p>
        <p>Chaque jour, un nouveau mystère vous attend. Votre mission, si vous l'acceptez, est de deviner le film du jour. Entrez le titre du film que vous pensez être le bon, et nous vous donnerons des indices pour vous guider vers la solution. Cependant, chaque nouvelle tentative remplace les indices précédents, alors faites travailler votre mémoire ou préparez votre carnet pour prendre des notes. Utilisez votre sens de la déduction et votre connaissance du cinéma pour résoudre l'énigme. Bonne chance !</p>
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
    var compareData = {};

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

        var actorsList = "<ul>";
            movie.actors.forEach(function(actor) {
                var match = "";
                if(compareData.matchedActors !== undefined && compareData.matchedActors[actor.name] !== undefined)
                {
                    match = "match";
                }

                actorsList += "<li>" + actor.name + " (" + match + ")" + "</li>";
            });
            actorsList += "</ul>";

        var genreList = "<ul>";
            movie.genres.forEach(function(genre) {
                var match = "";
                if(compareData.matchedGenres !== undefined && compareData.matchedGenres[genre.name] !== undefined)
                {
                    match = "match";
                }

                genreList += "<li>" + genre.name + " (" + match + ")" + "</li>";
            });
            genreList += "</ul>";

        var countryList = "<ul>";
            movie.countries.forEach(function(country) {
                var match = "";
                if(compareData.matchedCountries !== undefined && compareData.matchedCountries[country.name] !== undefined)
                {
                    match = "match";
                }

                countryList += "<li>" + country.name + " (" + match + ")" + "</li>";
            });
            countryList += "</ul>";
        
        
        var directorList = "<ul>";
            movie.directors.forEach(function(director) {
                var match = "";
                if(compareData.matchedDirectors !== undefined && compareData.matchedDirectors[director.name] !== undefined)
                {
                    match = "match";
                }

                directorList += "<li>" + director.name + " (" + match + ")" + "</li>";
            });
            directorList += "</ul>";

        var productionList = "<ul>";
            movie.production_companies.forEach(function(production) {
                var match = "";
                if(compareData.matchedProductionCompanies !== undefined && compareData.matchedProductionCompanies[production.name] !== undefined)
                {
                    match = "match";
                }
                productionList += "<li>" + production.name + " (" + match + ")" + "</li>";
            });
            productionList += "</ul>";

        

        
        var htmlContent = `<div class="card" style="width: 30rem;">
            <img class="card-img-top" src="${movie.poster_path}" alt="Movie poster image">
            <div class="card-body">
                <h5 class="card-title">Titre : ${movie.title}</h5>
                <p class="card-text">Résumé : ${movie.overview}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Date de sortie : ${movie.release_date} (${compareData.release_date})</li>
                <li class="list-group-item">Genres : ${genreList}</li>
                <li class="list-group-item">Pays : ${countryList}</li>
                <li class="list-group-item">Langue originale : ${movie.original_language}</li>
                <li class="list-group-item">Réalisateurs : ${directorList}</li>
                <li class="list-group-item">Acteurs : ${actorsList}</li>
                <li class="list-group-item">Production : ${productionList}</li>
            </ul>
            </div>`;
      
        document.getElementById("movieInfo").innerHTML = htmlContent;
    }
</script>

<?php
include 'View/footer.php';
?>
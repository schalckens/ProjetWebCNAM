<?php
include 'View/header.php'; // Inclure l'en-tête de la vue
?>

<div style="margin: 2% 15% 5% 15%">
    <h1>Le Mystère du Film</h1>
    <p>Bienvenue, détectives cinéphiles,</p>
    <!-- Paragraphe d'introduction au jeu -->
    <p>Un mystère sans fin vous attend. Votre mission, si vous l'acceptez, est de deviner le film actuel. Entrez le titre du film que vous pensez être le bon, et nous vous donnerons des indices pour vous guider vers la solution. Cependant, chaque nouvelle tentative remplace les indices précédents, alors faites travailler votre mémoire ou préparez votre carnet pour prendre des notes. Lorsque vous trouvez le bon film, un nouveau mystère commence. Utilisez votre sens de la déduction et votre connaissance du cinéma pour résoudre l'énigme. Bonne chance !</p>
    <h2><label for="inputMovie">Entrez le titre du film :</label></h2>
    <!-- Champ de saisie pour entrer le titre du film -->
    <input type="text" name="movieName" id="inputMovie" placeholder="Nom de film">
    <!-- Liste déroulante pour afficher les titres de films suggérés -->
    <select class="form-select form-select-lg mb-3" id="movieTitles" size="5"></select>
    <!-- Section pour afficher les informations du film -->
    <div id="movieInfo"></div>
</div>

<?php
require_once 'Includes/Resources.php'; // Inclure les ressources nécessaires
?>

<script>
    var compareData = {};

    // Événement sur la saisie dans le champ de texte pour rechercher des films
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

    // Événement sur le clic d'un titre de film pour obtenir les détails du film
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

    // Événement sur le changement de sélection de film pour comparer le film
    $('#movieTitles').on('change', function () {
        var movieName = $(this).val();
        $.ajax({
            url: "/gameMovie/compareMovie/" + movieName,
            method: "GET",
            success: function (response) {
                compareData = JSON.parse(response);
                console.log(compareData);
                if(compareData.title == 'match') {
                    alert("Bravo, vous avez trouvé le bon film !");
                }
            }
        });
    });

    // Générer une liste HTML d'éléments
    function generateList(items, matchedItems) {
        var list = "<ul>";
        items.forEach(function(item) {
            var match = "";
            var color = "red";
            if(matchedItems !== undefined && matchedItems[item.name] !== undefined) {
                match = "match";
                color = "green";
            }
            list += "<li style='color: " + color + ";'>" + item.name + "</li>";
        });
        list += "</ul>";
        return list;
    }

    // Afficher la carte du film avec les détails
    function showMovieCard(movie) {
        var actorsList = generateList(movie.actors, compareData.matchedActors);
        var genreList = generateList(movie.genres, compareData.matchedGenres);
        var countryList = generateList(movie.countries, compareData.matchedCountries);
        var directorList = generateList(movie.directors, compareData.matchedDirectors);
        var productionList = generateList(movie.production_companies, compareData.matchedProductionCompanies);
        var language = `<span style="color: ${compareData.original_language === "match" ? 'green' : 'red'}">${movie.original_language}</span>`;

        var htmlContent = `
<div class="card mb-3" style="width: 100%;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="${movie.poster_path}" class="img-fluid rounded-start" alt="Movie poster image">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h2 class="card-title">${movie.title}</h2>
                <p class="card-text">Résumé : ${movie.overview}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Date de sortie : ${movie.release_date} (This movie came out ${compareData.release_date})</li>
                <li class="list-group-item">Genres : ${genreList}</li>
                <li class="list-group-item">Pays : ${countryList}</li>
                <li class="list-group-item">Langue originale : ${language} </li>
                <li class="list-group-item">Réalisateurs : ${directorList}</li>
                <li class="list-group-item">Acteurs : ${actorsList}</li>
                <li class="list-group-item">Production : ${productionList}</li>
            </ul>
        </div>
    </div>
</div>`;

        document.getElementById("movieInfo").innerHTML = htmlContent;
    }
</script>

<?php
include 'View/footer.php'; // Inclure le pied de page de la vue
?>

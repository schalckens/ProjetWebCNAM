<?php
include 'View/header.php';
?>


<div style="margin: 2% 15% 5% 15%">
    <h1>Le Mystère du Film</h1>
    <p>Bienvenue, détectives cinéphiles,</p>
    <!-- <img src="View/imgs/c4.jpg" alt="Conan cine"> -->
    <p>Un mystère sans fin vous attend. Votre mission, si vous l'acceptez, est de deviner le film actuel. Entrez le titre du film que vous pensez être le bon, et nous vous donnerons des indices pour vous guider vers la solution. Cependant, chaque nouvelle tentative remplace les indices précédents, alors faites travailler votre mémoire ou préparez votre carnet pour prendre des notes. Lorsque vous trouvez le bon film, un nouveau mystère commence. Utilisez votre sens de la déduction et votre connaissance du cinéma pour résoudre l'énigme. Bonne chance !</p>
    <h2><label for="inputMovie">Entrez le titre du film :</label></h2>
    <input type="text" name="movieName" id="inputMovie" placeholder="Nom de film">
    <select class="form-select form-select-lg mb-3" id="movieTitles" size="5"></select>
    <div id="movieInfo"></div>
</div>

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
            }
        });
    });

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

    function showMovieCard(movie) {

        var actorsList = generateList(movie.actors, compareData.matchedActors);

        var genreList = generateList(movie.genres, compareData.matchedGenres);

        var countryList = generateList(movie.countries, compareData.matchedCountries);
        
        
        var directorList = generateList(movie.directors, compareData.matchedDirectors);

        var productionList = generateList(movie.production_companies, compareData.matchedProductionCompanies);

        var language = `<span style="color: ${compareData.original_language === "match" ? 'green' : 'red'}">${movie.original_language}</span>`;
        

        
        var htmlContent = `
<div class="card" style="width: 60rem;">
    <div class="row no-gutters">
        <div class="col-md-6">
            <img class="card-img-top" src="${movie.poster_path}" alt="Movie poster image" style="width: 100%; height: auto;">
        </div>
        <div class="col-md-6">
            <div class="card-body">
                <h2 class="card-title">${movie.title}</h2>
                <p class="card-text" style="font-size: 1rem;">Résumé : ${movie.overview}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item" style="font-size: 1rem;">Date de sortie : ${movie.release_date} (This movie came out ${compareData.release_date})</li>
                <li class="list-group-item" style="font-size: 1rem;">Genres : ${genreList}</li>
                <li class="list-group-item" style="font-size: 1rem;">Pays : ${countryList}</li>
                <li class="list-group-item" style="font-size: 1rem;">Langue originale : ${language} </li>
                <li class="list-group-item" style="font-size: 1rem;">Réalisateurs : ${directorList}</li>
                <li class="list-group-item" style="font-size: 1rem;">Acteurs : ${actorsList}</li>
                <li class="list-group-item" style="font-size: 1rem;">Production : ${productionList}</li>
            </ul>
        </div>
    </div>
</div>`;
      
        document.getElementById("movieInfo").innerHTML = htmlContent;
    }
</script>

<?php
include 'View/footer.php';
?>
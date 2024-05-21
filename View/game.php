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
                    alert("Bravo, vous avez trouvé le bon film !");
                    $("#randomMovie").text(JSON.parse(response).title);
                }
            }
        });
    });
</script>


<?php
include 'View/footer.php';
?>
<?php
    include 'View/header.php';
?>

<?php
    echo '<div id="randomMovie">' . $_SESSION["randomMovie"]["title"] . '</div>';
?>

<body>
    <input type="text" name="movieName" id="inputMovie" placeholder="Nom de film">
    <ul id="movieTitles"></ul>
</body>

<?php
 require_once 'Includes/Resources.php';
?>

<script>
    $("#inputMovie").on("input", function(){
        var movieName = $("#inputMovie").val();
        if(movieName === "") {
            $("#movieTitles").empty();
            return;
        }

        $.ajax({
            url: "/gameMovie/search/" + movieName,
            method: "GET",
            success: function(response) {
                try {
                    var movies = JSON.parse(response);
                    $("#movieTitles").empty();

                    if (movies.length !== 0) {
                        movies.forEach(function(movie) {
                            $("#movieTitles").append('<li><img src="' + movie.poster_path + '" width="20">' + '<span>' + movie.title + "</span><input type='button' id='buttonMovieSelection' value='Select'/></li>");
                        });
                    } else {
                        $("#movieTitles").empty();
                        $("#movieTitles").append("<li>No movie found</li>");
                    }
                } catch (error) {
                    console.error("Invalid JSON format:", error);
                }
            }
        });
    });

    $('#movieTitles').on('click', '#buttonMovieSelection', function() {
        var movieName = $(this).prev().text();
        $.ajax({
            url: "/gameMovie/compareMovie/" + movieName,
            method: "GET",
            success: function(response) {
                if(response === "false") {
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
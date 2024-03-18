<?php
    include 'View/header.php';
?>

<?php
    echo $_SESSION["randomMovie"];
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
                console.log(response);
            }
        });
    });
</script>

<?php
    include 'View/footer.php';
?>
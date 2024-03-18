<?php
    include 'View/header.php';
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
        console.log(movieName);
        $.ajax({
            url: "/gameMovie/search/" + movieName,
            method: "GET",
            success: function(response) {
                var movies = JSON.parse(response);
                $("#movieTitles").empty();

                if (movies.lenght !== 0) {
                    movies.forEach(function(movie) {
                        $("#movieTitles").append('<li><img src="https://image.tmdb.org/t/p/w500/' + movie.poster_path + '" width="20">' + '<span>' + movie.title + "</span><button>Select</button></li>");
                    });
                }
            }
        });
    });
</script>

<?php
    include 'View/footer.php';
?>
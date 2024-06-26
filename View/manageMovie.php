<?php
    include 'View/header.php'; // Inclure l'en-tête de la vue
?>

<main style="margin: 2% 15% 5% 15%">
    <h1>Back Office</h1>
    <section>
        <h2>Gestion des films</h2>
    </section>

    <!-- Formulaire de recherche de films -->
    <form method="POST" action="/manageMovie">
        <input type="text" name="movieName" placeholder="Nom de film" required>
        <button type="submit">Rechercher</button>
    </form>

    <!-- Lien pour effacer la recherche -->
    <a href="/manageMovie/clearSearch">Clear search</a>

    <?php
    // Affichage des résultats de la recherche de films
    if (isset($_SESSION['movieSearch']) && !empty($_SESSION['movieSearch']))
    {
        echo '<ul>';
        foreach ($_SESSION['movieSearch'] as $movie) {
            echo '<li>';
            echo $movie->title . ' ' . $movie->release_date . ' ' . $movie->original_language . '<br>'; 
            echo '<img src="https://image.tmdb.org/t/p/w500/' . $movie->poster_path . '" width="100">' . '<br>';
            echo '<a href="/manageMovie/add/' . htmlspecialchars($movie->id) . '">Add movie</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>

    <section>
        <h2>Liste des films</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre film</th>
                    <th>Date de sortie</th>
                    <th>Langue</th>
                    <th>Poster path</th>
                </tr>
            </thead>
            <tbody>
            <!-- Affichage de la liste des films -->
            <?php if (isset($_SESSION['movies']) && !empty($_SESSION['movies'])): ?>
                <?php foreach ($_SESSION['movies'] as $movie): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($movie['id']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($movie['title']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($movie['release_date']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($movie['original_language']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($movie['poster_path']); ?>
                        </td>
                        <td>
                            <!-- Lien pour supprimer un film avec confirmation -->
                            <a href="/manageMovie/delete/<?php echo htmlspecialchars($movie['id']); ?>"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?');">Supprimer</a>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php
    include 'View/footer.php'; // Inclure le pied de page de la vue
?>

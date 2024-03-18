<?php
include 'View/header.php';
?>

<div class="container">
    <h2>Bienvenu sur la partie Administration !</h2>
    <section>
        <article>
            <h2>Gerer les comptes utilisateurs</h2>
            <p><a class="btn btn-outline-secondary" href="/manageUser">Gérer les utilisateurs</a></p>
        </article>
        <article>
            <h2>Gestion des films</h2>
            <p><a class="btn btn-outline-secondary" href="/manageMovie">Gérer les films</a></p>
        </article>
    </section>
</div>

<?php
include 'View/footer.php';
?>
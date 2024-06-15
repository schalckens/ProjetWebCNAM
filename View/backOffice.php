<?php
include 'View/header.php'; // Inclure l'en-tête de la vue
?>

<div style="margin: 2% 15% 5% 15%">
    <h1>Bienvenue dans la partie administration</h1>
    <p>Bonjour, chers détectives administrateurs,</p>
    <p>Je suis Conan, et je suis ravi de vous accueillir dans cette section spéciale de notre site. Ici, vous avez les pleins pouvoirs pour gérer notre communauté et notre collection de films. Utilisez vos compétences de déduction et votre sens de la justice pour maintenir l'ordre et la qualité sur "Detective du Cinéma".</p>

    <div>
        <article>
            <h2>Gérer les utilisateurs</h2>
            <p>Dans cette section, vous pouvez ajouter, supprimer ou modifier les comptes des utilisateurs. Chaque détective en herbe mérite un traitement juste, alors assurez-vous d'examiner chaque compte avec attention. Que ce soit pour récompenser une bonne conduite ou rectifier un comportement inapproprié, votre rôle est crucial pour maintenir l'harmonie dans notre communauté.</p>
            <p><a class="btn btn-outline-secondary" href="/manageUser">Gérer les utilisateurs</a></p> <!-- Lien vers la gestion des utilisateurs -->
        </article>
        <article>
            <h2>Gérer les films</h2>
            <p>Voici le cœur de notre enquête cinématographique. En tant qu'administrateurs, vous avez le pouvoir d'ajouter de nouveaux films à notre base de données ou de supprimer ceux qui ne sont plus pertinents. Assurez-vous que chaque ajout soit une nouvelle énigme palpitante pour nos détectives. Votre vigilance garantit que "Detective du Cinéma" reste un défi stimulant et amusant pour tous.</p>
            <p><a class="btn btn-outline-secondary" href="/manageMovie">Gérer les films</a></p> <!-- Lien vers la gestion des films -->
        </article>
    </div>
</div>

<?php
include 'View/footer.php'; // Inclure le pied de page de la vue
?>

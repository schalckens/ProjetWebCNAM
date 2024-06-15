<?php
include 'View/header.php'; // Inclure l'en-tête de la vue
?>

<div data-bs-theme="dark" style="margin: 2% 15% 5% 15%">
    <h2>Gérer les utilisateurs</h2>

    <!-- Formulaire pour ajouter un nouvel utilisateur -->
    <section>
        <h3>Ajouter un utilisateur</h3>
        <form action="/manageUser/add" method="post" id="form">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <!-- Champ de saisie pour le nom d'utilisateur -->
                <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                    aria-label="Nom d'utilisateur" aria-describedby="basic-addon1" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">✉️</span>
                <!-- Champ de saisie pour l'email -->
                <input type="email" name="mail" class="form-control" placeholder="Email" aria-label="Email"
                    aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon3">🔒</span>
                <!-- Champ de saisie pour le mot de passe -->
                <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                    aria-label="Mot de passe" aria-describedby="basic-addon1" id="password">
            </div>
            <div>
                <!-- Sélection pour définir si l'utilisateur est administrateur -->
                <label>Administrateur :</label>
                <select class="form-select" name="isAdmin">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-secondary">Ajouter</button>
        </form>
    </section>
    <br>
    <!-- Affichage de la liste des utilisateurs existants -->
    <section>
        <h3>Liste des Utilisateurs</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom d'utilisateur</th>
                    <th scope="col">Email</th>
                    <th scope="col">Administrateur</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Boucle pour afficher chaque utilisateur -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <th scope="row">
                            <?php echo htmlspecialchars($user['id']); ?>
                        </th>
                        <td>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($user['mail']); ?>
                        </td>
                        <td>
                            <?php echo $user['isAdmin'] ? 'Oui' : 'Non'; ?>
                        </td>
                        <td>
                            <!-- Liens pour modifier ou supprimer un utilisateur -->
                            <a href="/manageUser/edit/<?php echo htmlspecialchars($user['id']); ?>">Modifier</a>
                            <?php if (!isset($user['isAdmin']) || $user['isAdmin'] == 0): ?>
                                <a href="/manageUser/delete/<?php echo htmlspecialchars($user['id']); ?>"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<div class="container">
    <!-- Inclusion de jQuery et du script de validation de mot de passe -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="passwordValidation.js"></script>
</div>

<?php
include 'View/footer.php'; // Inclure le pied de page de la vue
?>

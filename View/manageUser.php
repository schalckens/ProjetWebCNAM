<?php
include 'View/header.php';
?>

<main>
    <h1>Gérer les utilisateurs</h1>

    <!-- Formulaire pour ajouter un nouvel utilisateur -->
    <section>
        <h2>Ajouter un utilisateur</h2>
        <form action="/manageUser/add" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="email" name="mail" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <div>
                <label>Administrateur :</label>
                <select name="isAdmin">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </section>

    <!-- Affichage de la liste des utilisateurs existants -->
    <section>
        <h2>Liste des Utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Administrateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($user['id']); ?>
                        </td>
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
                            <a href="/manageUser/edit/<?php echo htmlspecialchars($user['id']); ?>">Modifier</a>
                            <?php if (!isset ($user['isAdmin']) || $user['isAdmin'] == 0): ?>
                                <a href="/manageUser/delete/<?php echo htmlspecialchars($user['id']); ?>"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </section>
</main>

<?php
include 'View/footer.php';
?>
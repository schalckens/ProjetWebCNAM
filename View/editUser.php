<?php
    include 'View/header.php';
?>

<main>
    <h1>Modifier l'Utilisateur</h1>
    <form action="/manageUser/edit/<?php echo htmlspecialchars($user['id']); ?>" method="post">
        <div>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div>
            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($user['mail']); ?>" required>
        </div>
        <div>
            <label for="isAdmin">Administrateur:</label>
            <input type="checkbox" id="isAdmin" name="isAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>>
        </div>
        <div>
            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer):</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
</main>

<?php
    include 'View/footer.php';
?>
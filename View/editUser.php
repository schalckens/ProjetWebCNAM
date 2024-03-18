<?php
    include 'View/header.php';
?>

<div class="container">
    <h2>Modifier l'Utilisateur</h2>
    <form action="/manageUser/edit/<?php echo htmlspecialchars($user['id']); ?>" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">✉️</span>
            <input type="email" name="mail" class="form-control" placeholder="Email" aria-label="Email"
                aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($user['mail']); ?>" required>
        </div>
        <div  class="form-check">
            <label class="form-check-label" for="isAdmin">Administrateur:</label>
            <input class="form-check-input"  type="checkbox" id="isAdmin" name="isAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Mot de passe" aria-describedby="basic-addon1" id="password">
        </div>
        <button type="submit" class="btn btn-outline-secondary">Mettre à jour</button>
    </form>
</div>

<?php
    include 'View/footer.php';
?>
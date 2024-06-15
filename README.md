# ProjetWebCNAM

## Introduction

Ce projet web interactif invite les utilisateurs à deviner un film mystère. Les utilisateurs peuvent s'inscrire, se connecter et jouer au jeu. Les administrateurs ont des privilèges supplémentaires pour gérer les utilisateurs et les films via un back-office.

Le site est accessible à l'adresse suivante : [Detective du Cinéma](https://detective-du-cinema.alwaysdata.net/)

## Connexions

### Admin
- **Pseudo**: conan
- **Mot de passe**: Azerty1$

### Utilisateur
- **Pseudo**: detective
- **Mot de passe**: Azerty1$

## Fonctionnalités

### Pour les utilisateurs

Les utilisateurs peuvent jouer au jeu en tentant de deviner le film mystère. Ils peuvent :
1. Entrer le nom d'un film dans le champ de recherche.
2. Si ce n'est pas le bon film, des informations sur le film soumis sont affichées.
3. Les informations en rouge sont différentes du film à trouver et celles en vert sont identiques.
4. Utiliser ces indices pour affiner leurs suppositions jusqu'à ce qu'ils trouvent le bon film.

### Pour les administrateurs

En plus des fonctionnalités utilisateur, les administrateurs ont accès à un back-office où ils peuvent gérer les utilisateurs et les films.

#### Gestion des utilisateurs

Les administrateurs peuvent :
- Ajouter un nouvel utilisateur.
- Modifier les informations d'un utilisateur, y compris son pseudo, son mot de passe, son statut d'administrateur et son état de vérification par mail.
- Supprimer des utilisateurs.

#### Gestion des films

Les administrateurs peuvent :
- Rechercher un film à ajouter via un champ de texte.
- Ajouter le film sélectionné à la base de données du site.
- Voir la liste de tous les films ajoutés.
- Supprimer des films de la liste.

## Utilisation du site

1. **Se connecter** :
   - Utilisez les identifiants fournis pour vous connecter en tant qu'administrateur ou utilisateur.
2. **Accéder au jeu** :
   - Une fois connecté, allez dans la section jeu pour commencer à deviner le film mystère.
3. **Back-office (admin seulement)** :
   - Les administrateurs peuvent accéder au back-office pour gérer les utilisateurs et les films.

### Précisions supplémentaires

- **Thème du site** : Le site est inspiré par l'univers du détective Conan. Il offre une ambiance mystérieuse et engageante pour les utilisateurs.
- **Absence de logs** : Pour rester fidèle à l'ambiance de détective, nous avons choisi de ne pas enregistrer de logs lors de la recherche de films.

Plongez dans l'aventure du "Detective du Cinéma" et utilisez votre sens de la déduction pour résoudre les mystères cinématographiques. Que la chasse commence !

## Technologies utilisées

- **Modèle MVC** pour structurer l’application
- **HTML/CSS** pour le front-end
- **PHP** sans framework pour le back-end
- **Wampserver** en tant que serveur web local pour le développement
- **MySQL** pour la base de données
- **API TMDB** pour alimenter la base de données en films

